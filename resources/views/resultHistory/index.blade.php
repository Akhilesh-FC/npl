@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Settings</h5>
        <hr>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Total Bet</th>
                        <th>Total Win</th>
                        <th>Total Profit</th>
                    </tr>
                </thead>
                <tbody>
                        {{-- code --}}
                </tbody>
            </table>
        </div>
        <h6 class="text-muted">Change Spin2win Game Settings</h6>
<p><strong>Game</strong></p>
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr style="color: black;">
                        <th>Name</th>
                        <th>Spin2win</th>
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