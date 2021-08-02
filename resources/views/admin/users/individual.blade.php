@extends('layouts.admin')
@section('title', 'Premium')
@section('page.title', 'Premium')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Premia
			<a class="btn btn-sm main-btn-bg float-right" href="{{ route('admin.premium.create') }}">add new</a>
			
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
			@foreach($premia as $premium)
			<tr>
				<td><div style="width: 100px; height: 100px; overflow: hidden;"><img src="{{$premium->picture[0]->url}}"  width="100%"/></div></td>
				<td>{{$premium->name}}<br/><small><a target="_blank" href="{{ route('premiums.story', ['slug' => $premium->slug ]) }}">view premium page</small></td>
				<td>{{$premium->premium_category->name }}</td>
				<td>{{$premium->created_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($premium->status)}}">{{$premium->status}}</span>
				</td>
				<td>
					@if ($premium->status == "SUSPENDED")
					
					@else
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-sm main-btn-bg mr-2" href="{{ route('admin.premium.edit', ['id' => $premium->id]) }}">EDIT</a>
							<form class="form-inline" method="post" action="{{ route('admin.premium.delete') }}">
								@csrf
								<button class="btn btn-sm warm-red-bg " name="premium_id" value="{{$premium->id}}" >DELETE</button>
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
