@if($pyl->expired())
	@guest
		<a class="btn btn-sm main-color-bg my-2" style="font-size: 17px;" href="{{ route('login', ['redirect' => url()->full() ]) }}"> Login to Upload</a>
	@endguest
	@auth
		@if(Session::has('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<div class="container">
					{{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		@endif
		@if($errors->any())
		<div class="alert alert-danger">
			<div class="container">
				 <ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		</div>
		@endif
		<div class="main-color-border" style="border: 1px solid;">
			<form class="d-block m-0 p-0 my-2" method="post" action="{{route('pyl.upload')}}"  enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="pyl_id" value="{{$pyl->id}}"/>
				<div class="form-group d-flex justify-content-center">
					<div class="">
						<label for="picture">
							<img id="photo_img" src="{{asset('assets/img/image.svg')}}" width="200px" />
						</label>
						<input type="file" name="photo" class="form-control" id="picture" accept="image/jpeg, image/png" style="display: none;" onchange="loadFile(event, 'photo_img')"  aria-describedby="picturesHelp"/>
						<small id="picturesHelp" class="form-text text-muted red">Click to upload your photo.</small>
						<small id="picturesHelp" class="form-text text-muted red">Photo size should be less than 2mb</small>
						
						@error('picture')
							<small id="picturesHelp" class="form-text text-muted red">{{ $message }}</small>
						@enderror
						
					</div>
				</div>
				<button class="btn btn-sm btn-block main-color-bg" type="submit">Submit</button>
			</form>
			<script>
				var loadFile = function(event, image_id) {
										var image = document.getElementById(image_id);
										image.src = URL.createObjectURL(event.target.files[0]);
									};
			</script>
		</div>
	@endauth
@endif
