@php 
$favourites = App\ProductFavourite::where('product_id', $product_id)->get();
$liked = App\ProductFavourite::where([ ['product_id', $product_id], ['user_id', Auth::id() ] ])->get();
$liked = $liked->last();
@endphp
<div class="main-color-border" style="border-bottom: 1px solid ;">
	@guest
	    <p class="like">Login to <i class="fa-regular fa-heart"></i> Like  & Share <i class="fa-sharp fa-solid fa-share"></i></p>
		<!--a class="btn btn-link main-color m-0 p-0 my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Like & Share</a-->
	@endguest
	@auth
		<form class="d-block m-0 p-0 my-2" method="post" action="{{route('like.product', ['id' => $product_id])}}">
			@csrf
			<span class=""><button class="btn btn-link main-color m-0 p-0" name="product_id" value="{{$product_id}}" style="font-size: 17px;">Likes {{$favourites->count() }} <i class="{{ ( empty($liked->id) ? 'bi bi-heart' : 'bi bi-heart-fill' ) }}"></i></button></span>
		</form>
	@endauth
</div>
