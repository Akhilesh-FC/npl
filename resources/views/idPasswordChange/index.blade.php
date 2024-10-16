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
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <hr>
                        <div class="form">
                            <label>Username<small style="color: red;">*</small></label>
                            <input type="text" class="form-control" placeholder="NPL">
                        </div>
                        <div class="form">
                            <label>Current Password<small style="color: red;">*</small></label>
                                <input type="text" class="form-control">
                        </div>
                        <div class="form">
                            <label>New Password<small style="color: red;">*</small></label>
                                <input type="text" class="form-control">
                        </div>
                        <div class="form">
                            <label>Confirm Password<small style="color: red;">*</small></label>
                                <input type="text" class="form-control">
                        </div>
                        <button type="button" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
