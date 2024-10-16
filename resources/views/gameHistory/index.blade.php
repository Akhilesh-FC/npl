@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <h3>Game History</h3>
        <hr>
        {{-- Super stokez  --}}
        <h6 class="card-title">Game Name<small>*</small></h6>
        <h5><select class="form-select text-muted border"></h5>
            <option selected>TC</option>
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
                        <th>S.no</th>
                        <th>Date & Time</th>
                        <th>Game</th>
                        <th>Win Position</th>
                        <th>Details</th>
                        <th>Bonus Spin</th>
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