@extends('layouts.admin')
@section('title', 'New TV Category')
@section('page.title', 'Add New Category')
@section('content')
<div class="container mt-2">
	<div class="col-lg-5 col-sm-12 mt-2">
		<form method="post" action="{{route('admin.tv.category.add')}}">
			@csrf
			<div class="form-group">
				<label for="names">Names</label>
				<textarea type="text" name="names" class="form-control" id="names" aria-describedby="nameHelp">{{ old('names') }}</textarea>
				<small id="nameHelp" class="form-text text-muted">Type in the categories, separating each with a comma (,)</small>
				@error('names')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<button type="submit" class="btn main-color-bg">Add</button>
		</form>
	</div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('assets/css/bootstrap-datepicker3.css')}}"/>
@endpush
@push('scripts')
    <script src="{{url('assets/js/bootstrap-datepicker.js')}}" ></script>
    <script>
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
		});
    </script>
@endpush
