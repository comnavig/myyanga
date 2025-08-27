@extends('layouts.admin')
@section('title', $location->name."'s Areas" )
@section('page.title', $location->name."'s Areas" )
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Areas 
			<div class="btn-group float-right" role="group" aria-label="Basic example">
				<a class="btn btn-sm warm-blue-bg" href="{{route('admin.area.add', ['id' => $location->id ])}}">add new</a>
				<a class="btn btn-sm warm-red-bg" href="{{route('admin.locations')}}">back</a>
			</div>
			
		</h3>
	</div>
	
	<div class="table-responsive">
		<table class="table dt">
		  <thead class="main-color-bg">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Name</th>
			  <th scope="col">Date</th>
			  <th scope="col">Last Edited By</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  <tbody>
			  @foreach($areas as $area)
				<tr class="">
				  <th scope="row">{{$area->id}}</th>
				  <td>{{$area->name}}</td>
				  <td>
					  Created at {{$area->created_at}}
					  <br/>
					  <small>Last updated at {{$area->updated_at}}</small>
				  </td>
				  <td>{{$area->user->name}}</td>
				  <td>
					  <a class="btn btn-sm warm-blue-bg" href="{{route('admin.area.edit', ['id' => $area->id ] )}}">edit</a>
					  <a class="btn btn-sm warm-red-bg" href="#" onclick="document.getElementById('loc_{{$area->id}}_id').submit()" >delete</a>
					  <form id="loc_{{$area->id}}_id" method="post" action="{{route('admin.location.action')}}">
						@csrf
						<input type="hidden" name="action" value="delete_location" />
						<input type="hidden" name="loc_id" value="{{$area->id}}" />
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
