@extends('layouts.admin')
@section('title', 'Premium Subscriptions')
@section('page.title', 'Premium Subscriptions')
@section('content')
<div class="container mt-2 ">
	<div class="col-12 p-0"  style="border-top: 2px solid #dddddd; min-height: 100px; margin-top: 10px;">
		
		@if(empty($premium_subscriptions[0]))
			<center><strong>No Subscription Yet</strong></center>
		@else
			<div class="table-responsive-sm">
				<table class="table dt">
					<thead>
						<tr>
							<th>Subscriber</th>
							<th>Transaction Date</th>
							<th>Expiry Date</th>
							<th>Amount</th>
							<th>VAT</th>
							<th>Total</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach($premium_subscriptions as $subscription)
						<tr>
							<td>{{$subscription->user->name}}<br/>{{$subscription->user->mobile}}<br/>{{$subscription->user->email}}</td>
							<td>{{$subscription->created_at->format('D dS, M Y')}}</td>
							<td>{{date_format(date_create($subscription->expiry), 'D dS, M Y')}}</td>
							<td>₦{{$subscription->amount}}</td>
							<td>₦{{$subscription->vat}}</td>
							<th>₦{{round($subscription->amount + $subscription->vat)}}</th>
							<th><a class="btn-link main-color" data-toggle="modal" data-target="#p{{$subscription->id}}Modal">{{$subscription->status}}</a></th>
						</tr>
						
						<!-- Modal -->
						<div class="modal fade" id="p{{$subscription->id}}Modal" tabindex="-1" aria-labelledby="p{{$subscription->id}}ModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="p{{$subscription->id}}ModalLabel">Items Purchased</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										  <span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body" style="height: 300px; overflow-y: auto;">
										@if ( $subscription->trans_data == "PENDING")
											{{$subscription->trans_data}}
										@else
											@php
												$pd = json_decode($subscription->trans_data, true);
											@endphp
											
											@foreach($pd as $key => $value)
												<p><strong class="main-color">{{$key}} : </strong> 
													@if (is_array($value))
														@foreach($value as $k => $v)
																@if (is_array($v))
																	@foreach($v as $k2 => $v2)
																			<p><strong>{{$k2}}:</strong> {{$v2}}</p>
																	@endforeach
																@else
																	{{$v}}
																@endif
														@endforeach
													@else
														{{$value}}
													@endif
												</p>
											@endforeach
										@endif
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>

						@endforeach
					</tbody>
				</table>
			</div>
			
		@endif

	</div>

</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script>
		$(document).ready( function () {
			$('.dt').DataTable();
			
			new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
			}).mount();
			
		} );
    </script>
@endpush
