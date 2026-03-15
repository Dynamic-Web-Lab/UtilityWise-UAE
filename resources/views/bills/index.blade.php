@extends('layouts.app')

@section('title', 'Bills')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Bills</h1>
        <a href="{{ route('bills.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload bill</a>
    </div>

    @if(session('status'))
        <p class="mb-4 text-green-600">{{ session('status') }}</p>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Date</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Provider</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Amount (AED)</th>
                <th class="border border-gray-300 px-4 py-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $bill->bill_date->format('Y-m-d') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ strtoupper($bill->provider) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">{{ number_format($bill->amount ?? 0, 2) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-right">
                        <a href="{{ route('bills.edit', $bill) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="inline" onsubmit="return confirm('Delete this bill?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                        No bills. <a href="{{ route('bills.create') }}" class="text-blue-600">Upload your first bill</a>.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bills->links() }}
</div>
@endsection
