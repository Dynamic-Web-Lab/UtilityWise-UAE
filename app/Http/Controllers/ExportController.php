<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        return view('export.index');
    }

    /**
     * Export bills and consumption as CSV.
     */
    public function csv(Request $request): StreamedResponse
    {
        $user = $request->user();
        $bills = $user->bills()->orderBy('bill_date')->get();

        $filename = 'utilitywise-bills-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($bills): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Date', 'Provider', 'Amount (AED)', 'Consumption (kWh)', 'Consumption (gal)']);
            foreach ($bills as $bill) {
                fputcsv($out, [
                    $bill->bill_date->format('Y-m-d'),
                    strtoupper($bill->provider),
                    $bill->amount,
                    $bill->consumption_kwh ?? '',
                    $bill->consumption_gallons ?? '',
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Export as PDF-friendly HTML (user can Print → Save as PDF).
     */
    public function pdf(Request $request): View
    {
        $user = $request->user();
        $bills = $user->bills()->orderByDesc('bill_date')->get();

        return view('export.pdf', ['bills' => $bills]);
    }
}
