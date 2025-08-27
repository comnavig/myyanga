<div class="main-color-border" style="border-bottom: 1px solid ;">
	<h5 class="">
		<a class="btn btn-link main-color m-0 p-0 my-2" data-toggle="collapse" href="#productReview" role="button" aria-expanded="false" aria-controls="productReview">
			Reviews 
		</a>
	</h5>
	<div class="collapse" id="productReview">
		<div style="width: 100%; max-height: 400px; overflow-y: auto;">
			@foreach($reviews as $review)
			<div class="col-12" style="border-bottom: 1px solid #ddd;">
				<p>
					{{$review->review}} <small> by <strong>{{$review->user->name}}</strong> at {{$review->created_at->format('jS M Y h:iA') }}</small>
				</p>
			</div>
			@endforeach
		</div>
		@auth
			@if (in_array($product_id, $products_purchased))
				<div class="col-12 mb-2">
					<form method="post" action="{{route('shop.product.review')}}">
						@csrf
						<input name="product_id" type="hidden" value="{{$product_id}}" />
						<div class="form-group">
							<textarea class="form-control col-12" name="review" placeholder="Write your review"></textarea>
						</div>
						<button class="btn btn-sm main-color-bg ">Send</button>
					</form>
				</div>
			@endif
		@endauth
	</div>
</div>
