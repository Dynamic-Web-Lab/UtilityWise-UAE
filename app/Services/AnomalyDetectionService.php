<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnomalyDetectionService
{
    private function aiServiceUrl(): string
    {
        return rtrim(config('services.ai.url', 'http://localhost:8001'), '/');
    }

    /**
     * Check if the given bill amount is anomalous vs user's history.
     * Optionally call AI service for ML-based detection.
     */
    public function checkAnomaly(User $user, Bill $bill, float $thresholdPercent = 30.0): ?Alert
    {
        $historical = $user->bills()
            ->where('id', '!=', $bill->id)
            ->where('provider', $bill->provider)
            ->pluck('amount')
            ->filter()
            ->values();

        if ($historical->isEmpty()) {
            return null;
        }

        $avg = $historical->avg();
        if ($avg <= 0) {
            return null;
        }

        $percentChange = (($bill->amount - $avg) / $avg) * 100;
        if ($percentChange <= $thresholdPercent) {
            return null;
        }

        $alert = $user->alerts()->create([
            'bill_id' => $bill->id,
            'type' => 'anomaly',
            'message' => sprintf(
                'Bill amount (AED %s) is %.1f%% higher than your average for %s.',
                number_format($bill->amount, 2),
                $percentChange,
                strtoupper($bill->provider)
            ),
            'threshold_percent' => $thresholdPercent,
        ]);

        return $alert;
    }

    /**
     * Call AI service for anomaly detection (Phase 1: optional).
     */
    public function checkAnomalyViaAi(User $user, Bill $bill): ?Alert
    {
        $url = $this->aiServiceUrl() . '/anomaly';
        $response = Http::timeout(10)->post($url, [
            'user_id' => $user->id,
            'bill_id' => $bill->id,
            'amount' => $bill->amount,
            'provider' => $bill->provider,
        ]);

        if (! $response->successful()) {
            Log::warning('AI anomaly check failed', ['status' => $response->status()]);
            return $this->checkAnomaly($user, $bill);
        }

        $data = $response->json();
        if (empty($data['is_anomaly'])) {
            return null;
        }

        return $user->alerts()->create([
            'bill_id' => $bill->id,
            'type' => 'anomaly',
            'message' => $data['message'] ?? 'Unusual bill amount detected.',
            'threshold_percent' => $data['threshold_percent'] ?? null,
        ]);
    }
}
