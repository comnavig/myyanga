
<div class="main-color-border" style="min-height: 300px;">
	@if($expired)
		@guest
			<a class="btn btn-lg btn-block main-color-bg m-0 p-0 my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Vote</a>
		@endguest
		@auth
			<form class="d-block m-0 p-0 my-2" method="post" action="{{route('pyls.competition.entry.vote')}}">
				@csrf
				<span class=""><button class="btn btn-lg btn-block main-color-bg" name="upyl_id" value="{{$upyl_id}}" style="font-size: 17px;">Vote</button></span>
			</form>
		@endauth
	@endif
	<p>has ({{count($votes)}}) votes so far.</p>

</div>
