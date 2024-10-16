@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <p>Player History</p>
        {{-- Super stokez  --}}
        <div class="form mt-3">
            <div class="row mb-2">                       
                <div class="col-sm-6">               
                    <label for="">Distributor <small>*</small></label>
                        <select class="form-control" aria-label="Default select example">
                            <option selected>Select</option>
                            <option value="1">Triple Chance</option>
                            <option value="2">12 Card</option>
                            <option value="3">16 Card</option>
                            <option value="3">Andar Bahar</option>
                            <option value="3">American Roulette</option>
                        </select>
                </div>
                    <div class="col-sm-6">
                        <label for="">Game Name <small>*</small></label>
                        <select class="form-control" aria-label="Default select example">
                            <option selected>Select</option>
                            <option value="1">Triple Chance</option>
                            <option value="2">12 Card</option>
                            <option value="3">16 Card</option>
                            <option value="3">Andar Bahar</option>
                            <option value="3">American Roulette</option>
                        </select>
                    </div>
                        <div class="form mt-4">
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
                                <div style="position: relative; top:54px; left:10px;">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                        <div class="table-responsive mt-4">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><b>Name </b></th>
                                        <th><b>Game Name</b></th>
                                        <th><b>Total Bet</b></th>
                                        <th><b>Total Won</b></th>
                                        <th><b>Ntp</b> </th>
                                        <th><b>Ntp Percent</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- code --}}
                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
    </div>
</div>
@endsection