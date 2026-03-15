@extends('layouts.app')

@section('title', 'Upload bill')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Upload bill</h1>

    <form action="{{ route('bills.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">PDF or image</label>
            <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png" required
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
            @error('file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="provider" class="block text-sm font-medium text-gray-700">Provider</label>
            <select name="provider" id="provider" required class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                <option value="">Select provider</option>
                <option value="dewa">DEWA</option>
                <option value="fewa">FEWA</option>
                <option value="addc">ADDC</option>
                <option value="sewa">SEWA</option>
                <option value="empower">Empower</option>
                <option value="tabreed">Tabreed</option>
                <option value="du">Du</option>
                <option value="etisalat">Etisalat</option>
            </select>
            @error('provider')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Upload</button>
    </form>
</div>
@endsection
