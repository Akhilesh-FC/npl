@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">

        {{-- Super stokez  --}}
        <p>TurnOver Point</p>
        <div class="form mt-3">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <label>Super Stokez<small class="text-muted">*</small></label>
                    <input type="text" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="">Game<small>*</small></label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>

        {{-- Date Form --}}
        <div class="form mt-3">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <label>From Date<small class="text-muted">*</small></label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-sm-6">
                    <label for="">To Date <small>*</small></label>
                    <input type="date" class="form-control">
                </div>
            </div>
        </div>
            {{-- Table for Some Details --}}
        <div class="mt-3">
            <button class="btn btn-primary">Search</button>
        </div>
        <h5 class="card-title">Admin Details(TN)</h5>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered" style="color: blue">
                <thead>
                    <tr>
                        <th>Play Point</th>
                        <th>Win Point</th>
                        <th>End Point</th>
                        <th>Points To Pay</th>
                        <th>Net</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>
        {{-- End Table --}}

        {{-- Live Status --}}
        <h5 class="card-title">Super Stockez Details(TN)</h5>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered" style="color: blue">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Play Point</th>
                        <th>Win Point</th>
                        <th>End Point</th>
                        <th>Super Stokez Point</th>
                        <th>Net</th>
                        <th>Type</th>
                        <th>Ntp %</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>
        {{-- End Live Status --}}

        {{-- start table --}}
        <h5 class="card-title">Admin Details <strong>(RV)</strong></h5>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered" style="color: blue">
                <thead>
                    <tr>
                        <th>Play Point</th>
                        <th>Win Point</th>
                        <th>End Point</th>
                        <th>Points To Pay</th>
                        <th>Net</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>
        {{-- End Table --}}

        {{-- Live Status --}}
        <h5 class="card-title">Super Stockez Details <strong>(RV)</strong></h5>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered" style="color: blue">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Play Point</th>
                        <th>Win Point</th>
                        <th>End Point</th>
                        <th>Super Stokez Point</th>
                        <th>Net</th>
                        <th>Type</th>
                        <th>Ntp %</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>
        {{-- End Live Status --}}
    </div>
</div>
@endsection
