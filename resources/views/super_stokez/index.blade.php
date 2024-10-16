@extends('admin.app')
@section('app')
    <div class="card">
        <div class="card-body">

            <h5 class="card-title mb-4">Super Stokez</h5>
            {{-- Create Model --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
                style="position:absolute; top:30px; right:50px;">
                Create
            </button>
            <form action="{{ route('SuperStokezStore') }}" method="POST">
                @csrf
                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="card-body">

                                    {{-- Section-2 --}}
                                    <h4 class="card-title">Create Super Stokez</h4>
                                    <hr>
                                    <div class="form">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <label>Email<small>*</small></label>
                                                <input type="email" class="form-control" name="email">

                                            </div>
                                            <div class="col-sm-6">
                                                <label for="">Password<small>*</small></label>
                                                <input type="number" class="form-control" name="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Name</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label>Revenue Percent<small>*</small></label>
                                            <input type="text" class="form-control" name="revenue" placeholder="0">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Parent<small>*</small></label>
                                            <select class="form-control" aria-label="Default select example">
                                                <option selected="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>
    <div class="table-responsive">
        <table id="zero_config" class="table table-striped table-bordered">
            <thead>

                <tr>
                    <th><b>id</b></th>
                    <th><b>Username</b></th>
                    <th><b>Password</b></th>
                    <th><b>Name</b></th>
                    <th><b>Type</b></th>
                    <th><b>Balance</b></th>
                    <th><b>Parent</b></th>
                    <th><b>Revenue</b></th>
                    <th><b>Actions</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->password }}</td>
                        <td>{{ $item->name }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $item->parent_id }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
