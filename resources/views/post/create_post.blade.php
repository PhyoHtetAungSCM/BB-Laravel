@extends('layouts.app')

@section('css')
<link href="{{ asset('css/post/create_post_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header font-weight-bold">Create Post</div>
				<div class="card-body">
					<form method="POST" action="{{ route('post.createPostConfirm') }}">
						@csrf
						@if($errors->any())
						<div class="post-error-box">
							@foreach($errors->all() as $error)
							<span class="post-error-message">{{ $error }}</span>
							@endforeach
						</div>
						@endif
						<div class="form-group row">
							<label for="title" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Title<span class="text-danger">*</span>
							</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="title" name="title">
							</div>
						</div>
						<div class="form-group row">
							<label for="description" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Description<span class="text-danger">*</span>
							</label>
							<div class="col-md-6">
								<textarea rows="3" class="form-control" id="description" name="description"></textarea>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">Confirm</button>
								<button type="button" class="btn btn-secondary px-3" onclick="createPostClearance()">
									Clear
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/post/create_post.js') }}" defer></script>
@endsection