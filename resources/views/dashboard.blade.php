@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Consumption Dashboard</h1>

    @if($alertsCount > 0)
        <a href="{{ route('alerts.index') }}" class="inline-block mb-4 px-4 py-2 bg-amber-100 text-amber-800 rounded">
            {{ $alertsCount }} unread alert(s)
        </a>
    @endif

    @if($forecast['sample_size'] > 0)
        <section class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-2">Next month forecast</h2>
            <p class="text-2xl font-bold text-blue-600">AED {{ number_format($forecast['amount'], 2) }}</p>
            <p class="text-sm text-gray-500">Based on {{ $forecast['sample_size'] }} past bill(s) · Confidence {{ number_format($forecast['confidence'] * 100) }}%</p>
        </section>
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <section class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Monthly consumption</h2>
            <div id="consumption-chart" class="h-64" data-months="{{ json_encode($consumptionByMonth) }}"></div>
        </section>
        <section class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Recent bills</h2>
            <ul class="space-y-2">
                @forelse($recentBills as $bill)
                    <li class="flex justify-between">
                        <span>{{ $bill->bill_date->format('M Y') }} ({{ strtoupper($bill->provider) }})</span>
                        <span>AED {{ number_format($bill->amount, 2) }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No bills yet. <a href="{{ route('bills.create') }}" class="text-blue-600">Upload one</a>.</li>
                @endforelse
            </ul>
        </section>
    </div>
</div>
@endsection
