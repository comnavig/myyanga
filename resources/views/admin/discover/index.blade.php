@extends('layouts.admin')
@section('title', 'Discover')
@section('page.title', 'Discover')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Discovers
			<a class="btn btn-sm main-btn-bg float-right" href="{{ route('admin.discover.create') }}">add new</a>
			
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Picture</th>
					<th>Name</th>
					<th>Category</th>
					<th>Created on</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($discovers as $discover)
			<tr>
				<td>
				    <div style="width: 100px; height: 100px; overflow: hidden;">
				        @if(isset($discover->picture[0]))
                            <img src="{{ $discover->picture[0]->url }}" width="100%" />
                        @else
                            <p>No image available</p>
                        @endif
				    </div>
				</td>
				<td>{{$discover->name}}<br/><small><a target="_blank" href="{{ route('discovers.story', ['slug' => $discover->slug ]) }}">view discover page</small></td>
				<td>{{$discover->discover_category->name ?? '' }}</td>
				<td>{{$discover->created_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($discover->status)}}">{{$discover->status}}</span>
				</td>
				<td>
					@if ($discover->status == "SUSPENDED")
					
					@else
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-sm main-btn-bg mr-2" href="{{ route('admin.discover.edit', ['id' => $discover->id]) }}">EDIT</a>
							<form class="form-inline" method="post" action="{{ route('admin.discover.delete') }}">
								@csrf
								<button class="btn btn-sm warm-red-bg " name="discover_id" value="{{$discover->id}}" >DELETE</button>
							</form>
						</div>
					@endif
					
				</td>
			</tr>
			@endforeach
			</tbody>
		</table>
		
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
