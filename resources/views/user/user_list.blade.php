@extends('layouts.app')

@section('css')
<link href="{{ asset('css/user/user_list_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header font-weight-bold">
					User List
				</div>
				<div class="card-body">

					<form method="GET" action="{{ route('user.searchUser') }}">
						@csrf
						<div class="form-group row">
							<div class="col-lg-2 col-md-3 col-sm-6 p-1">
								<input type="text" class="form-control" name="name" placeholder="Name">
							</div>
							<div class="col-lg-2 col-md-3 col-sm-6 p-1">
								<input type="text" class="form-control" name="email" placeholder="Email">
							</div>
							<div class="col-lg-2 col-md-3 col-sm-6 p-1">
								<input type="text" class="form-control" name="created_from" placeholder="Created From">
							</div>
							<div class="col-lg-2 col-md-3 col-sm-6 p-1">
								<input type="text" class="form-control" name="created_to" placeholder="Created To">
							</div>
							<div class="col-lg-2 col-md-6 col-sm-6 p-1">
								<button type="submit" class="btn btn-primary btn-block">Search</button>
							</div>
							<div class="col-lg-2 col-md-6 col-sm-6 p-1">
								<a href="{{ route('user.getCreateUser') }}" type="button"
									class="btn btn-primary btn-block">Add</a>
							</div>
						</div>
					</form>

					<table class="table">
						<thead>
							<tr>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Create User</th>
								<th scope="col">Phone</th>
								<th scope="col">Date Of Birth</th>
								<th scope="col">Created Date</th>
								<th scope="col">Updated Date</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($userList as $user)
							<tr>
								<td>
									<a href="#" class="userDetail" data-name="{{ $user->name }}"
										data-email="{{ $user->email }}" data-type="{{ $user->type }}"
										data-phone="{{ $user->phone }}" data-address="{{ $user->address }}"
										data-dob="{{ $user->dob }}" data-profile="{{ $user->profile }}">
										{{ $user->name }}
									</a>
								</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->getUserName->name }}</td>
								<td>{{ $user->phone }}</td>
								<td>{{ $user->dob }}</td>
								<td>{{ $user->created_at->format('Y/m/d') }}</td>
								<td>{{ $user->updated_at->format('Y/m/d') }}</td>
								<td>
									<button type="button" class="btn btn-danger btn-sm btn-block deleteUser"
										data-deleteUserId="{{$user->id}}">Delete</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>

					<!-- User Detail Modal -->
					<div class="modal fade" id="userDetailModal" tabindex="-1" role="dialog"
						aria-labelledby="userDetailModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title font-weight-bold" id="userDetailModalLabel">User Detail</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="form-group row mb-4">
									<div class="col-md-12 d-flex justify-content-center">
										<div class="profile-container">
											<img class="profile-image" id="detailProfile" />
										</div>
									</div>
								</div>
								<div class="modal-body">
									<table class="table table-borderless">
										<tbody>
											<tr>
												<td class="font-weight-bold" style="width: 30%">Name:</td>
												<td id="detailName"></td>
											</tr>
											<tr>
												<td class="font-weight-bold">Email Address:</td>
												<td id="detailEmail"></td>
											</tr>
											<tr>
												<td class="font-weight-bold">Type:</td>
												<td id="detailType"></td>
											</tr>
											<tr>
												<td class="font-weight-bold">Phone:</td>
												<td id="detailPhone"></td>
											</tr>
											<tr>
												<td class="font-weight-bold">Address:</td>
												<td id="detailAddress"></td>
											</tr>
											<tr>
												<td class="font-weight-bold">Date of Birth:</td>
												<td id="detailDob"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Delete Confirm Modal -->
					<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
						aria-labelledby="deleteModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<form method="POST" action="{{ route('user.deleteUser') }}">
								{{ method_field('delete') }}
								{{ csrf_field() }}
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title font-weight-bold" id="deleteModalLabel">Delete Post
											Confirmation</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label class="col-md-12 col-form-label">
												Are you sure that you want to delete?
											</label>
										</div>
										<input type="hidden" name="deleteUserId" id="deleteUserId">
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-danger">Delete</button>
										<button type="button" class="btn btn-secondary"
											data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- Pagination -->
				<div class="d-flex justify-content-center">
					{{ $userList->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/user/user_list.js') }}" defer></script>
@endsection