<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'UtilityWise UAE')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4">
            <div class="flex justify-between h-14">
                <a href="{{ route('dashboard') }}" class="flex items-center font-semibold text-gray-800">UtilityWise UAE</a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('bills.index') }}" class="text-gray-600 hover:text-gray-900">Bills</a>
                    <a href="{{ route('alerts.index') }}" class="text-gray-600 hover:text-gray-900">Alerts</a>
                    <a href="{{ route('solar.index') }}" class="text-gray-600 hover:text-gray-900">Solar ROI</a>
                    <a href="{{ route('export.index') }}" class="text-gray-600 hover:text-gray-900">Export</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>
