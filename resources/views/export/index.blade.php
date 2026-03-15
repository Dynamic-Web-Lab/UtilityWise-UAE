@extends('layouts.app')

@section('title', 'Export')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Export your data</h1>
    <p class="text-gray-600 mb-6">Download your bill history for personal use.</p>

    <ul class="space-y-4">
        <li class="flex items-center justify-between bg-white rounded-lg shadow p-4">
            <div>
                <h2 class="font-semibold">CSV</h2>
                <p class="text-sm text-gray-500">Spreadsheet-friendly (Excel, Google Sheets).</p>
            </div>
            <form action="{{ route('export.csv') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Download CSV</button>
            </form>
        </li>
        <li class="flex items-center justify-between bg-white rounded-lg shadow p-4">
            <div>
                <h2 class="font-semibold">PDF</h2>
                <p class="text-sm text-gray-500">Open in browser and use Print → Save as PDF.</p>
            </div>
            <form action="{{ route('export.pdf') }}" method="POST" target="_blank" rel="noopener">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">View / Print PDF</button>
            </form>
        </li>
    </ul>
</div>
@endsection
