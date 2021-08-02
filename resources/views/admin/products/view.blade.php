@extends('layouts.admin')
@section('title', $product->name.' Product')
@section('page.title', $product->name)
@section('content')
<div class="container mt-2">
	<div class="my-4">
		
	</div>
	<div class="col-12">
		<div class="row">
			<div class="col-md-7">
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">DESCRIPTION</small>
					</div>
					<div class="col-12">
						<p>{!!$product->description!!}</p>
					</div>
				</div>
				
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">CITY</small>
					</div>
					<div class="col-12">
						<p>{{$product->location->name}}</p>
					</div>
				</div>
				
			</div>
		
			<div class="col-md-5">
				<div class="col-12 border-bottom">
					<small class="green">Pictures</small>
				</div>
				<div class="col-12">
					@foreach($product->picture as $picture)
						<div style="width: 50%; height: 250px; float: left; overflow: hidden; padding: 2%;">
							<img src="{{$picture->url}}" width="100%" />
						</div>
					@endforeach
				</div>
			</div>
			<div class="col-12  border-bottom">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="col-12 border-bottom">
							<small class="col-12 green">Category</small>
						</div>
						<div class="col-12">
							<p>{{$product->category->name}}</p>
						</div>
					</div>
					
				</div>
			</div>
			
			<div class="col-12 p-3">
				@if ($product->status == "PENDING")
				<form method="post" action="{{route('admin.product.action')}}" onsubmit="confirm_first(event)" >
					@csrf
					<input type="hidden" name="product_id" value="{{$product->id}}" />
					<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
					<button class="btn btn-sm warm-red-bg" name="action" value="declined">Decline</button>
				</form>
				
				@elseif($product->status == "APPROVED")
				<form method="post" action="{{route('admin.product.action')}}" onsubmit="confirm_first(event)" >
					@csrf
					<input type="hidden" name="product_id" value="{{$product->id}}" />
					<button class="btn btn-sm warm-red-bg" name="action" value="suspended">Suspend</button>
				</form>
				
				@elseif($product->status == "DECLINED")
				<form method="post" action="{{route('admin.product.action')}}" onsubmit="confirm_first(event)" >
					@csrf
					<input type="hidden" name="product_id" value="{{$product->id}}" />
					<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
					<button class="btn btn-sm warm-red-bg" name="action" value="suspended">Suspend</button>
				</form>
				
				@elseif($product->status == "SUSPENDED")
				<form method="post" action="{{route('admin.product.action')}}" onsubmit="confirm_first(event)" >
					@csrf
					<input type="hidden" name="product_id" value="{{$product->id}}" />
					<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
					<button class="btn btn-sm warm-red-bg" name="action" value="declined">Decline</button>
				</form>
				
				@endif
				
				
			</div>
		
		</div>
		
	</div>
	
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
    <script>
		function confirm_first(event)
		{
			var r = confirm("Are you certain of this action?");
			
			if ( r == false )
			{
				event.preventDefault();
			}
		}
    </script>
@endpush
