@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Custom Estimate Edit</h4>
                    <div class="row">

                        <form action="{{ url('admin/custum/edit') . '/' . $data['id'] }}" method="post"
                            enctype="multipart/form-data">@csrf

                            <div class="col-lg-12">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                                *</span></label>
                                        <img src="{{ asset('public/assets/images/custom') . '/' . $data->image }}"
                                            alt="" id="preview-file" height="200px" class="mb-3">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            name=" image" id="image">
                                        <span class="text-danger">(Note : Max Size -
                                            2MB)</span>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formrow-password-input">Remarks<span class="text-danger">*</span></label>
                                    <textarea placeholder="Enter Remarks" name="remarks" id="classic-editor"
                                        class="form-control  @error('remarks') is-invalid @enderror" cols="30" rows="7" required>{{ $data->remarks }}</textarea>
                                    @error('remarks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!--<div class="col-md-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="formrow-password-input">Description<span class="text-danger">*</span></label>-->
                            <!--        <textarea placeholder="Enter Description" name="description" id="classic-editor"
                                class="form-control  @error('description') is-invalid @enderror" cols="30" rows="7" required>{{ $data->description }}</textarea>-->
                            <!--        @error('description')
        -->
                                <!--        <span class="invalid-feedback" role="alert">-->
                                <!--            <strong class="text-danger">{{ $message }}</strong>-->
                                <!--        </span>-->
                                <!--
    @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <br>
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
