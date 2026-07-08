@extends('admin.layout')
@section('header_title', 'Transactions History')

@section('content')
<div class="page-heading">
  <div class="page-heading-copy">
    <span class="page-icon"><i class="bi bi-receipt" aria-hidden="true"></i></span>
    <div>
      <p class="eyebrow mb-1">Billing</p>
      <h1 class="h3 mb-1">Transactions</h1>
      <p class="text-muted mb-0">View all your past subscription payments and invoices.</p>
    </div>
  </div>
</div>

<section class="panel mt-3">
  <div class="panel-header">
    <div>
      <h2 class="h5 mb-1 section-title"><i class="bi bi-clock-history" aria-hidden="true"></i><span>Payment History</span></h2>
    </div>
  </div>
  
  <div class="table-responsive">
    @if($transactions->count() > 0)
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th scope="col">SL</th>
                <th scope="col">Transaction ID</th>
                <th scope="col">Plan</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col" class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}</td>
                <td>
                    <div class="font-monospace text-muted small">{{ $transaction->razorpay_payment_id ?? $transaction->id }}</div>
                </td>
                <td>
                    <div class="fw-bold text-primary">{{ $transaction->subscription->plan_name ?? $transaction->plan->name ?? 'Custom Plan' }}</div>
                </td>
                <td class="fw-bold">
                    ₹{{ number_format($transaction->amount, 2) }}
                </td>
                <td>
                    <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                    <div class="small text-muted">{{ $transaction->created_at->format('h:i A') }}</div>
                </td>
                <td>
                    @if($transaction->status === 'successful' || $transaction->status === 'success')
                    <span class="badge text-bg-success"><i class="bi bi-check-circle me-1"></i> Success</span>
                    @else
                    <span class="badge text-bg-danger"><i class="bi bi-x-circle me-1"></i> Failed</span>
                    @endif
                </td>
                <td class="text-end">
                    @if($transaction->status === 'successful' || $transaction->status === 'success')
                    <a href="{{ route('admin.transactions.invoice', ['id' => $transaction->id, 'view' => 1]) }}" class="btn btn-light btn-sm me-1" target="_blank" title="View Invoice">
                        <i class="bi bi-eye"></i> View
                    </a>
                    <a href="{{ route('admin.transactions.invoice', $transaction->id) }}" class="btn btn-primary btn-sm" title="Download Invoice">
                        <i class="bi bi-download"></i> Download
                    </a>
                    @else
                    <span class="text-muted small italic">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="px-4 py-3 border-top">
        {{ $transactions->links() }}
    </div>
    @else
    <div class="py-5 text-center">
        <div class="d-inline-flex align-items-center justify-content-center bg-light text-muted mb-3 rounded-circle" style="width: 64px; height: 64px;">
            <i class="bi bi-receipt fs-3"></i>
        </div>
        <h3 class="h5 fw-bold mb-1">No Transactions Found</h3>
        <p class="text-muted small">You haven't made any payments yet.</p>
    </div>
    @endif
  </div>
</section>
@endsection
