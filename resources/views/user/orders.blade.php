@extends('layouts.user')
@section('title', 'Orders')
@section('page.title', 'Orders')
@section('content')
<div class="container mt-2 ">
	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Items</th>
				<th>Delivery Status</th>
				<th>Amount</th>
				<th>Date / Time</th>
				<th>Payment Status</th>
				
			</tr>
		</thead>
		<tbody>
		@foreach($orders->sortDesc() as $order)
			<tr>
				<td>#{{$order->id}}</td>
				<td><a class="btn-link main-color" data-toggle="modal" data-target="#o{{$order->id}}Modal">click to view</td>
				<td><a class="btn-link main-color" data-toggle="modal" data-target="#od{{$order->id}}Modal">click to view</td>
				<td>₦{{number_format($order->amount)}}</td>
				<td>{{$order->created_at->format('dS M Y h:i a') ?? ''}}</td>
				<td>
						@if ($order->status == "PAID")
						{{$order->status}}
						@else
						<a class="btn btn-sm main-color-bg" href="{{ route('shop.make.payment', ['id' => $order->id])}}">Make Payment</a>
						<a class="btn btn-sm main-color" href="{{ route('shop.delete.order', ['id' => $order->id])}}">Delete</a>
						@endif
				</td>
				
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
			<div class="modal fade" id="od{{$order->id}}Modal" tabindex="-1" aria-labelledby="od{{$order->id}}ModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="od{{$order->id}}ModalLabel">Items Delivery Status</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							@php
								$items = $order->sold;
							@endphp
							<ol>
								@foreach($items as $item)
								<li>{{$item->product->name}} | delivery status: <strong>{{$item->delivery_status }}</strong></a></li>
								@endforeach
							</ol>
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
