@extends('layouts.app')
@section('title', "Vote for ".$entry->user->name)

@section('content')

<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color "><span class="font-weight-bolder">{{$entry->user->name}}&apos;s entry</span> <i> for <a class="main-color" href="{{route('pyls.competition', ['slug' => $pyl->slug])}}"> {{$pyl->name}}</a></i> </h3>
</div>
<div class="white-bg" style="width:100%; float: left; margin-bottom: 60px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12 float-left">
				<div class="col-12 p-0">
					@if(Session::has('message'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<div class="container">
								{{ Session::get('message') }}
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
					@endif
					@if($errors->any())
					<div class="alert alert-danger">
						<div class="container">
							 <ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
					@endif
					
				</div>
				<div class="product-image">
					<img src="{{$entry->photo}}" class="d-block m-auto" alt="{{$entry->user->name}}">
				</div>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2 float-left">
				
				<div class="col-12 m-0 p-0 my-3">
					@include('components.share-button')
				</div>
				<div class="col-12">
					@include('components.pyl-votes', ['votes' => $entry->votes, 'upyl_id' => $entry->id, 'expired' => $pyl->expired()])
				</div>
			</div>
		</div>
	
	</div>
</div>
	
@endsection

@push('styles')

@endpush
@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
@endpush
