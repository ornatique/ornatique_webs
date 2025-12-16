@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 overflow-hidden">
                        <h4 class="card-title float-start">Privacy policy</h4>
                        <a href="{{ url('admin/privacy-policy/edit') }}"> <button class="btn btn-primary float-end">Edit
                                Privacy policy</button></a>
                    </div>
                    <div>
                        {!! $data->privacy !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
