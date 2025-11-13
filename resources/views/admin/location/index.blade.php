@extends('layouts.admin')
@section('title', 'Locations')
@section('page.title', 'Locations')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			All Locations
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.location.new')}}">add new</a>
		</h3>
	</div>
	
	<div class="table-responsive">
		<table class="table dt">
		  <thead class="main-color-bg">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Name</th>
			  <th scope="col">Areas</th>
			  <th scope="col">Date</th>
			  <th scope="col">Last Edited By</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  <tbody>
			  @foreach($locations as $location)
				<tr class="">
				  <th scope="row">{{$location->id}}</th>
				  <td>{{$location->name}}</td>
				  <td><a class="btn btn-link green" href="{{ route('admin.location.areas', ['id' => $location->id ]) }}">{{ count($location->areas )}} Areas</a></td>
				  <td>
					  Created at {{$location->created_at}}
					  <br/>
					  <small>Last updated at {{$location->updated_at}}</small>
				  </td>
				  <td>{{$location->user->name}}</td>
				  <td>
					  <a class="btn btn-sm warm-blue-bg" href="{{route('admin.location.edit', ['id' => $location->id ] )}}">edit</a>
					  <a class="btn btn-sm warm-red-bg" href="#" onclick="document.getElementById('loc_{{$location->id}}_id').submit()" >delete</a>
					  <form id="loc_{{$location->id}}_id" method="post" action="{{route('admin.location.action')}}">
						@csrf
						<input type="hidden" name="action" value="delete_location" />
						<input type="hidden" name="loc_id" value="{{$location->id}}" />
					  </form>
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
