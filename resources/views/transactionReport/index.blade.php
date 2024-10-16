@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <p>Transaction Report</p>
        {{-- Super stokez  --}}
        <h4 class="card-title">Distributor<small>*</small></h4>
        <h5><select class="form-select form-select-lg text-muted border" aria-label=".form-select-lg"></h5>
            <option selected>NPL</option>
            <option value="1">High</option>
            <option value="2">Medium</option>
        </select>
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
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Transaction With</th>
                        <th>Old Points</th>
                        <th>Out</th>
                        <th>In</th>
                        <th>New Points</th>
                        <th>Reference</th>
                        <th>Transfer By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- code --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection