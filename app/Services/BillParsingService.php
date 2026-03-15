<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillParsingService
{
    private function aiServiceUrl(): string
    {
        return rtrim(config('services.ai.url', 'http://localhost:8001'), '/');
    }

    /**
     * Send file to AI service for OCR and return extracted data.
     *
     * @return array{amount: float, bill_date: string, consumption_kwh: ?float, consumption_gallons: ?float, provider: string}
     */
    public function parseBill(string $filePath, string $provider): array
    {
        $url = $this->aiServiceUrl() . '/extract';
        $response = Http::timeout(30)
            ->attach('file', file_get_contents($filePath), basename($filePath))
            ->withOptions(['stream' => true])
            ->post($url, ['provider' => $provider]);

        if (! $response->successful()) {
            $status = $response->status();
            Log::warning('AI service OCR failed', ['status' => $status, 'body' => $response->body()]);

            if ($status >= 500) {
                throw new \RuntimeException('AI service is temporarily unavailable. Please try again later.');
            } elseif ($status >= 400) {
                throw new \RuntimeException('Unable to process the uploaded bill. Please ensure it is a valid PDF or image file.');
            }
            throw new \RuntimeException('Bill extraction failed. Please try again.');
        }

        $data = $response->json();
        return [
            'amount' => (float) ($data['amount'] ?? 0),
            'bill_date' => $data['bill_date'] ?? now()->format('Y-m-d'),
            'consumption_kwh' => isset($data['consumption_kwh']) ? (float) $data['consumption_kwh'] : null,
            'consumption_gallons' => isset($data['consumption_gallons']) ? (float) $data['consumption_gallons'] : null,
            'provider' => $provider,
        ];
    }

    public function createBillFromParsedData(User $user, array $parsed, ?string $filePath = null): Bill
    {
        return $user->bills()->create([
            'provider' => $parsed['provider'],
            'amount' => $parsed['amount'],
            'bill_date' => $parsed['bill_date'],
            'consumption_kwh' => $parsed['consumption_kwh'],
            'consumption_gallons' => $parsed['consumption_gallons'],
            'file_path' => $filePath,
        ]);
    }
}
