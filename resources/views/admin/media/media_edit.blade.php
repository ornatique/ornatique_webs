@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Media</h4>

                    @if ($errors->any())
                        {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                    @endif

                    <form action="{{ url('admin/media/edit', $media->id) }}" method="post" enctype="multipart/form-data"
                        class="row">
                        @csrf

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text"
                                    name="name" value="{{ old('name', $media->name) }}" placeholder="Enter name*"
                                    required>
                                @error('name')
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $media->category_id == $category->id ? 'selected' : '' }}>
                                            {{ ucwords($category->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Sub Category</label>
                                <select class="form-select" name="subcategory_id" id="sub_category">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($sub_categories as $sub)
                                        <option value="{{ $sub->id }}" data-id="{{ $sub->category_id }}"
                                            {{ $media->subcategory_id == $sub->id ? 'selected' : '' }}>
                                            {{ ucwords($sub->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <input class="form-control @error('description') is-invalid @enderror" type="text"
                                    name="description" value="{{ old('description', $media->description) }}"
                                    placeholder="Enter description*">
                                @error('description')
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Image</label><br>
                                @if ($media->image)
                                    <img src="{{ asset('public/assets/images/media/' . $media->image) }}" id="preview-file"
                                        height="200px" class="mb-3">
                                @else
                                    <img src="" alt="" id="preview-file" height="200px" class="mb-3"
                                        style="display:none;">
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" accept="image/*">
                                <span class="text-danger">(Max size: 2MB)</span>
                                @error('image')
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Video --}}
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Media File (Video)</label><br>
                                @if ($media->media_file && Str::endsWith($media->media_file, ['.mp4', '.mov', '.webm']))
                                    <video id="preview-video" width="320" height="240" controls class="mb-3">
                                        <source src="{{ asset('public/assets/images/media/' . $media->media_file) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <video id="preview-video" width="320" height="240" controls class="mb-3"
                                        style="display:none;"></video>
                                @endif

                                <input type="file" class="form-control @error('media_file') is-invalid @enderror"
                                    name="media_file" id="media_file" accept="video/*">
                                <span class="text-danger">(Max size: 50MB)</span>
                                @error('media_file')
                                    <span class="invalid-feedback">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-success" type="submit">Update</button>
                            <a href="{{ route('admin_media_list') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

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
