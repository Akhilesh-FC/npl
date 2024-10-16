@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <h5 class="card-title mb-4">Role</h5>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style="position:absolute; top:30px; right:50px;">
            Create
        </button>
        <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <form action="{{route('roles.store')}}" method="post">
        <div class="modal-header">
            <div class="card-body">
                {{-- Section-2 --}}
                <h4 class="card-title">Role</h4>
                <hr>
                
                    @csrf
                    <div class="form">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label>Role Name<small>*</small></label>
                                <input type="text" class="form-control" name="name" placeholder="write here!!">
                            </div>
                        </div>
                    </div>
            </div>
     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
        <hr>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th><b>Permission/Role</b></th>
                        <th><b>Super Stokez</b></th>
                        <th><b>Stokez</b></th>
                        <th><b>Agents</b></th>
                    </tr>
                </thead>
                <form action="{{route('permissions.store')}}" method="post">
                    @csrf
                <tbody>

                    @foreach($permission as $key=>$item)
                        <tr>
                            <td>{{$item->name}}</td>
                         
                           
                            <td><input type="checkbox" name="SuperStokez[]" value="{{$key + 1}}" {{ in_array($key + 1, $permissionsData['SuperStokez']) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="Stokez[]" value="{{$key+1}}" {{ in_array($key + 1, $permissionsData['Stokez']) ? 'checked' : '' }}></td>
                            <td><input type="checkbox" name="Agents[]" value="{{$key+1}}" {{ in_array($key + 1, $permissionsData['Agents']) ? 'checked' : '' }}></td>
                        </tr>
                    @endforeach
                </tbody>
                <button type="submit" class="btn btn-success m-2">Submit</button>
                </form>
            </table>
        </div>
    </div>
</div>

@endsection
