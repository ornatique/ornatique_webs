@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card" style="height: 500px">
                <div class="card-body">
                    <h4 class="card-title mb-3">Link Add</h4>
                    <form action="{{ url('admin/social/add') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">



                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Facebook<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('facebook') is-invalid @enderror"
                                        type="url" name="facebook" value="{{ old('facebook') }}"
                                        placeholder="Enter Link*" id="example-text-input">
                                    @error('facebook')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">twitter<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('twitter') is-invalid @enderror"
                                        type="url" name="twitter" value="{{ old('twitter') }}" placeholder="Enter Link*"
                                        id="example-text-input">
                                    @error('twitter')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">instagram<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('instagram') is-invalid @enderror"
                                        type="url" name="instagram" value="{{ old('instagram') }}"
                                        placeholder="Enter Link*" id="example-text-input">
                                    @error('instagram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">linkedin<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('linkedin') is-invalid @enderror"
                                        type="url" name="linkedin" value="{{ old('linkedin') }}"
                                        placeholder="Enter Link*" id="example-text-input">
                                    @error('linkedin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">whatsapp<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('whatsapp') is-invalid @enderror"
                                        type="url" name="whatsapp" value="{{ old('whatsapp') }}"
                                        placeholder="Enter Link*" id="example-text-input">
                                    @error('whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">youtube<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('youtube') is-invalid @enderror"
                                        type="url" name="youtube" value="{{ old('youtube') }}"
                                        placeholder="Enter Link*" id="example-text-input">
                                    @error('youtube')
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
