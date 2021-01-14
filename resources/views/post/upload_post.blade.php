@extends('layouts.app')

@section('css')
<link href="{{ asset('css/post/upload_post_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header font-weight-bold">Upload CSV File</div>
				<div class="card-body">
					<form method="POST" action="{{ route('post.import') }}" enctype="multipart/form-data">
						@csrf
						@if($errors->any())
						<div class="post-error-box">
							@foreach($errors->all() as $error)
							<span class="post-error-message">{{ $error }}</span>
							@endforeach
						</div>
						@endif
						@if(session()->has('failures'))
						<table class="table table-danger">
							<tr>
								<th>Row</th>
								<th>Attribute</th>
								<th>Errors</th>
								<th>Value</th>
							</tr>
							@foreach(session()->get('failures') as $failure)
							<tr>
								<td>{{ $failure->row() }}</td>
								<td>{{ $failure->attribute() }}</td>
								<td>
									@foreach($failure->errors() as $error)
									{{ $error }}
									@endforeach
								</td>
								<td>{{ $failure->values()[$failure->attribute()] }}</td>
							</tr>
							@endforeach
						</table>
						@endif
						<div class="form-group row">
							<label for="profile" class="col-md-4 col-form-label text-md-right font-weight-bold">
								Import File From:
							</label>
							<div class="col-md-6">
								<input type="file" class="form-control-file" name="file" accept=".csv">
							</div>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Import File
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