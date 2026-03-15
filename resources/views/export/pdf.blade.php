<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>UtilityWise UAE — Bill export</title>
    <style>
        body { font-family: sans-serif; margin: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 0.5rem; text-align: left; }
        th { background: #f5f5f5; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body>
    <h1>Bill history</h1>
    <p>Generated {{ now()->format('Y-m-d H:i') }}. For personal use only.</p>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Provider</th>
                <th>Amount (AED)</th>
                <th>kWh</th>
                <th>Gallons</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
                <tr>
                    <td>{{ $bill->bill_date->format('Y-m-d') }}</td>
                    <td>{{ strtoupper($bill->provider) }}</td>
                    <td>{{ number_format($bill->amount, 2) }}</td>
                    <td>{{ $bill->consumption_kwh ? number_format($bill->consumption_kwh, 2) : '—' }}</td>
                    <td>{{ $bill->consumption_gallons ? number_format($bill->consumption_gallons, 2) : '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No bills.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
