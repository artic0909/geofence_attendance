@extends('admin.layout')
@section('header_title', 'Transactions History')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Transactions</h1>
    <p class="text-gray-600">View all your past subscription payments and invoices.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h2 class="text-lg font-bold text-navy">Payment History</h2>
    </div>
    
    <div class="overflow-x-auto">
        @if($transactions->count() > 0)
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Transaction ID</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Plan</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($transactions as $transaction)
                <tr class="hover:bg-gray-50/80 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-mono text-xs text-gray-500">{{ $transaction->razorpay_payment_id ?? $transaction->id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-navy">{{ $transaction->plan->name ?? 'Custom Plan' }}</div>
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900">
                        ₹{{ number_format($transaction->amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-gray-900">{{ $transaction->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $transaction->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($transaction->status === 'success')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                            Success
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                            Failed
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($transaction->status === 'success')
                        <a href="{{ route('admin.transactions.invoice', $transaction->id) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 transition-colors" target="_blank">
                            <svg class="w-4 h-4 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Invoice
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $transactions->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4 shadow-sm border border-gray-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-navy mb-1">No Transactions Found</h3>
            <p class="text-gray-500 text-sm">You haven't made any payments yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection
