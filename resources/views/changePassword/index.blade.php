@extends('admin.app')
@section('app')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form action="#" method="post">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <hr>
                        <div class="form">
                            <label>Email<small style="color: red;">*</small></label>
                            <input type="email"name="email" class="form-control" value="{{ $user->email }}" readonly>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form">
                            <label>Current Password<small style="color: red;">*</small></label>
                            <input type="text" name="old_password" class="form-control">
                            @error('old_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form">
                            <label>New Password<small style="color: red;">*</small></label>
                            <input type="text" name="password" class="form-control">
                        </div>
                        <div class="form">
                            <label>Confirm Password<small style="color: red;">*</small></label>
                            <input type="text" name="confirm_password" class="form-control">
                        </div>
                        <div class="m-1">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
