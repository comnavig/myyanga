@extends('layouts.app')
@section('title', $post->name)

@section('content')
<div class="col-lg-7 col-md-12 col-sm-12" style="margin-top: 3%;">
	<h3 class="main-color font-weight-bolder"><span class="float-left">{{$post->name}}</span> </h3>
</div>
<div class="white-bg" style="width:100%; min-height: 300px; float: left; margin-bottom: 79px;">
	<div style="margin-top: 2%;">
		<div class="row m-0 p-0">
			<div class="col-lg-7 col-md-12 col-sm-12">
				<div class="product-image">
					<img src="{{$post->picture[1]->url}}" />
				</div>
				{!!$post->description!!}
				<div id="disqus_thread"></div>
				<script>
					/**
					*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
					
					var disqus_config = function () {
					this.page.url = "{{url()->current()}}";  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = "post{{$post->id}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};
					
					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = 'https://myyanga.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			</div>
			<div class="col-lg-5 col-md-12 col-sm-12 p-2">
				
				<div class="col-12" style=" display: flex; flex-wrap: wrap; justify-content: space-around;">
					@foreach($category->posts->take(9) as $post)
						<div class="product-item">
							<a class="link" href="{{route('blog.post', ['slug' =>$post->slug])}}">
								<div class="img" >
									<img src="{{$post->picture[0]->url }}" width="100%" />
								</div>
								{{ ( strlen($post->name) > 20 ? substr($post->name, 0, 15)."..." : $post->name ) }}
							</a>
						</div>
					@endforeach
				</div>
				<div class="col-12">
					<a class="btn btn-sm main-color-bg"href="{{route('blog.category',['id' => $post->post_category_id ])}}">See more</a>
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
