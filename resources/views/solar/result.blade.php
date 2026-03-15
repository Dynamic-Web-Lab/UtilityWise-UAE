@extends('layouts.app')

@section('title', 'Solar ROI Result')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Solar ROI Estimate</h1>

    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <p><strong>System size:</strong> {{ number_format($panelKw, 1) }} kW</p>
        <p><strong>Estimated install cost:</strong> AED {{ number_format($totalCost) }}</p>
        <p><strong>Estimated monthly savings:</strong> AED {{ number_format($monthlySavings, 2) }}</p>
        <p><strong>Estimated annual savings:</strong> AED {{ number_format($annualSavings, 2) }}</p>
        <p><strong>Simple payback:</strong> ~{{ $paybackYears }} years</p>
    </div>

    <p class="mt-4 text-sm text-gray-500">Based on {{ $monthlyKwh }} kWh/month, AED {{ $ratePerKwh }}/kWh, AED {{ number_format($costPerKw) }}/kW install. Assumes ~4 sun hours/day. Actual results vary.</p>
    <a href="{{ route('solar.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Recalculate</a>
</div>
@endsection
