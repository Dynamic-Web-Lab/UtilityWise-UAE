@extends('layouts.app')

@section('title', 'Alerts')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Anomaly alerts</h1>

    <ul class="space-y-4">
        @forelse($alerts as $alert)
            <li class="bg-white rounded-lg shadow p-4 border-l-4 border-amber-500">
                <p class="font-medium">{{ $alert->message }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $alert->created_at->diffForHumans() }}</p>
            </li>
        @empty
            <li class="text-gray-500">No alerts.</li>
        @endforelse
    </ul>

    {{ $alerts->links() }}
</div>
@endsection
