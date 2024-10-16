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
                                <h4 class="card-title">Player Adjust Points</h4>
                                <hr>
                                <div class="form">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Username<small>*</small></label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Balance</label>
                                            <input type="number" class="form-control">
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="form">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Amount To Transfer<small>*</small></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>                               
                                    <button type="submit" class="btn btn-primary">Save</button>
                                {{-- End Section-1 --}}
                                    {{-- Section-2 --}}
                                    <h5 class="card-title">Stockez/Agent Transfer Points</h5>
                                <hr>
                                <div class="form">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Username<small>*</small></label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Balance</label>
                                            <input type="number" class="form-control">
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="form">
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Amount To Transfer<small>*</small></label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>                               
                                <button type="submit" class="btn btn-primary">Save</button>
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