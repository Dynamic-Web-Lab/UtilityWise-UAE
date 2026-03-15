<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class ForecastService
{
    private function aiServiceUrl(): string
    {
        return rtrim(config('services.ai.url', 'http://localhost:8001'), '/');
    }

    /**
     * Get next-month bill forecast for the user (amount + confidence).
     *
     * @return array{amount: float, confidence: float, method: string, sample_size: int}
     */
    public function forecastForUser(User $user): array
    {
        $amounts = $user->bills()
            ->orderBy('bill_date')
            ->pluck('amount')
            ->map(fn ($v) => (float) $v)
            ->values()
            ->all();

        return $this->forecast($amounts);
    }

    /**
     * Call AI service or compute locally if unavailable.
     *
     * @param  array<float>  $amounts
     * @return array{amount: float, confidence: float, method: string, sample_size: int}
     */
    public function forecast(array $amounts): array
    {
        $url = $this->aiServiceUrl() . '/forecast';
        $response = Http::timeout(5)->post($url, ['amounts' => $amounts]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'amount' => (float) ($data['amount'] ?? 0),
                'confidence' => (float) ($data['confidence'] ?? 0),
                'method' => $data['method'] ?? 'weighted_avg',
                'sample_size' => (int) ($data['sample_size'] ?? count($amounts)),
            ];
        }

        return $this->forecastLocal($amounts);
    }

    /**
     * Local fallback: simple average when AI service is down.
     *
     * @param  array<float>  $amounts
     * @return array{amount: float, confidence: float, method: string, sample_size: int}
     */
    private function forecastLocal(array $amounts): array
    {
        if (empty($amounts)) {
            return ['amount' => 0.0, 'confidence' => 0.0, 'method' => 'none', 'sample_size' => 0];
        }
        $avg = array_sum($amounts) / count($amounts);
        return [
            'amount' => round($avg, 2),
            'confidence' => 0.5,
            'method' => 'local_avg',
            'sample_size' => count($amounts),
        ];
    }
}
