@extends('layouts.admin')
@section('title', 'Posts')
@section('page.title', 'Posts')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			Posts
			<a class="btn btn-sm main-btn-bg float-right" href="{{ route('admin.blog.create.post') }}">add new</a>
			
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
			@foreach($posts as $post)
			<tr>
				<td>
				    <div style="width: 100px; height: 100px; overflow: hidden;">
				        @if(isset($post->picture[0]))
                            <img src="{{ $post->picture[0]->url }}" width="100%" />
                        @else
                            <p>No image available</p>
                        @endif
				    </div>
				</td>
				<td>{{$post->name}}<br/><small><a target="_blank" href="{{ route('blog.post', ['slug' => $post->slug ]) }}">view post page</small></td>
				<td>{{$post->post_category->name }}</td>
				<td>{{$post->created_at}}</td>
				<td>
					<span class="font-weight-bold {{strtolower($post->status)}}">{{$post->status}}</span>
				</td>
				<td>
					@if ($post->status == "SUSPENDED")
					
					@else
						<div class="btn-group" role="group" aria-label="Basic example">
							<a class="btn btn-sm main-btn-bg mr-2" href="{{ route('admin.blog.edit.post', ['id' => $post->id]) }}">EDIT</a>
							<form class="form-inline" method="post" action="{{ route('admin.blog.delete.post') }}">
								@csrf
								<button class="btn btn-sm warm-red-bg " name="post_id" value="{{$post->id}}" >DELETE</button>
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
