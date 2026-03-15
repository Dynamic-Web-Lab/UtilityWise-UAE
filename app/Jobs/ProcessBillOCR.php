<?php

namespace App\Jobs;

use App\Models\ConsumptionRecord;
use App\Services\AnomalyDetectionService;
use App\Services\BillParsingService;
use App\Services\LeakDetectionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessBillOCR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private \App\Models\User $user,
        private string $filePath,
        private string $provider,
        private ?string $storagePath = null
    ) {}

    public function handle(
        BillParsingService $billParsing,
        AnomalyDetectionService $anomaly,
        LeakDetectionService $leakDetection
    ): void {
        try {
            $parsed = $billParsing->parseBill($this->filePath, $this->provider);

            $bill = DB::transaction(function () use ($billParsing, $parsed) {
                $bill = $billParsing->createBillFromParsedData($this->user, $parsed, $this->storagePath);

                ConsumptionRecord::create([
                    'user_id' => $this->user->id,
                    'bill_id' => $bill->id,
                    'record_date' => $bill->bill_date,
                    'kwh' => $parsed['consumption_kwh'],
                    'gallons' => $parsed['consumption_gallons'],
                    'amount_aed' => $parsed['amount'],
                    'provider' => $this->provider,
                ]);

                return $bill;
            });

            $anomaly->checkAnomaly($this->user, $bill);

            if (isset($parsed['consumption_gallons']) && $parsed['consumption_gallons'] > 0) {
                $leakDetection->checkWaterSpike($this->user, $bill, (float) $parsed['consumption_gallons']);
            }
        } catch (\Throwable $e) {
            Log::error('ProcessBillOCR failed', [
                'user_id' => $this->user->id,
                'file_path' => $this->filePath,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
