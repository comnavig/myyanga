@php
	$tag = json_decode($tag, true);
@endphp
<div class="main-color-border" style="border-bottom: 1px solid ;">
	<h5 class="">
		<a class="btn btn-link main-color m-0 p-0 my-2" data-toggle="collapse" href="#tagValue" role="button" aria-expanded="false" aria-controls="tagValue">
			{{$tag['name']}}
		</a>
	</h5>
	<div class="collapse" id="tagValue">
		{{$tag['value']}}
	</div>
</div>
