@extends('layouts.admin')
@section('title', 'All Brand LIstings')
@section('page.title', 'All Brand Listings')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Listings
		</h3>
	</div>
	<div class="col-12">
		@if(empty($listings[0]->id))
			<p>No Listings</p>
		@else
			<table class="table dt">
				<thead>
					<tr>
						<th>Logo</th>
						<th>Name</th>
						<th>City</th>
						<th>Listed by</th>
<!--
						<th>Featured</th>
-->
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($listings as $listing)
				<tr>
					<td><div style="width: 100px; height: 100px;"><img src="{{$listing->logo}}"  width="100%"/></div></td>
					<td>
							{{$listing->name}} 
							@if($listing->product->count() > 0)
							<br/><a href="{{route('admin.listing.products', ['id' => $listing->id])}}" class="btn btn-sm main-btn-bg"><small>{{$listing->product->count()}} PRODUCT(S)</small></a>
							@endif
					</td>
					<td>{{$listing->location->name }}</td>
					<td>{{$listing->user->name}}<br/><small>CREATED ON {{$listing->created_at}}</small></td>
<!--
					<td>
						<small>{{$listing->featured}}</small>
						@if ($listing->featured == "PENDING")
						<form method="post" action="{{route('admin.listing.featured')}}" onsubmit="confirm_first(event)" >
							@csrf
							<input type="hidden" name="listing_id" value="{{$listing->id}}" />
							<button class="btn btn-sm green-bg" name="featured" value="approved">Approve?</button>
						</form>
						
						@elseif($listing->featured == "APPROVED")
						<form method="post" action="{{route('admin.listing.featured')}}" onsubmit="confirm_first(event)" >
							@csrf
							<input type="hidden" name="listing_id" value="{{$listing->id}}" />
							<button class="btn btn-sm warm-red-bg" name="featured" value="pending">onHold?</button>
						</form>
						@endif
					</td>
-->
					<td>{{$listing->status}}</td>
					<td>
						<a class="btn warm-blue-bg" href="{{route('admin.view.listing', ['id' => $listing->id ])}}">view</a>
						<div class="my-dropdown">
							<div class=""><i class="bi bi-three-dots-vertical"></i></div>
							<div class="my-dropdown-content">
								<a class="dropdown-item" href="{{ route('admin.listings.edit', ['id' => $listing->id]) }}">EDIT</a>
								<a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ route('admin.listings.delete', ['id' => $listing->id]) }}">DELETE</a>
								{{-- <a class="dropdown-item" href="{{ route('listings.products', ['id' => $listing->id]) }}">Products</a> --}}
								<!--    
								<a class="dropdown-item" href="{{ route('listings.edit', ['id' => $listing->id]) }}">CHANGE OWNERSHIP</a>
								-->
							</div>
						</div>
					</td>
				</tr>
				@endforeach
				</tbody>
			</table>
		@endif
		
	</div>
	
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
		$(document).ready( function () {
			$('.dt').DataTable();
		} );
    </script>
@endpush
