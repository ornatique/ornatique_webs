@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Sub-Category Edit</h4>
                    <div class="row">

                        <form action="{{ url('admin/subcategory/edit') . '/' . $data->id }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Sub-Category Name <span
                                            class="text-danger">
                                            *</span></label>
                                    <input required class="form-control" type="text" name="name"
                                        value="{{ ucfirst($data->name) }}" placeholder="Enter name*"
                                        id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if ($errors->any())
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                            @endif

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formrow-email-input">Category Name</label><span class="text-danger">*</span>
                                    <select required class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" aria-label="Default select example">
                                        <option selected disabled hidden value="">Please select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                        @endforeach
                                    </select>
                                    @error('sub_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            {{-- <div class="col-lg-4 pt-2">
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Quantity <span class="text-danger">
                                        *</span></label>
                                <input required class="form-control" type="number" name="quantity" value="{{$data->quantity}}" placeholder="Enter quantity*" id="example-text-input">
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}
                            <div class="col-4 mb-2">
                                <div class="form-group">
                                    <label class="form-label" for="formrow-email-input">Priority<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('priority') is-invalid @enderror"
                                        name="priority" placeholder="Enter Priority (Ex: 1)" value="{{ $data->priority }}">
                                    @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="color" class="form-label">Color <span
                                            class="text-danger">*</span></label>

                                    <!-- Color preview -->
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width: 30px; height: 30px; background-color: {{ old('color', $data->color) }}; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <span id="colorText">{{ old('color', $data->color) }}</span>
                                    </div>

                                    <!-- Native color picker -->
                                    <input required class="form-control mb-2 @error('color') is-invalid @enderror"
                                        type="color" name="color" value="{{ old('color', $data->color) }}"
                                        id="colorPicker">

                                    <!-- Extra text input for hex code -->
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="colorInput" placeholder="#000000" value="{{ old('color', $data->color) }}">

                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-lg-12">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                                *</span></label>
                                        <img @if ($data->image) src="{{ asset('public/assets/images/subcategories') . '/' . $data->image }}" @endif
                                            alt="" id="preview-file" height="200px" class="mb-3">
                                        <input type="file" class="form-control" name="image" id="image"
                                            accept="image/*">
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

            // 🔹 Color picker + hex input sync
            function updateColor(val) {
                if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
                    $('#colorPicker').val(val);
                    $('#colorInput').val(val.toUpperCase());
                    $('#colorPreview').css('background-color', val);
                    $('#colorText').text(val.toUpperCase());
                }
            }

            $('#colorPicker').on('input', function() {
                updateColor($(this).val());
            });

            $('#colorInput').on('input paste', function() {
                updateColor($(this).val());
            });
        })
    </script>


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
