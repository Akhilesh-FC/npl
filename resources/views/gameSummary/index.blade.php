@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <p>Game Summary</p>
        {{-- Super stokez  --}}
        <div class="col-sm-6">
            <label for="">Game Name</label>
            <select class="form-control" aria-label="Default select example">
                <option selected>Spin 2Win</option>
                <option value="1">Triple Chance</option>
                <option value="2">12 Card</option>
                <option value="3">16 Card</option>
                <option value="3">Andar Bahar</option>
                <option value="3">American Roulette</option>
              </select>
        </div>
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
                        <th><b>ID</b></th>
                        <th><b>Game Name</b></th>
                        <th><b>Total Play Points</b></th>
                        <th><b>Total Win Amount</b></th>
                        <th><b>Total Loss Amount</b></th>
                        <th><b>Average Bet</b></th>
                        <th><b>Percentage</b></th>
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