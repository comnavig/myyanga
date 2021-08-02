@extends('layouts.admin')
@section('title', 'Pages')
@section('page.title', 'Pages')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Pages
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.pages.create')}}">add new</a>
		</h3>
	</div>
	<div class="col-12">
		@if(count($pages) < 0)
			<p>No Pages, please <a class="btn btn-link warm-blue" href="{{route('admin.pages.create')}}">add a page</a></p>
		@else
			<table class="table dt">
				<thead>
					<tr>
						<th>Name</th>
						<th>Slug</th>
						<th>Created by</th>
<!--
						<th>Status</th>
-->
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach($pages as $page)
				<tr>
<!--
					<td><img src="{{$page->picture}}"  width="100px"/></td>
-->
					<td>
						<a class="btn btn-link" data-toggle="modal" data-target="#Modal{{$page->id}}">{{ substr($page->name, 0, 30)}}...</a>
						<!-- Modal -->
						<div class="modal fade" id="Modal{{$page->id}}" tabindex="-1" aria-labelledby="Modal{{$page->id}}Label" aria-hidden="true">
						  <div class="modal-dialog dialog-lg">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="Modal{{$page->id}}Label">{{ $page->name }}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							  <div class="modal-body">
								<div class="row">
									<div class="col-12">
										<img src="{{$page->picture}}" width="100%"/>
									</div>
									<div class="col-12">
										<p>{!!$page->description!!}</p>
									</div>
									
								</div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							  </div>
							</div>
						  </div>
						</div>
					</td>
					<td>{{$page->slug}}</td>
					<td>{{$page->user->name}} <br/><small>created on {{$page->created_at}}</small></td>
<!--
					<td>
						<span class="font-weight-bold {{strtolower($page->status)}}">{{$page->status}}</span>
					</td>
-->
					<td>
						@if ($page->status == "SUSPENDED")
						
						@else
							<a class="btn btn-sm warm-blue-bg" href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">edit</a>
							<a class="btn btn-sm warm-red" href="{{ route('admin.pages.delete') }}" onclick="confirm_first(page,'delete-form-{{$page->id}}')"><i class="bi bi-trash-fill"></i></a>

							<form id="delete-form-{{$page->id}}" action="{{ route('admin.pages.delete') }}" method="POST" class="d-none">
								@csrf
								<input type="hidden" name="page_id" value="{{$page->id}}">
							</form>
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
		
		function confirm_first(event, id)
		{
			var r = confirm("Are you certain of this action?");
			
			if ( r == false )
			{
				event.preventDefault();
			}
			else
			{
				event.preventDefault(); document.getElementById(id).submit();
			}
		}
    </script>
@endpush
