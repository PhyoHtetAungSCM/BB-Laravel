@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user/user_profile_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header font-weight-bold">Profile</div>
				<div class="card-body" style="margin: 0 20px;">
					@csrf
					<div class="form-group row mb-4">
						<div class="col-md-12 d-flex justify-content-center">
							<div class="profile-container">
								@if($userProfile->profile)
								<img class="profile-image" src="/images/{{ $userProfile->profile }}" />
								@endif
							</div>
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col-md-12 d-flex justify-content-center mb-4">
							<a type="button" class="btn btn-secondary bn-sm profile-edit-btn"
								href="{{ route('user.getUpdateUser', ['id' => $userProfile->id]) }}">Edit</a>
						</div>
					</div>
					<table class="table">
						<tbody>
							<tr>
								<td class="font-weight-bold" style="width: 30%">Name:</td>
								<td>{{ $userProfile->name }}</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Email Address:</td>
								<td>{{ $userProfile->email }}</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Type:</td>
								<td>
									@if($userProfile->type == 0)
									Admin
									@else
									User
									@endif
								</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Phone:</td>
								<td>{{ $userProfile->phone }}</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Date of Birth:</td>
								<td>{{ $userProfile->dob }}</td>
							</tr>
							<tr>
								<td class="font-weight-bold">Address:</td>
								<td>{{ $userProfile->address }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection