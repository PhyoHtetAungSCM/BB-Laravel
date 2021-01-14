@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user/change_password_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header font-weight-bold">Change Password</div>
				<div class="card-body">
					<form method="POST" action="{{ route('user.changePassword') }}" enctype="multipart/form-data">
						@csrf
						@if($errors->any())
						<div class="user-error-box">
							@foreach($errors->all() as $error)
							<span class="user-error-message">{{ $error }}</span>
							@endforeach
						</div>
						@endif
						<div class="form-group row">
							<label for="oldPassword" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Old Password<span class="text-danger">*</span>
							</label>
							<div class="col-md-6">
								<input type="password" class="form-control" id="password" name="old_password">
							</div>
						</div>
						<div class="form-group row">
							<label for="confirmPassword" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Confirm Password<span class="text-danger">*</span>
							</label>
							<div class="col-md-6">
								<input type="password" class="form-control" id="confirmPassword"
									name="old_password_confirmation">
							</div>
						</div>
						<div class="form-group row">
							<label for="newPassword" class="col-md-4 col-form-label text-md-right font-weight-bold">
								New Password<span class="text-danger">*</span>
							</label>
							<div class="col-md-6">
								<input type="password" class="form-control" id="newPassword" name="new_password">
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Change
								</button>
								<button type="button" class="btn btn-secondary px-3"
									onclick="changePasswordClearance()">
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