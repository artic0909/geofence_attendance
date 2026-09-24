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
                <th scope="col">Invoice No</th>
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
                    <div class="font-monospace text-muted small">{{ $transaction->invoice_number }}</div>
                </td>
                <td>
                    <div class="fw-bold text-primary">{{ $transaction->razorpay_payment_id ?? $transaction->id }}</div>
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
                    <a href="{{ route('admin.transactions.invoice', ['invoice_number' => $transaction->invoice_number, 'view' => 1]) }}" class="btn btn-light btn-sm me-1" target="_blank" title="View Invoice">
                        <i class="bi bi-eye"></i> View
                    </a>
                    <a href="{{ route('admin.transactions.invoice', $transaction->invoice_number) }}" class="btn btn-primary btn-sm" title="Download Invoice">
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
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 px-4 py-3 border-top">
        <div class="d-flex align-items-center gap-2">
            <label for="per_page" class="text-muted small fw-semibold text-nowrap mb-0">Show rows:</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: auto; min-width: 85px;" onchange="window.location.href = updateQueryParam('per_page', this.value)">
                <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>All</option>
            </select>
            <span class="text-muted small">entries per page</span>
        </div>
        <div>
            {{ $transactions->links() }}
        </div>
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
