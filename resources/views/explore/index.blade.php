<div class="collapse " id="exploreMenu">
	<div class="position-fixed dark-grey-bg" style="width: 100%; min-height: 100vh; height: 100%; top: 0; overflow: scroll; z-index: 9999;">
		<div class="col-12" style="height: 10vh;">
			<a class="float-left" href="{{ url('/') }}"> <img src="{{asset('assets/img/logo.svg')}}" width="180px"/> </a>
			<a class="btn btn-sm gold float-right m-3" data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Close</a>
		</div>
		@php
			$categories = App\Category::all();
		@endphp
		
		<div class="col-12" style="overflow-y: auto; margin-bottom: 20px;">
			<div class="container explore">
				<div class="row" id="eCategory">
					@foreach($categories->where('parent', 0 ) as $category)
						<div class="col-lg-3 col-md-12 col-sm-12 gold-border p-0" style="border-bottom: 1px solid;">
							<div class="d-flex align-items-center" style="height: 50px;">
								<h6 class="text-uppercase py-1 p-0">
									<a class="gold" data-toggle="collapse" href="#ec{{$category->id }}" role="button" aria-expanded="false" aria-controls="ec{{$category->id }}" >
										{{$category->name }}
									</a>
								</h6>
							</div>
							<div class="collapse" id="ec{{$category->id }}"  data-parent="#eCategory">
								@foreach($category->subcategories as $subcategory)
									<div class="brand d-flex align-items-center">
<!--
										<a class="link gold" href="{{route('explore.category', ['id' => $subcategory->id ])}}">{{$subcategory->name}}({{ $subcategory->product->count() }})</a>
-->
										<a class="link gold" href="{{route('explore.category', ['id' => $subcategory->id ])}}">{{$subcategory->name}}</a>
									</div>
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
		
		<div class="col-12" style="margin-bottom: 20px;">
			@php
				$photo = array();
			@endphp
			<div class="container">
				<div id="" class="adts owl-carousel" data-items="1">
						@foreach($ads as $ad)
							@php
								$photo = json_decode($ad->photo, true); 
							@endphp
							<div>
								<a href="{{ $ad['url'] }}">
									<img class="d-none d-sm-none d-lg-block" src="{{ $photo['desktop'] }}" alt="{{ $ad['name'] }}"  />
									<img class="d-block d-sm-block d-lg-none" src="{{ $photo['mobile'] }}" alt="{{ $ad['name'] }}"  width="300px" />
								</a>
							</div>
						@endforeach
				</div>
				
			</div>
		</div>
		
		<div class="col-12" style="margin-bottom: 10px;">
			<div class="container">
				<div class="other-section">
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="{{route('shop')}}">
								<i class="fas fa-shopping-cart fa-2x"></i>
								<span>Shop</span>
							</a>
						</div>
						
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="@guest{{route('login' ,['redirect' => route('pyls') ])}}@endguest @auth {{route('pyls')}}@endauth">
								<i class="fas fa-file-image fa-2x"></i>
								<span class="text-center">Post Your Look<br/>Competitions</span>
							</a>
						</div>
					
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="{{route('tvs')}}">
								<i class="fab fa-youtube fa-2x"></i>
								<span>My Yanga Tv</span>
							</a>
						</div>
						
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="{{route('groomtips')}}">
								<i class="fas fa-info-circle fa-2x"></i>
								<span>Grooming<br/>Tips</span>
							</a>
						</div>
						
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="{{route('blog')}}">
								<i class="fab fa-blogger fa-2x"></i>
								<span>Blog</span>
							</a>
						</div>
						
						<div class="box d-flex justify-content-center">
							<a class="gold text-center" href="{{route('discovers')}}">
								<i class="fas fa-map-marked-alt fa-2x"></i>
								<span>Discover</span>
							</a>
						</div>
						
					
					</div>
			</div>
		</div>
		
		
		<footer class="col-12 d-block d-sm-block d-lg-none"  style="float: left; font-size: 14px;">
			<div class="container">
				<div class="row">
					<div class="col-12 d-flex justify-content-center">
						<p class="white">Powered by <a class="gold btn-link" href="http://www.zonicme.com" target="_blank">ZonicMe</a> 
							| <a class="gold btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About us</a> 
							| <a class="gold btn-link" href="{{route('pages', ['slug' => 'privacy_policy'])}}">Privacy Policy</a>
							| <a class="gold btn-link" href="{{route('pages', ['slug' => 'terms'])}}">Terms</a>
							| <a class="gold btn-link" href="{{route('pages', ['slug' => 'contact'])}}">Contact us</a>
						</p>
					</div>
					<div class="col-12 p-0 d-flex justify-content-center">
						<a class="btn btn-md gold float-right" href="https://www.facebook.com/MyYangaAfrica/?ref=pages_you_manage"><i class="bi bi-facebook"></i></a>
						<a class="btn btn-md gold float-right" href="https://www.instagram.com/myyanga_backup/"><i class="bi bi-instagram"></i></a>
						<a class="btn btn-md gold float-right" href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i class="bi bi-linkedin"></i></a>
					</div>
				</div>
			</div>
		</footer>
	
		
	</div>
</div>
