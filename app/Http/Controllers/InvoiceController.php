<?php

namespace App\Http\Controllers;

use App\Events\InvoiceStatusChanged;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\User;
use App\Rules\ShebaNumber;
use App\Services\Payment\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Display a list of invoices.
     */
    public function index()
    {
        $invoices = Gate::allows('view-all-invoices')
            ? Invoice::all()
            : Auth::user()->invoices;

        return view('invoices', compact('invoices'));
    }

    /**
     * Return a form to create an invoice.
     */
    public function create()
    {
        $categories = Category::all();

        return view('create-invoice', compact('categories'));
    }

    /**
     * create an invoice.
     */
    public function store(Request $request)
    {
        $validated = $this->validateInputs($request);

        if (array_key_exists('file', $validated)) {
            $path = $request->file('file')->store('upload');
        };

        Invoice::create([
            'category_id' => $validated['category'],
            'sheba_number' => $validated['sheba_number'],
            'amount' => $validated['amount'],
            'path' => isset($path) ? $path : null,
            'description' => $validated['description'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('invoices.index');
    }

    /**
     * Validate inputs to create an invoice.
     */
    public function validateInputs($request)
    {
        return $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'sheba_number' => ['required', 'numeric', 'digits:24', new ShebaNumber],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf'],
        ], ['file.mimes' => 'پسوند فايل مجاز نمي باشد. پسوندهای مجاز: pdf']);
    }

    /**
     * Delete an invoice.
     */
    public function delete(Invoice $invoice)
    {
        if (Gate::denies('access-invoice', $invoice) || $invoice->alreadyPaid()) {
            return back();
        };

        if ($invoice->path) {
            Storage::delete($invoice->path);
        };

        $invoice->delete();

        return back();
    }

    public function downloadAttachedFile(Invoice $invoice)
    {
        if (Gate::denies('access-invoice', $invoice)) {
            return back();
        };

        return Storage::download($invoice->path, 'file.' . pathinfo($invoice->path)['extension']);
    }

    /**
     * Confirm the invoice.
     */
    public function confirm(Invoice $invoice)
    {
        if (Gate::denies('confirm-invoices') || $invoice->alreadyPaid()) {
            return back();
        };

        $invoice->update(['status' => 1]);

        return back();
    }

    /**
     * reject the invoice.
     */
    public function reject(Invoice $invoice, Request $request)
    {
        if (Gate::denies('reject-invoices') || $invoice->alreadyPaid()) {
            return back();
        };

        $validated = $request->validate(['message' => ['nullable', 'string']]);

        $invoice->update(['status' => -1]);

        InvoiceStatusChanged::dispatch($invoice, 'invoice-reject', $validated['message']);

        return back();
    }

    /**
     * Invoice payment.
     */
    public function pay(Invoice $invoice)
    {
        if (Gate::denies('access-invoice', $invoice) || !$invoice->isConfirmed() || $invoice->alreadyPaid()) {
            return back();
        };

        return back()->with('payment_status', $this->transaction->pay($invoice));
    }
};
