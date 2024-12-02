@extends('layouts.main')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Account</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Account</li>
        </ol>
    </nav>
@endsection

@section('main')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body px-0 pt-0 pb-2">
            <form action="{{ route('accupdate', ['id' => $findAccount->id]) }}" method="POST">
                @csrf
                @method('POST')
                <div class="row p-5">
                    <div class="col-lg-6">
                        <label class="form-control-label" for="basic-url">Username</label>
                        <div class="input-group">
                            <input type="text" name="username" class="form-control font-weight-bold" placeholder="User Name" value="{{ old('name', $findAccount->name) }}" id="basic-url" aria-describedby="basic-addon3" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-control-label" for="basic-url">Email</label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control font-weight-bold" placeholder="Email" value="{{ old('email', $findAccount->email) }}" id="basic-url" aria-describedby="basic-addon3" required>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-control-label" for="basic-url">Password <span class="text-danger">(Min 8 characters)</span></label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control font-weight-bold" placeholder="New Password (leave blank if not changing)" id="basic-url" aria-describedby="basic-addon3" minlength="8">
                        </div>
                        <small class="form-text text-muted">
                            Ensure your password is at least 8 characters long, includes a mix of letters, numbers, and special characters for better security.
                        </small>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-control-label" for="basic-url">Confirm Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" class="form-control font-weight-bold" placeholder="Confirm Password" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label for="exampleFormControlSelect1">Role  <span class="text-danger">*</span></label>
                        <select class="form-control" name="role" id="roleDropdown" required>
                           <option value="">Select One</option>
                           <option value="0" {{ $findAccount->role == 0 ? 'selected' : '' }} >Cashier</option>
                           <option value="1" {{ $findAccount->role == 1 ? 'selected' : '' }} >Staff</option>
                           <option value="2" {{ $findAccount->role == 2 ? 'selected' : '' }} >Admin</option>
                           <option value="3" {{ $findAccount->role == 3 ? 'selected' : '' }} >Super Admin</option>
                        </select>
                    </div>

                    <div class="col-lg-12 text-end mt-5">
                        <button type="submit" class="btn btn-success">
                            Save</button>
                        <a type="button" href="{{ route('account') }}" class="btn btn-danger">
                            Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
