@extends('layouts.admin')
@section('title', 'Ads')
@section('page.title', 'Ads')
@section('content')
<div class="container mt-2">
	<div class="my-4">
		<h3 class="main-color">
			All Ads
			<a class="btn btn-sm warm-blue-bg float-right" href="{{route('admin.ad.new')}}">add new</a>
		</h3>
	</div>
	
	<div class="table-responsive">
		<table class="table dt">
		  <thead class="main-color-bg">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Name</th>
			  <th scope="col">URL</th>
			  <th scope="col">Video</th>
			  <th scope="col">Photo</th>
			  <th scope="col">Expired on</th>
			  <th scope="col">Date</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead>
		  <tbody>
			  @foreach($ads as $ad)
				<tr class="">
				  <th scope="row">{{$ad->id}}</th>
				  <td>
					  {{$ad->name}}
					 <br/><small><strong>{{$ad->status}}</strong></small>
				  </td>
				  <td>{{$ad->url}}</td>
				  <td>
					  @if(empty($ad->youtube))
						<i>No Youtube Video</i>
					  @else
					  <a href="{{$ad->youtube}}" target=_blank class="warm-red" >
						<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
						  <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.122C.002 7.343.01 6.6.064 5.78l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
						</svg>
					  </a>
					  @endif
				  </td>
				  <td>
					  <a class="btn btn-link" data-toggle="modal" data-target="#ads{{$ad->id}}photo"><i class="bi bi-card-image" ></i>Photo</a>
				  </td>
				  <td>{{$ad->expired_at}}</td>
				  <td>
					  Created at {{$ad->created_at}}
					  <br/>
					  <small>Last updated at {{$ad->updated_at}}</small>
				  </td>
				  <td>
					  <a class="btn btn-sm warm-blue-bg" href="{{route('admin.ad.edit', ['id' => $ad->id ] )}}">edit</a>
						@if($ad->status == "APPROVED")
							<a class="btn btn-sm warm-red-bg" href="{{route('admin.ad.unapprove', ['id' => $ad->id ] )}}">unapprove</a>
						@else
							<a class="btn btn-sm green-bg" href="{{route('admin.ad.approve', ['id' => $ad->id ] )}}">approve</a>
						@endif
				  </td>
				</tr>
				

				<!-- Modal -->
				<div class="modal fade" id="ads{{$ad->id}}photo" tabindex="-1" aria-labelledby="ads{{$ad->id}}photoLabel" aria-hidden="true">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="ads{{$ad->id}}photoLabel">Modal title</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						  @php
						  $photo = json_decode($ad->photo, true);
						  @endphp
							<div class="col-12 float-left p-1 m-1">
								<h5>Desktop Ad Image</h5>
								<img src="{{$photo['desktop']}}" width="100%" />
							</div>
							<div class="col-12 float-left p-1 m-1">
								<h5>Mobile Ad Image</h5>
								<img src="{{$photo['mobile']}}" width="100%" />
							</div>
							
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					  </div>
					</div>
				  </div>
				</div>
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
