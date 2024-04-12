<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Auth::user()->invoices;

        return view('invoices', compact('invoices'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('create-invoice', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateInputs($request);

        if (array_key_exists('file', $validated)) {
            $path = $request->file('file')->store('upload');
        };

        Invoice::create([
            'category_id' => $validated['category'],
            'shaba_number' => $validated['shaba_number'],
            'amount' => $validated['amount'],
            'path' => isset($path) ? $path : null,
            'description' => $validated['description'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('invoices.index');
    }

    public function validateInputs($request)
    {
        return $request->validate([
            'category' => ['required', 'exists:categories,id'],
            'shaba_number' => ['required', 'numeric', 'digits:24'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf'],
        ], ['file.mimes' => 'پسوند فايل مجاز نمي باشد. پسوندهای مجاز: pdf']);
    }

    public function delete(Invoice $invoice)
    {
        if (Gate::denies('access-invoice', $invoice)) {
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
}
