@extends('layouts.admin')
@section('title', 'Post Your Look')
@section('page.title', 'Post Your look')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Competitions
			<a class="btn btn-sm main-btn-bg float-right" href="{{ route('admin.pyl.create') }}">add new</a>
			
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Name</th>
					<th>Created on</th>
					<th>Expires on</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			@foreach($pyls as $pyl)
			<tr>
				<td>{{$pyl->name}}<br/><small><a target="_blank" href="{{ route('pyls.competition', ['slug' => $pyl->slug ]) }}">view pyl page</small></td>
				<td>{{$pyl->created_at}}</td>
				<td>{{$pyl->expired_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($pyl->status)}}">{{$pyl->status}}</span>
				</td>
				<td>
					@if ($pyl->status == "SUSPENDED")
					
					@else
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-sm main-btn-bg mr-2" href="{{ route('admin.pyl.edit', ['id' => $pyl->id]) }}">EDIT</a>
							<form class="form-inline" method="post" action="{{ route('admin.pyl.delete') }}">
								@csrf
								<button class="btn btn-sm warm-red-bg " name="pyl_id" value="{{$pyl->id}}" >DELETE</button>
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
