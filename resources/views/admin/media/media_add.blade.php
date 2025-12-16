@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Media Add</h4>
                    <div class="row">
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <form action="{{ url('admin/media/add') }}" class="row" method="post" enctype="multipart/form-data"
                            novalidate>@csrf
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type=" text"
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
                                    <label for="example-text-input" class="form-label">Category <span class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option value="" hidden selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Sub Category <span
                                            class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="subcategory_id" id="sub_category">
                                        <option value="" hidden selected>Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option data-id="{{ $sub->category_id }}" value="{{ $sub->id }}">
                                                {{ ucwords($sub->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Description <span
                                            class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('description') is-invalid @enderror"
                                        type=" text" name="description" value="{{ old('description') }}"
                                        placeholder="Enter description*" id="example-text-input">
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                            *</span></label>
                                    <img src="" alt="" id="preview-file" height="200px" class="mb-3">
                                    <input required type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" accept="image/*">

                                    <span class="text-danger">(Note : Max Size -
                                        2MB)</span>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="media_file" class="form-label">Media File (Video)</label>
                                    <video id="preview-video" width="320" height="240" controls class="mb-3"
                                        style="display:none;"></video>

                                    <input type="file" class="form-control @error('media_file') is-invalid @enderror"
                                        name="media_file" id="media_file" accept="video/*">

                                    <span class="text-danger">(Max size: 40MB)</span>
                                    @error('media_file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>

                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Image Preview
            $('#image').change(function() {
                previewUploadImage(this, 'preview-file');
            });

            function previewUploadImage(input, element_id) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $(`#${element_id}`).attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Video Preview
            $('#media_file').on('change', function() {
                const file = this.files[0];
                const preview = document.getElementById('preview-video');

                if (file && file.type.startsWith('video/')) {
                    const blobURL = URL.createObjectURL(file);
                    preview.src = blobURL;
                    preview.style.display = 'block';
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });
        });
    </script>

@stop
