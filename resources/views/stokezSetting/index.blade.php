@extends('admin.app')
@section('app')
<div class="card">
    <div class="card-body">
        <p>Stokez Setting</p>
        {{-- Super stokez  --}}
        <h3 class="card-title mb-4">Super Stokez</h3>
        <hr>
            <h4 class="mt-1"><select class="form-select text-muted border"></h4>
                <option selected>Select</option>
                <option value="1">High</option>
                <option value="2">Medium</option>
            </select>
            <div>
                <h4 class="mt-1"><select class="form-select text-muted border"></h4>
                    <option selected>Select</option>
                    <option value="1">High</option>
                    <option value="2">Medium</option>
                </select>
            </div>
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
        </div>

        {{-- stokez --}}
        <h3 class="card-title mb-4">Stokez</h3>
        <hr>
        <div>
            <h4 class="mt-1"><select class="form-select text-muted border"></h4>
                <option selected>Select</option>
                <option value="1">High</option>
                <option value="2">Medium</option>
            </select>
        </div>
        <div>
            <h4 class="mt-1"><select class="form-select text-muted border"></h4>
                <option selected>Select</option>
                <option value="1">High</option>
                <option value="2">Medium</option>
            </select>
        </div>
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
        </div>
        {{-- Agent --}}
        <h3 class="card-title mb-4">Agents</h3>
        <hr>
        <div>
            <h4 class="mt-1"><select class="form-select text-muted border"></h4>
                <option selected>Select</option>
                <option value="1">High</option>
                <option value="2">Medium</option>
            </select>
        </div>
        <div>
            <h4 class="mt-0"><select class="form-select text-muted border"></h4>
                <option selected>Select</option>
                <option value="1">High</option>
                <option value="2">Medium</option>
            </select>
        </div>
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
        </div>
    </div>
</div>
@endsection