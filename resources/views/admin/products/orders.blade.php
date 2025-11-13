@extends('layouts.admin')
@section('title', 'Orders')
@section('page.title', 'Orders')
@section('content')
<div class="container mt-2 ">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Items</th>
				<th>Amount</th>
				<th>Order by</th>
				<th>Delivered to</th>
				<th>Date / Time</th>
			</tr>
		</thead>
		<tbody>
		@foreach($orders->sortDesc() as $order)
			<tr>
				<td>#{{$order->id}}</td>
				<td><a class="btn-link main-color" data-toggle="modal" data-target="#o{{$order->id}}Modal">click to view</td>
				<td>₦{{number_format($order->amount)}}<br/><a class="btn-link main-color" data-toggle="modal" data-target="#p{{$order->id}}Modal">{{$order->status}}</a></td>
				
				
				<!--this line was flagging error-->
				<!--{{-- <td>{{$order->user->name}}<br/>{{$order->user->mobile}}</td> --}}-->
				<!--{{-- <td>{{$order->address->address}}</td> --}}-->
				
				<!--Fix by Max-->
				<td>
                    {{ $order && $order->user ? $order->user->name : 'Name not provided' }}<br>
                    {{ $order && $order->address ? $order->address->address : 'Address not provided' }}<br>
                    {{ $order && $order->user ? $order->user->mobile : 'Phone Number not provided' }}
                </td>
                        <!--End of Fix-->
				
				<td>{{$order->created_at->format('dS M Y h:i a') ?? ''}}</td>
			</tr>
			<!-- Modal -->
			<div class="modal fade" id="o{{$order->id}}Modal" tabindex="-1" aria-labelledby="o{{$order->id}}ModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="o{{$order->id}}ModalLabel">Items Purchased</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							@php
								$items = json_decode($order->data);
							@endphp
							<ol>
								@foreach($items as $item)
								<li><a class="main-color" href="{{ route('user.order.view.item', ['product_id' => $item->product->id])}}">{{$item->product->id}} {{$item->product->name}} (₦{{number_format($item->product->price) }})</a></li>
								@endforeach
							</ol>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="p{{$order->id}}Modal" tabindex="-1" aria-labelledby="p{{$order->id}}ModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="p{{$order->id}}ModalLabel">Items Purchased</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" style="height: 300px; overflow-y: auto;">
							@if ( $order->payment_details == "PENDING")
								{{$order->payment_details}}
							@else
								@php
									$pd = json_decode($order->payment_details, true);
								@endphp
								
								@foreach($pd as $key => $value)
									<p><strong class="main-color">{{$key}} : </strong> 
										@if (is_array($value))
											@foreach($value as $k => $v)
													<p><strong>{{$k}}:</strong> {{$v}}</p>
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
	<div class="col-12">
		{{ $orders->links() }}
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
