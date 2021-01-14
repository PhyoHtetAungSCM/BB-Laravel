@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user/update_user_confirm_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header font-weight-bold">Update User Confirmation</div>
        <div class="card-body">
          <form id="form" method="POST" action="{{ route('user.updateUser', ['id' => $user->id]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group row mb-4">
              <div class="col-md-12 d-flex justify-content-center">
                <div class="profile-container">
                  @if($user->profile)
                  <img class="profile-image" src="/images/{{ $profile }}" />
                  @elseif($profileFromDB)
                  <img class="profile-image" src="/images/{{ $profileFromDB }}" />
                  @endif
                </div>
              </div>
            </div>

            <table class="table">
              <tbody>
                <tr>
                  <td class="font-weight-bold" style="width: 30%">Name:</td>
                  <td>{{ $user->name }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Email Address:</td>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Type:</td>
                  <td>
                    @if($user->type == 0)
                    Admin
                    @else
                    User
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Phone:</td>
                  <td>{{ $user->phone }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Address:</td>
                  <td>{{ $user->address }}</td>
                </tr>
                <tr>
                  <td class="font-weight-bold">Date of Birth:</td>
                  <td>{{ $user->dob }}</td>
                </tr>
              </tbody>
            </table>

            <div class="form-group row">
              <div class="col-md-12 d-flex justify-content-center mt-1 mb-1">
                <button type="submit" class="btn btn-primary m-1">
                  Update
                </button>
                <a type="button" href="javascript:history.back();" class="btn btn-secondary px-3 m-1">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection