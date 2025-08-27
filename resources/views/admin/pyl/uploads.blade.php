@extends('layouts.admin')
@section('title', 'Post Your Look Entries')
@section('page.title', 'Post Your look Entries')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Entries
			
		</h3>
	</div>
	<div class="col-12">
		<table class="table dt">
			<thead>
				<tr>
					<th>Name</th>
					<th>Competition</th>
					<th>Uploaded on</th>
					<th>Votes</th>
				</tr>
			</thead>
			<tbody>
			@foreach($uploads as $entry)
			<tr>
				<td>
					<div style="width: 100px; height: 100px; overflow: hidden; float: left;"><img src="{{$entry->photo}}" width="100%"/></div>
					<div style="width: 100%; float: left;"><a href="{{route('pyls.competition.entry',['slug' => $entry->pyl->slug, 'id' => $entry->id ])}}">{{$entry->user->name}}</a></div> 
				</td>
				<td><a href="{{route('pyls.competition',['slug' => $entry->pyl->slug ])}}">{{$entry->pyl->name}}</a></td>
				<td>{{$entry->created_at}}</td>
				<td>{{$entry->votes->count() ?? 0}}</td>
				
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
