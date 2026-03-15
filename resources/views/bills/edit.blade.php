@extends('layouts.app')

@section('title', 'Edit bill')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Edit bill</h1>

    <form action="{{ route('bills.update', $bill) }}" method="POST" class="space-y-4">
        @csrf
        @method('PATCH')
        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (AED)</label>
            <input type="number" name="amount" id="amount" step="0.01" value="{{ old('amount', $bill->amount) }}"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @error('amount')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="bill_date" class="block text-sm font-medium text-gray-700">Bill date</label>
            <input type="date" name="bill_date" id="bill_date" value="{{ old('bill_date', $bill->bill_date->format('Y-m-d')) }}"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @error('bill_date')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
    </form>
</div>
@endsection
