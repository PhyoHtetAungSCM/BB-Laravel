@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user/update_user_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header font-weight-bold">Update User</div>
        <div class="card-body">
          <form method="POST" action="{{ route('user.updateUserConfirm', ['id' => $user->id]) }}"
            enctype="multipart/form-data">
            @csrf
            @if($errors->any())
            <div class="user-error-box">
              @foreach($errors->all() as $error)
              <span class="user-error-message">{{ $error }}</span>
              @endforeach
            </div>
            @endif
            <div class="form-group row mb-4">
              <div class="col-md-12 d-flex justify-content-center">
                <div class="user-profile-container">
                  @if($user->profile)
                  <img class="user-profile-image" id="uploadedProfile" src="/images/{{ $user->profile }}" />
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="title" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Name<span class="text-danger">*</span>
              </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Email Address<span class="text-danger">*</span>
              </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}">
              </div>
            </div>
            <div class="form-group row dropdown">
              <label for="type" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Type<span class="text-danger">*</span>
              </label>
              <div class="col-md-6">
                <select class="form-control" id="type" name="type">
                  @if($user->type == 0)
                  <option value="0" selected>Admin</option>
                  <option value="1">User</option>
                  @else
                  <option value="0">Admin</option>
                  <option value="1" selected>User</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Phone
              </label>
              <div class="col-md-6">
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Address
              </label>
              <div class="col-md-6">
                <textarea rows="3" class="form-control" id="address" name="address">{{ 
										$user->address
								}}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="dateOfBirth" class="col-md-4 col-form-label text-md-right font-weight-bold">Date of
                Birth</label>
              <div class="col-md-6">
                <input type="date" class="form-control" id="dob" name="dob" value="{{ $user->dob }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="profile" class="col-md-4 col-form-label text-md-right font-weight-bold">
                Profile
              </label>
              <div class="col-md-6">
                <input type="file" accept="image/*" onchange="loadFile(event)" id="profile" name="profile">
                <div class="update-profile-container">
                  <img id="updateUserProfile" class="update-profile-image" />
                </div>
              </div>
            </div>
            <div class="form-group row">
              <a href="{{ route('user.getChangePassword') }}" class="col-md-4 text-md-right">Change Password</a>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                  Confirm
                </button>
                <button type="button" class="btn btn-secondary px-3" onclick="updateUserClearance()">
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
<script src="{{ asset('js/user/update_user.js') }}" defer></script>
@endsection