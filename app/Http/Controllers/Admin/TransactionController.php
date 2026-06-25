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

    public function downloadInvoice($id)
    {
        $transaction = Transaction::with('plan')->findOrFail($id);
        
        if ($transaction->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.transactions.invoice', compact('transaction', 'user'));
        
        return $pdf->download('Invoice-' . ($transaction->razorpay_payment_id ?? $transaction->id) . '.pdf');
    }
}
