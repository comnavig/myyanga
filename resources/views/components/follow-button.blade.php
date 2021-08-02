@php 
$follow = App\ListingFollow::where('listing_id', $listing_id)->get();
$followed = App\ListingFollow::where([ ['listing_id', $listing_id], ['user_id', Auth::id() ] ])->get();
$followed = $followed->last();
@endphp
<div class="main-color-border" style="border-bottom: 1px solid ;">
	@guest
		<a class="btn btn-link main-color m-0 p-0 my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Follow </a>
	@endguest
	@auth
		<form class="d-block m-0 p-0 my-2" method="post" action="{{route('like.brand', ['id' => $listing_id])}}">
			@csrf
			<span class=""><button class="btn btn-link main-color m-0 p-0" name="listing_id" value="{{$listing_id}}" style="font-size: 17px;">Follow {{$follow->count() }} <i class="{{ ( empty($followed->id) ? 'bi bi-heart' : 'bi bi-heart-fill' ) }}"></i></button></span>
		</form>
	@endauth
</div>
