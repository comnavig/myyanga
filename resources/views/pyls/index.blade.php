@extends('layouts.app')
@section('title', "Post Your Look")

@section('content')
<br>
<div class="d-flex justify-content-center align-items-end" style="width: 100%; height: 300px; float: left; background-image: url('{{asset('assets/img/pyl.jpg')}}'); background-size: contain; background-position: center center; background-repeat: no-repeat;">
	<h3 class="black font-weight-bolder p-1"><span class="float-left">Post Your Look</span> </h3>
</div>
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;"></div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 70px;">
	<div class="col-12" style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-4 col-md-12 col-sm-12">
				{!!$pyl_page->description!!}
			</div>
			<div class="col-lg-8 col-md-12 col-sm-12" style="margin-bottom: 70px;">
				<div class="col-12 float-left p-0">
					<h5 class="main-color-bg p-1">Latest's Competition</h5>
					<!--div  style="display: flex; flex-wrap: wrap; justify-content: space-around;"-->
					<div style="display: flex; flex-wrap: wrap;">
						@if(!empty($latest) && !empty($latest->id))
							@if($latest->expired())
								<h5>
									<a class="gold" href="{{route('pyls.competition', ['slug' => $latest->slug])}}">
										{{$latest->name}}
									</a>
									<small class="badge main-color-bg">{{$latest->status()}}</small>
									<div class="row p-3">
										<p id="count-down" style="font-size: 1.375rem; padding-bottom: 0.625rem;">
											{{ $latest->expired_at }}
										</p>
									</div>
								</h5>
								@foreach($latest->entries->sortDesc()->take(20) as $entry)
									<div class="product-item card">
										<a class="link" href="{{route('pyls.competition.entry', ['slug' => $latest->slug, 'id' => $entry->id ])}}">
											<div class="img">
												<img src="{{$entry->photo }}" width="100%" />
											</div>
											<h4>
												<b>{{ ( strlen($entry->user->name) > 20 ? substr($entry->user->name, 0, 15)."..." : $entry->user->name ) }}</b>
											</h4>
										</a>
									</div>
								@endforeach
							@else
								<p>No active competition at the moment.</p>
							@endif
						@else
							<p>No competition data available.</p>
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
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 40%;
  border-radius: 5px;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

img {
  border-radius: 5px 5px 0 0;
}

.container {
  padding: 2px 16px;
}
</style>
@endpush
@push('scripts')
<script async src="https://static.addtoany.com/menu/page.js"></script>
<script>
    @if(!empty($latest) && !empty($latest->expired_at))
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $latest->expired_at }}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          var now = new Date().getTime();

          // Find the distance between now and the count down date
          var distance = countDownDate - now;

          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id="count-down"
          document.getElementById("count-down").innerHTML = days + "Days " + hours + "Hrs "
          + minutes + "Mins " + seconds + "Secs ";

          // If the count down is finished, write some text
          if (distance < 0) {
            clearInterval(x);
            document.getElementById("count-down").innerHTML = "EXPIRED";
          }
        }, 1000);
    @endif
</script>
@endpush
