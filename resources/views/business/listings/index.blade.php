@extends('layouts.business')
@section('title', 'Brand LIstings')
@section('page.title', 'My Brand Listings')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Listings
			<a class="btn btn-sm main-btn-bg float-right" href="{{route('listings.create')}}">add new</a>
		</h3>
	</div>
	<div class="col-12">
		@if(count($listings) < 0)
			<p>No Listings, please add a business <a class="btn btn-sm main-btn-bg" href="{{route('listings.create')}}">add new</a></p>
		@else
			<table class="table dt">
				<thead>
					<tr>
						<th>Logo</th>
						<th>Name</th>
						<th>City</th>
						<th>Created on</th>
<!--
						<th>Status</th>
-->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($listings as $listing)
				<tr>
					<td><div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{str_replace("https://myyanga.fra1.digitaloceanspaces.com/", "https://myyanga.com/storage/", $listing->logo)}}"  width="100%"/></div></td>
					<td>
						{{$listing->name}}
						<br/><a class="btn-sm btn-link blue p-0" target="_blank" href="{{ route('pages', ['slug' => $listing->slug]) }}">{{url($listing->slug) }}</a>
					</td>
					<td>{{$listing->location->name }}</td>
					<td>{{$listing->created_at->format('d M Y | h:ia')}}</td>
<!--
					<td>
						<span class="font-weight-bold {{strtolower($listing->status)}}">{{$listing->status}}</span>
					</td>
-->
					<td  class="text-right">
						@if ($listing->status == "SUSPENDED")
							<strong>SUSPENDED</strong>
						@else
							<div class="my-dropdown">
								<div class=""><i class="bi bi-three-dots-vertical"></i></div>
								<div class="my-dropdown-content">
									<a class="dropdown-item" href="{{ route('listings.edit', ['id' => $listing->id]) }}">EDIT</a>
									<a class="dropdown-item" href="{{ route('listings.products', ['id' => $listing->id]) }}">Products</a>
									<!--    
									<a class="dropdown-item" href="{{ route('listings.edit', ['id' => $listing->id]) }}">CHANGE OWNERSHIP</a>
									-->
								</div>
							</div>
						@endif
						
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
