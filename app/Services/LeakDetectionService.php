<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LeakDetectionService
{
    private function aiServiceUrl(): string
    {
        return rtrim(config('services.ai.url', 'http://localhost:8001'), '/');
    }

    /**
     * Check if bill's water consumption suggests a leak; create alert if so.
     */
    public function checkWaterSpike(User $user, Bill $bill, float $currentGallons): ?Alert
    {
        if ($currentGallons <= 0) {
            return null;
        }

        $previousGallons = $user->consumptionRecords()
            ->where('bill_id', '!=', $bill->id)
            ->whereNotNull('gallons')
            ->where('gallons', '>', 0)
            ->orderByDesc('record_date')
            ->limit(12)
            ->pluck('gallons')
            ->map(fn ($v) => (float) $v)
            ->values()
            ->all();

        if (empty($previousGallons)) {
            return null;
        }

        $url = $this->aiServiceUrl() . '/leak-check';
        $response = Http::timeout(5)->post($url, [
            'current_gallons' => $currentGallons,
            'previous_gallons' => $previousGallons,
            'spike_factor' => 1.5,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (! empty($data['is_leak']) && ! empty($data['message'])) {
                return $user->alerts()->create([
                    'bill_id' => $bill->id,
                    'type' => 'leak',
                    'message' => $data['message'],
                    'threshold_percent' => null,
                ]);
            }
            return null;
        }

        return $this->checkWaterSpikeLocal($user, $bill, $currentGallons, $previousGallons);
    }

    private function checkWaterSpikeLocal(User $user, Bill $bill, float $currentGallons, array $previousGallons): ?Alert
    {
        $avg = array_sum($previousGallons) / count($previousGallons);
        if ($avg <= 0) {
            return null;
        }
        $ratio = $currentGallons / $avg;
        if ($ratio < 1.5) {
            return null;
        }
        return $user->alerts()->create([
            'bill_id' => $bill->id,
            'type' => 'leak',
            'message' => sprintf(
                'Water consumption (%.0f gal) is %.1fx your recent average (%.0f gal). Consider checking for leaks.',
                $currentGallons,
                $ratio,
                $avg
            ),
            'threshold_percent' => null,
        ]);
    }
}
