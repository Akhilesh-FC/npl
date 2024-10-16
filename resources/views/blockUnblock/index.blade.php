@extends('admin.app')
@section('app')
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                {{-- Section-2 --}}
                                <h4 class="card-title">UnBlock Player</h4>
                                <hr>
                                <div class="form">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Username<small>*</small></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                 <button type="submit" class="btn btn-primary">UnBlock Players</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
@endsection
