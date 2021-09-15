@extends('layouts.app')
@section('title', "Post Your Look")

@section('content')
<div class="d-flex justify-content-center align-items-end" style="width: 100%; height: 300px; float: left; background-image: url('{{asset('assets/img/pyl.jpg')}}'); background-size: cover; background-position: center center; background-repeat: no-repeat;">
	<h3 class="white font-weight-bolder p-1"><span class="float-left">Post Your Look</span> </h3>
</div>
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 70px;">
	<div class="col-12" style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-4 col-md-12 col-sm-12">
				{!!$pyl_page->description!!}
				
			</div>
			<div class="col-lg-8 col-md-12 col-sm-12" style="margin-bottom: 70px;">
				<div class="col-12 float-left p-0">
					<h5 class="main-color-bg p-1">Latest&apos;s Competition </h5>
						<div  style="display: flex; flex-wrap: wrap; justify-content: space-around;">
						@if(!empty($latest->id))
							@if($latest->expired())
							<h5><a class="gold" href="{{route('pyls.competition', ['slug' => $latest->slug])}}"> {{$latest->name}}</a>  <small class="badge main-color-bg">{{$latest->status() }}</small> </h5>
								@foreach($latest->entries->sortDesc()->take(20) as $entry)
									<div class="product-item">
										<a class="link" href="{{route('pyls.competition.entry', ['slug' => $latest->slug, 'id' => $entry->id ])}}">
											<div class="img">
												<img src="{{$entry->photo }}" width="100%" />
											</div>
											{{ ( strlen($entry->user->name) > 20 ? substr($entry->user->name, 0, 15)."..." : $entry->user->name ) }}
										</a>
									</div>
								@endforeach
							@else
								
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 float-left mt-3 p-3">
		<div class="col-12" style="min-height: 300px;">
			<h5 class="main-color-bg p-1">Previous Competitions</h5>
			<div class="row p-0 m-0">
			@foreach($pyls->sortDesc() as $pyl)
				<div class="col-md-3 col-sm-12 p-1">
					<h5><a class="gold" href="{{route('pyls.competition', ['slug' => $pyl->slug])}}"> {{$pyl->name}}</a></h5>
					<div class="row p-0 m-0" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
						@foreach($pyl->entries->sortByDesc('votes_no')->take(2) as $entry)
							<div class="product-item">
								<a class="link" href="{{route('pyls.competition.entry', ['slug' => $pyl->slug, 'id' => $entry->id ])}}">
									<div class="img">
										<img src="{{$entry->photo }}" width="100%" />
									</div>
									{{ ( strlen($entry->name) > 20 ? substr($entry->name, 0, 15)."..." : $entry->name ) }}
								</a>
							</div>
						@endforeach
					</div>
				</div>
			@endforeach
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
