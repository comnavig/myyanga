@extends('layouts.app')
@section('title', $pyl->name)

@section('content')
<div class="d-flex justify-content-center align-items-end" style="width: 100%; height: 300px; float: left; background-image: url('{{asset('assets/img/pyl.jpg')}}'); background-size: cover; background-position: center center; background-repeat: no-repeat; margin-bottom: 20px;">
	<h3 class="white font-weight-bolder p-1"><span class="float-left">Post Your Look</span> </h3>
</div>
<div class="col-lg-7 col-md-12 col-sm-12 py-3" style="margin-top: 3%;">
	<h4 class="main-color">{{$pyl->name}} <small class="badge main-color-bg">{{$pyl->status() }}</small> </h4>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 70px;">
	<div class="row m-0 p-0">
		<div class="col-lg-4 col-md-12 col-sm-12">
			{!!$pyl->description!!}
			@if ($userpyl->count() == 0)
				@include('components.pyl-upload',['pyl'=>$pyl])
			@endif
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12" style="margin-bottom: 70px;">
			<div class="col-12 float-left p-0 mt-3">
				<h5 class="main-color p-1">Competition statistics </h5>
				<ul>
					<li class="row">
						<div class="col-md-3 col-sm-12 d-none d-lg-block">Name</div>
						<div class="col-md-3 col-sm-12 d-none d-lg-block">Position</div>
						<div class="col-md-3 col-sm-12 d-none d-lg-block">Date</div>
						<div class="col-md-3 col-sm-12 d-none d-lg-block">Votes</div>
					</li>
				
					@php
						$position = 1;
					@endphp
					@foreach($entries->sortByDesc('votes_no') as $entry)
					<li class="row">
						<div class="col-md-3 col-sm-12">
							<a class="link" href="{{route('pyls.competition.entry', ['slug' => $pyl->slug, 'id' => $entry->id ])}}">
								<div class="img" style="width: 200px; height: 200px; overflow: hidden;">
									<img src="{{$entry->photo }}" width="100%" />
								</div>
								{{ ( strlen($entry->name) > 20 ? substr($entry->name, 0, 15)."..." : $entry->name ) }}
							</a>
						</div>
						<div class="col-md-3 col-sm-12 p-sm-2"><small class=" d-block d-sm-none main-color">POSITION</small>{{$pyl->ordinal($position)}}</div>
						<div class="col-md-3 col-sm-12 p-sm-2"><small class=" d-block d-sm-none main-color">DATE</small>{{$entry->date}}</div>
						<div class="col-md-3 col-sm-12 p-sm-2"><small class=" d-block d-sm-none main-color">VOTES</small>{{$entry->votes_no}}</div>
					</li>
					@php
						$position++;
					@endphp
					@endforeach
				</ul>
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
