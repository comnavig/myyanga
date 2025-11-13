@extends('layouts.admin')
@section('title', 'Featured Categories')
@section('page.title', 'Featured Categories')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			All Categories
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.featured.category.new')}}">add new</a>
		</h3>
	</div>
	
	<div class="table-responsive">
		<table class="table dt">
		  <thead class="main-color-bg">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Name</th>
			  <th scope="col">Expiry Timeframe</th>
			  <th scope="col">Date</th>
			  <th scope="col">Last Edited By</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  <tbody>
			  @foreach($categories as $category)
				<tr class="">
				  <th scope="row">{{$category->id}}</th>
				  <td>{{$category->name}}</td>
				  <td>{{$category->expiry_date}} Day(s)</td>
				  <td>
					  Created at {{$category->created_at}}
					  <br/>
					  <small>Last updated at {{$category->updated_at}}</small>
				  </td>
				  <td>{{$category->user->name}}</td>
				  <td>
					  <a class="btn btn-sm warm-blue-bg" href="{{route('admin.featured.category.edit', ['id' => $category->id ] )}}">edit</a>
					  <a class="btn btn-sm warm-red-bg" href="#" onclick="document.getElementById('cat_{{$category->id}}_id').submit()" >delete</a>
					  <form id="cat_{{$category->id}}_id" method="post" action="{{route('admin.featured.category.action')}}">
						@csrf
						<input type="hidden" name="action" value="delete_category" />
						<input type="hidden" name="cat_id" value="{{$category->id}}" />
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
