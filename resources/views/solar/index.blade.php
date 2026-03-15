@extends('layouts.app')

@section('title', 'Solar ROI Calculator')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-2">Solar ROI Calculator</h1>
    <p class="text-gray-600 text-sm mb-6">Basic estimate for UAE. Not financial advice — confirm with installers and current tariffs.</p>

    <form action="{{ route('solar.calculate') }}" method="GET" class="space-y-4 bg-white rounded-lg shadow p-6">
        <div>
            <label for="monthly_kwh" class="block text-sm font-medium text-gray-700">Average monthly consumption (kWh)</label>
            <input type="number" name="monthly_kwh" id="monthly_kwh" value="{{ old('monthly_kwh', $avgMonthlyKwh) }}" min="100" max="10000" step="50" required
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @if($avgMonthlyKwh)
                <p class="text-xs text-gray-500 mt-1">Pre-filled from your bill history.</p>
            @endif
        </div>
        <div>
            <label for="rate_per_kwh" class="block text-sm font-medium text-gray-700">Electricity rate (AED/kWh)</label>
            <input type="number" name="rate_per_kwh" id="rate_per_kwh" value="{{ old('rate_per_kwh', $typicalRateAedPerKwh) }}" min="0.1" max="2" step="0.01"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            <p class="text-xs text-gray-500 mt-1">Typical UAE grid rate; check your provider.</p>
        </div>
        <div>
            <label for="install_cost_per_kw" class="block text-sm font-medium text-gray-700">Install cost per kW (AED)</label>
            <input type="number" name="install_cost_per_kw" id="install_cost_per_kw" value="{{ old('install_cost_per_kw', $typicalInstallCostPerKw) }}" min="5000" max="25000" step="500"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <div>
            <label for="panel_kw" class="block text-sm font-medium text-gray-700">System size (kW) — optional</label>
            <input type="number" name="panel_kw" id="panel_kw" value="{{ old('panel_kw') }}" min="1" max="100" step="0.5" placeholder="Auto from consumption"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Estimate</button>
    </form>
</div>
@endsection
