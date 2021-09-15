@extends('layouts.admin')
@section('title', 'TVs')
@section('page.title', 'TVs')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			All TVs
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.tv.new')}}"> add new</a>
		</h3>
	</div>
	
	<div class="table-responsive">
		<table class="table dt">
		  <thetv class="main-color-bg">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Video</th>
			  <th scope="col">Name</th>
			  <th scope="col">Category</th>
			  <th scope="col">Date</th>
			  <th scope="col">Action</th>
			</tr>
		  </thetv>
		  <tbody>
			  @foreach($tvs as $tv)
				<tr class="">
				  <th scope="row">{{$tv->id}}</th>
				  <td>
					<a href="{{$tv->youtube}}" target=_blank class="warm-red" >
						<img src="{{$tv->photo}}" width="150px"/>
					  </a>
				  </td>
				  <td>
					  {{$tv->name}}
					 <br/><small><strong>{{$tv->status}}</strong></small>
				  </td>
				  <td>
					  {{$tv->tv_category->name }}
				  </td>
				  
				  <td>
					  Created at {{$tv->created_at}}
					  <br/>
					  <small>Last updated at {{$tv->updated_at}}</small>
				  </td>
				  <td>
					
						<form class="form-inline" method="post" action="{{ route('admin.tv.delete') }}">
							@csrf
							<div class="btn-group">
								<a class="btn btn-sm warm-blue-bg" href="{{route('admin.tv.edit', ['id' => $tv->id ] )}}">edit</a>
								@if($tv->status == "APPROVED")
									<a class="btn btn-sm warm-red-bg" href="{{route('admin.tv.unapprove', ['id' => $tv->id ] )}}">unapprove</a>
								@else
									<a class="btn btn-sm green-bg" href="{{route('admin.tv.approve', ['id' => $tv->id ] )}}">approve</a>
								@endif
								<button class="btn btn-sm warm-red-bg " name="tv_id" value="{{$tv->id}}" >delete</button>
							</div>
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
