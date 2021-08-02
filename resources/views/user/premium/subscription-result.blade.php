@extends('layouts.user')
@section('title', 'Premium Subscription Payment')
@section('page.title', 'Premium Subscription Payment')
@section('content')
<div class="container mt-2 ">
	<div class="col-12" style="min-height: 100px; margin-top: 10px;">
		<div class="table-responsive-sm">
			<table class="table">
				<thead>
					<tr>
						<th>Transaction Date</th>
						<th>Expiry Date</th>
						<th>Amount</th>
						<th>VAT</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$subscription->created_at->format('D dS, M Y')}}</td>
						<td>{{date_format(date_create($subscription->expiry), 'D dS, M Y')}}</td>
						<td>₦{{$subscription->amount}}</td>
						<td>₦{{$subscription->vat}}</td>
						<th>₦{{$subscription->amount + $subscription->vat}}</th>
					</tr>
					<tr>
						<td colspan="4"></td>
						<th>{{$subscription->status}}</th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</div>
@endsection

@push('styles')
    
@endpush
@push('scripts')
    
@endpush
