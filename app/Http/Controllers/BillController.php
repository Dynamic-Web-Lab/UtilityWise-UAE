<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Services\BillParsingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillController extends Controller
{
    public function __construct(
        private BillParsingService $billParsingService
    ) {}

    public function index(Request $request): View
    {
        $bills = $request->user()
            ->bills()
            ->latest('bill_date')
            ->paginate(15);

        return view('bills.index', compact('bills'));
    }

    public function create(): View
    {
        return view('bills.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'provider' => ['required', 'string', 'in:dewa,fewa,addc,sewa,empower,tabreed,du,etisalat'],
        ]);

        $file = $request->file('file');
        $provider = $request->input('provider');
        $path = $file->store('bills', 'local');

        // Queue OCR processing (Phase 1: async via AI service)
        dispatch(new \App\Jobs\ProcessBillOCR($request->user(), storage_path('app/'.$path), $provider, $path));

        return redirect()->route('bills.index')
            ->with('status', __('Bill uploaded. Processing in background.'));
    }

    public function edit(Bill $bill): View
    {
        $this->authorize('update', $bill);
        return view('bills.edit', compact('bill'));
    }

    public function update(Request $request, Bill $bill): RedirectResponse
    {
        $this->authorize('update', $bill);
        $request->validate([
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'bill_date' => ['sometimes', 'date'],
        ]);
        $bill->update($request->only(['amount', 'bill_date']));
        return redirect()->route('bills.index')->with('status', __('Bill updated.'));
    }

    public function destroy(Bill $bill): RedirectResponse
    {
        $this->authorize('delete', $bill);
        $bill->delete();
        return redirect()->route('bills.index')->with('status', __('Bill deleted.'));
    }
}
