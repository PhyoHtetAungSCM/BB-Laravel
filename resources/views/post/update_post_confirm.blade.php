@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-7">
			<div class="card">
				<div class="card-header font-weight-bold">Update Post Confirmation</div>
				<div class="card-body">
					<form method="POST" action="{{ route('post.updatePost', ['id' => $id]) }}">
						@csrf
						<div class="form-group row">
							<label for="title" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Title<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-form-label">
								<span>{{ $post->title }}</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="description" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Description<span class="text-danger">*</span>
							</label>
							<div class="col-md-6 col-form-label">
								<span>{{ $post->description }}</span>
							</div>
						</div>
						<div class="form-group row">
							<label for="status" class="col-md-4 col-sm-2 col-form-label text-md-right font-weight-bold">
								Status
							</label>
							<div class="col-md-6 col-sm-8 form-check">
								<div class="form-check">
									@if($post->status)
									<input type="checkbox" class="form-check-input" id="status" name="status" checked>
									@else
									<input type="checkbox" class="form-check-input" id="status" name="status">
									@endif
								</div>
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Create
								</button>
								<a type="button" href="javascript:history.back();"
									class="btn btn-secondary px-3 m-1">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection