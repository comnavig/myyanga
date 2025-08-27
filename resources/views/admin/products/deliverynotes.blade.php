@extends('layouts.admin')
@section('title', 'Delivery Notes')
@section('page.title', 'Delivery Notes')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Delivery Notes
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('admin.products.sold')}}">back to Sold Products</a>
		</h3>
	</div>
	<div class="col-12">
		<div class="col-12">
		@if(empty($deliverynotes[0]->id))
			<p>No Delivery Note</p>
		@else
<!--
			<div class="col-md-4 col-sm-12 ml-auto">
				<form class="form-row" action="{{route('admin.products')}}">
					@csrf
					<div class="col-10">
						<div class="form-group mx-sm-6 mb-2">
							<input type="text" name="search" class="form-control" value="{{old('search')}}" placeholder="Search a Product" required />
						</div>
					</div>
					<div class="col-2">
						<button type="submit" class="btn main-color-bg mb-2">Search</button>
					</div>
				</form>	
			</div>
-->
			<table class="table">
				<thead>
					<tr>
						<th>Photo</th>
						<th>Note</th>
						<th>Submited on</th>
					</tr>
				</thead>
				<tbody>
				@foreach($deliverynotes as $delivery_note)
					<tr>
						<td><div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$delivery_note->image}}"  width="100%"/></div> </td>
						<td><a class="btn btn-link main-color p-0" data-toggle="modal" data-target="#dn{{$delivery_note->id}}Modal">Note</button></td>
						<td>{{$delivery_note->created_at}}</td>
					</tr>
					
					<!-- Modal -->
					<div class="modal fade" id="dn{{$delivery_note->id}}Modal" tabindex="-1" aria-labelledby="p{{$delivery_note->id}}ModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header main-color-bg">
							<h5 class="modal-title" id="p{{$delivery_note->id}}ModalLabel">Note</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
							  <img src="{{$delivery_note->image}}"  width="100%"/>
							  {{$delivery_note->delivery_note}}
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
							<form method="post" action="{{route('admin.products.sold.delivered')}}">
								@csrf
								<input type="hidden" name="product_sold_id" value="{{$delivery_note->product_sold_id}}" />
								<button type="submit" class="btn main-color-bg btn-sm" name="action" value="delivered" >Approve</button>
							</form>
						  </div>
						</div>
					  </div>
					</div>
					
				@endforeach
				
				</tbody>
			
			</table>
			<div class="col-12">
				{{$deliverynotes->withQueryString()->links()}}
			</div>
		@endif
		
	</div>
	
	
	</div>
	
	
</div>
@endsection
<link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@push('styles')
    
@endpush
@push('scripts')
	<script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script src="https://cdn.ckeditor.com/4.16.1/full/ckeditor.js"></script>
    <script>
		  CKEDITOR.replace( 'description' );
	var loadFile = function(event, image_id) {
		var image = document.getElementById(image_id);
		image.src = URL.createObjectURL(event.target.files[0]);
	};
	
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	});
</script>
@endpush
