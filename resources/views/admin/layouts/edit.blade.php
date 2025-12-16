@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Layout</h4>
                    <form action="{{ url('admin/layouts/edit/' . $layout->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input required type="text" name="name" value="{{ old('name', $layout->name) }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Color --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Color <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width:30px;height:30px;background-color: {{ old('color', $layout->color) }};border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="colorText">{{ old('color', $layout->color) }}</span>
                                    </div>
                                    <input required type="color" name="color" value="{{ old('color', $layout->color) }}"
                                        id="colorPicker" class="form-control mb-2">
                                    <input type="text" id="colorInput" value="{{ old('color', $layout->color) }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Border --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Border Color <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="borderPreview"
                                            style="width:30px;height:30px;background-color: {{ old('border', $layout->border) }};border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="borderText">{{ old('border', $layout->border) }}</span>
                                    </div>
                                    <input required type="color" name="border"
                                        value="{{ old('border', $layout->border) }}" id="borderPicker"
                                        class="form-control mb-2">
                                    <input type="text" id="borderInput" value="{{ old('border', $layout->border) }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Shape --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Shape <span class="text-danger">*</span></label>
                                    <select name="shape" class="form-select">
                                        @foreach (['circle', 'rectangle', 'circle_with_border', 'rectangle_with_border'] as $shape)
                                            <option value="{{ $shape }}"
                                                {{ old('shape', $layout->shape) == $shape ? 'selected' : '' }}>
                                                {{ ucfirst($shape) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Image --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Image <span class="text-danger">*</span></label>
                                    <img id="preview-file"
                                        src="{{ asset('public/assets/images/layouts/' . $layout->image) }}" alt=""
                                        height="200px" class="mb-3">
                                    <input type="file" name="image" id="image" accept="image/*"
                                        class="form-control">
                                    <small class="text-muted">Leave empty if you don't want to change the image</small>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-select @error('category') is-invalid @enderror" name="category_id">
                                        <option value="">Please select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $layout->category_id == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Subcategory --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sub_category">Subcategory</label>
                                    <select class="form-select @error('sub_category') is-invalid @enderror"
                                        name="subcategory_id">
                                        <option value="">Please select Subcategory</option>
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $layout->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                                {{ ucfirst($subcategory->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Product --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select class="form-select @error('product') is-invalid @enderror" name="product_id">
                                        <option value="">Please select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $layout->product_id == $product->id ? 'selected' : '' }}>
                                                {{ ucfirst($product->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select">
                                        <option value="1"
                                            {{ old('status', $layout->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0"
                                            {{ old('status', $layout->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update Layout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            // Disable subcategory & product initially if no selection
            if (!$('select[name="category"]').val()) {
                $('select[name="sub_category"]').prop('disabled', true);
                $('select[name="product"]').prop('disabled', true);
            }

            // AJAX: Load subcategories
            $('select[name="category"]').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-subcategories') }}/' + categoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="sub_category"]').empty().append(
                                '<option value="" disabled selected>Select Subcategory</option>'
                            );
                            $('select[name="product"]').empty().append(
                                '<option value="" disabled selected>Select Product</option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="sub_category"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                            $('select[name="sub_category"]').prop('disabled', false);
                            $('select[name="product"]').prop('disabled', true);
                        }
                    });
                } else {
                    $('select[name="sub_category"]').empty().append(
                        '<option value="" disabled selected>Select Subcategory</option>').prop(
                        'disabled', true);
                    $('select[name="product"]').empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

            // AJAX: Load products
            $('select[name="sub_category"]').on('change', function() {
                var subcategoryID = $(this).val();
                if (subcategoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-products') }}/' + subcategoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="product"]').empty().append(
                                '<option value="" disabled selected>Select Product</option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value.id + '">' + value.name + '</option>');
                            });
                            $('select[name="product"]').prop('disabled', false);
                        }
                    });
                } else {
                    $('select[name="product"]').empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });


            function updateColor(val, picker, input, preview, text) {
                if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
                    $(picker).val(val);
                    $(input).val(val.toUpperCase());
                    $(preview).css('background-color', val);
                    $(text).text(val.toUpperCase());
                }
            }

            // Color
            $('#colorPicker').on('input', function() {
                updateColor($(this).val(), '#colorPicker', '#colorInput', '#colorPreview', '#colorText');
            });
            $('#colorInput').on('input paste', function() {
                updateColor($(this).val(), '#colorPicker', '#colorInput', '#colorPreview', '#colorText');
            });

            // Border
            $('#borderPicker').on('input', function() {
                updateColor($(this).val(), '#borderPicker', '#borderInput', '#borderPreview',
                    '#borderText');
            });
            $('#borderInput').on('input paste', function() {
                updateColor($(this).val(), '#borderPicker', '#borderInput', '#borderPreview',
                    '#borderText');
            });

            // Image preview
            $('#image').change(function() {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-file').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@stop
