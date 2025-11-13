@extends('layouts.admin')
@section('title', 'Individual Users')
@section('page.title', 'Individual Users')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Individual Users
			
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Name</th>
<!--
					<th>Brands</th>
					<th>Products / Services</th>
-->
					<th>Created on</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
			<tr>
				<td>
					<div style="width: 50px; height: 50px; overflow: hidden;"><img src="{{$user->avatar}}"  width="100%"/></div>
					<br/>{{$user->name}}
				</td>
<!--
				<td>{{$user->brands->count() ?? 0}}</td>
				<td>{{$user->products->count() ?? 0}}</td>
-->
				<td>{{$user->created_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($user->status)}}">{{$user->status}}</span>
				</td>
				<td><a class="dropdown-item" onclick=" if (confirm('Are you sure?')) { return confirm('Are double sure ? ehn? no going back oo') }" href="{{ route('admin.individual.users.delete', ['id' => $user->id]) }}">DELETE</a></td>  
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
