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
            <div id="consumption-chart" class="h-64" data-months="{{ htmlspecialchars(json_encode($consumptionByMonth), ENT_QUOTES, 'UTF-8') }}"></div>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var el = document.getElementById('consumption-chart');
  if (!el || !el.dataset.months) return;
  try {
    var raw = JSON.parse(el.dataset.months);
    var months = Array.isArray(raw) ? raw : [];
    if (months.length === 0) {
      el.innerHTML = '<p class="text-gray-500 text-sm p-4">No consumption data yet. Upload bills to see trends.</p>';
      return;
    }
    var labels = months.map(function (m) {
      var names = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
      return (names[(m.month - 1)] || '') + ' ' + m.year;
    });
    var aedData = months.map(function (m) { return Number(m.total_aed) || 0; });
    new Chart(el.getContext('2d'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Amount (AED)',
          data: aedData,
          backgroundColor: 'rgba(59, 130, 246, 0.5)',
          borderColor: 'rgb(59, 130, 246)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  } catch (e) {
    el.innerHTML = '<p class="text-gray-500 text-sm p-4">Could not load chart.</p>';
  }
});
</script>
@endpush
