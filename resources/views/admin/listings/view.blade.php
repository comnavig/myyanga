@extends('layouts.admin')
@section('title', $listing->name.' lIsting')
@section('page.title', $listing->name)
@section('content')
<div class="container mt-2">
	<div class="col-12 p-2 d-flex flex-row-reverse">
		<a class="btn btn-sm main-btn-bg" href="{{ $backurl }}">back</a>
	</div>
	<div class="col-12">
		<div class="row">
			<div class="col-md-7">
				<div class="col-12">
					<img src="{{$listing->logo}}" width="200px" />
				</div>
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">DESCRIPTION</small>
					</div>
					<div class="col-12">
						<p>{!!$listing->description!!}</p>
					</div>
				</div>
				
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">ADDRESS</small>
					</div>
					<div class="col-12">
						<p>{{$listing->address}}</p>
					</div>
				</div>
				
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">CITY</small>
					</div>
					<div class="col-12">
						<p>{{$listing->location->name}}</p>
					</div>
				</div>
				
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">CAC Registered</small>
					</div>
					<div class="col-12">
						<p>{{$listing->cac}}</p>
					</div>
				</div>
				
				<div class="col-12">
					<div class="col-12 border-bottom">
						<small class="green">CAC Registration Number</small>
					</div>
					<div class="col-12">
						<p>{{$listing->cac_no}}</p>
					</div>
				</div>
			</div>
		
			
			<div class="col-12  border-bottom">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="col-12 border-bottom">
							<small class="col-12 green">Category</small>
						</div>
						<div class="col-12">
							<ol>
							@foreach($listing->category->where('category','!=', '') as $category)
								<li>{{$category->category->name}}</li>
							@endforeach
							</ol>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-12">
						<div class="col-12 border-bottom">
							<small class="col-12 green">Emails</small>
						</div>
						<div class="col-12">
							<ol>
								@foreach($listing->email as $email)
									<li>{{$email->email}}</li>
								@endforeach
							</ol>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-12">
						<div class="col-12 border-bottom">
							<small class="col-12 green">Phone</small>
						</div>
						<div class="col-12">
							<ol>
								@foreach($listing->phone as $phone)
									<li>{{$phone->phone}}</li>
								@endforeach
							</ol>
						</div>
					</div>
					
					<div class="col-md-3 col-sm-12">
						<div class="col-12 border-bottom">
							<small class="col-12 green">Url</small>
						</div>
						<div class="col-12">
							<ol>
								@foreach($listing->url as $url)
									<li>{{$url->link}}</li>
								@endforeach
							</ol>
						</div>
					</div>
					
					
				</div>
			</div>
			
			<div class="col-12 p-3">
				@if ($listing->parent_id == 0 )
					@if ($listing->status == "PENDING")
					<form method="post" action="{{route('admin.listing.action')}}" onsubmit="confirm_first(event)" >
						@csrf
						<input type="hidden" name="listing_id" value="{{$listing->id}}" />
						<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
						<button class="btn btn-sm warm-red-bg" name="action" value="declined">Decline</button>
					</form>
					
					@elseif($listing->status == "APPROVED")
					<form method="post" action="{{route('admin.listing.action')}}" onsubmit="confirm_first(event)" >
						@csrf
						<input type="hidden" name="listing_id" value="{{$listing->id}}" />
						<button class="btn btn-sm warm-red-bg" name="action" value="suspended">Suspend</button>
					</form>
					
					@elseif($listing->status == "DECLINED")
					<form method="post" action="{{route('admin.listing.action')}}" onsubmit="confirm_first(event)" >
						@csrf
						<input type="hidden" name="listing_id" value="{{$listing->id}}" />
						<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
						<button class="btn btn-sm warm-red-bg" name="action" value="suspended">Suspend</button>
						<button class="btn btn-sm warm-red-bg" name="action" value="delete">Delete</button>
					</form>
					
					@elseif($listing->status == "SUSPENDED")
					<form method="post" action="{{route('admin.listing.action')}}" onsubmit="confirm_first(event)" >
						@csrf
						<input type="hidden" name="listing_id" value="{{$listing->id}}" />
						<button class="btn btn-sm green-bg" name="action" value="approved">Approve</button>
						<button class="btn btn-sm warm-red-bg" name="action" value="declined">Decline</button>
					</form>
					
					@endif
				@endif
				
				
			</div>
		
		</div>
		
	</div>
	
	
	
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endpush
@push('scripts')
    <script>
		function confirm_first(event)
		{
			var r = confirm("Are you certain of this action?");
			
			if ( r == false )
			{
				event.preventDefault();
			}
		}
    </script>
@endpush
