<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('plan')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.transactions.index', compact('transactions'));
    }

    public function downloadInvoice($invoiceNumber)
    {
        $transaction = Transaction::with('plan')->where('invoice_number', $invoiceNumber)->firstOrFail();
        
        if ($transaction->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.transactions.invoice', compact('transaction', 'user'));
        
        if (request()->has('view')) {
            return $pdf->stream($transaction->invoice_number . '.pdf');
        }
        
        return $pdf->download($transaction->invoice_number . '.pdf');
    }
}
