@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 overflow-hidden">
                        <h4 class="card-title float-start">Privacy Policy / Terms & Conditions</h4>
                        {{-- <button class="btn btn-primary float-end">Edit Privacy policy</button> --}}
                    </div>
                    <form class="row g-3" action="{{ route('admin_privacy_policy_edit') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="" class="form-label">Edit Privacy Policy</label>
                                <textarea class="form-control" name="privacy" id="description" cols="50" rows="10">{!! $data->privacy !!}</textarea>
                            </div>
                            <div></div>

                            <div class="col-12 mb-2">
                                <label for="" class="form-label">Edit Terms & Conditions</label>
                                <textarea class="form-control" name="terms" id="description_tems" cols="50" rows="10">{!! $data->terms !!}</textarea>
                            </div>

                            <div class="col-2">
                                <button class="btn btn-primary ">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description');
            CKEDITOR.replace('description_tems');

        })
    </script>

@stop
