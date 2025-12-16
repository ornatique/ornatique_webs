@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card" style="height: 500px">
                <div class="card-body">
                    <h4 class="card-title mb-3">Link Add</h4>
                    <form action="{{ url('admin/link/add') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ old('name') }}" placeholder="Enter name*"
                                        id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Link <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('link') is-invalid @enderror" type="url"
                                        name="link" value="{{ old('link') }}" placeholder="Enter Link*"
                                        id="example-text-input">
                                    @error('link')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Icon <span class="text-danger">
                                            *</span></label>
                                    <img src="" alt="" id="preview-file" height="200px" class="mb-3">
                                    <input required type="file" class="form-control @error('icon') is-invalid @enderror"
                                        name="icon" id="image" value="{{ old('icon') }}">
                                    <span class="text-danger">(Note : Max Size -
                                        2MB)</span>
                                    @error('icon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
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

            $('#userMobileId').multiselect({
                columns: 1,
                placeholder: 'Select User',
                search: true,
                selectAll: true
            });
        })
    </script>
@stop
