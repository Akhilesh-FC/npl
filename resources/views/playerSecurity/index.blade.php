@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <p>Players Security</p>
            {{-- Table for Some Details --}}
        <div class="mt-3">
            <button class="btn btn-primary">Search</button>
        </div>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Last Login IP</th>
                        <th>Approved</th>
                        <th>Approved by</th>
                        <th>Date</th>
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>

        {{-- Live Status --}}
        <h4 class="card-title">Live Status</h4>
        <div class="table-responsive mt-3">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Instant Win Players</th>
                        <th>
                                                   
                        </th>
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