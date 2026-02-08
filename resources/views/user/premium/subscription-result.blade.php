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
					    <!--Format was wrong. the format() only works on Carbon/DateTime objects, NOT strings. causes a crash - updated by JTMax 20012026-->
						<!--<td>{{$subscription->created_at->format('D dS, M Y')}}</td>-->
						<!--<td>{{$subscription->expiry->format('D dS, M Y')}}</td>-->
						
						<!--The following works better. Parse the date in Blade (FAST FIX) ✔ Works even if DB stores strings ✔ No controller changes needed-->
						<td>{{ \Carbon\Carbon::parse($subscription->created_at)->format('D dS, M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($subscription->expiry)->format('D dS, M Y') }}</td>

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
