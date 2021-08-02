<div class="main-color-border" style="border-bottom: 1px solid ;">
	@guest
		<a class="btn btn-link main-color m-0 p-0 my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to view Styling Tips </a>
	@endguest
	@auth
		<h5 class="">
			<a class="btn btn-link main-color m-0 p-0 my-2" data-toggle="collapse" href="#productStylingTips" role="button" aria-expanded="false" aria-controls="productStylingTips">
				Styling Tips
			</a>
		</h5>
		<div class="collapse" id="productStylingTips">
		  {!!$tips!!}
		</div>
	@endauth
</div>
