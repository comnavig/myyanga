@extends('layouts.admin')
@section('title', $category->name."'s Subcategories" )
@section('page.title', $category->name."'s Subcategories" )
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Subcategories 
			<div class="btn-group float-right" role="group" aria-label="Basic example">
				<a class="btn btn-sm warm-blue-bg" href="{{route('admin.subcategory.add', ['id' => $category->id ])}}">add new</a>
				<a class="btn btn-sm warm-red-bg" href="{{route('admin.categories')}}">back</a>
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
			  @foreach($subcategories as $subcategory)
				<tr class="">
				  <th scope="row">{{$subcategory->id}}</th>
				  <td>{{$subcategory->name}}</td>
				  <td>
					  Created at {{$subcategory->created_at}}
					  <br/>
					  <small>Last updated at {{$subcategory->updated_at}}</small>
				  </td>
				  <td>{{$subcategory->user->name}}</td>
				  <td>
					  <a class="btn btn-sm warm-blue-bg" href="{{route('admin.subcategory.edit', ['id' => $subcategory->id ] )}}">edit</a>
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
