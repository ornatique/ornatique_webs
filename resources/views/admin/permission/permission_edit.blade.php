@extends('admin.template')
@section('main')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Category Edit</h4>
                <div class="row">

                    <form action="{{ url('admin/permission/edit').'/'.$data->id }}" method="post"
                        enctype="multipart/form-data">@csrf
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">User <span class="text-danger">
                                        *</span></label>

                                <select class="form-select" aria-label="Default select example" name="user_id" required>
                                    <option class="form-control" selected disabled="" hidden="" value="">
                                        Please select User</option>
                                    @foreach ($users as $user)
                                    <option class="form-control form-select"
                                        {{ $user->id == $data->user_id ? 'selected' : '' }} value="{{ $user->id }}">
                                        {{ ucfirst($user->number) }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Category <span class="text-danger">
                                        *</span></label>

                                <select class="form-select" aria-label="Default select example" name="category_id"
                                    required>
                                    <option class="form-control" selected disabled="" hidden="" value="">
                                        Please select Category</option>
                                    @foreach ($categories as $category)
                                    <option class="form-control form-select"
                                        {{ $category->id == $data->category_id ? 'selected' : '' }}
                                        value="{{ $category->id }}">
                                        {{ ucfirst($category->name) }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#image').change(function() {
        previewUploadImage(this, 'preview-file')
    });

    function previewUploadImage(input, element_id) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $(`#${element_id}`).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
})
</script>
@stop