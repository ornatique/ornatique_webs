@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Layout Add</h4>
                    <form action="{{ url('admin/layouts/add') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">
                            {{-- Name --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input required type="text" name="name" value="{{ old('name') }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Color --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Color <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width:30px;height:30px;background-color:#ffffff;border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="colorText">#FFFFFF</span>
                                    </div>
                                    <input required type="color" name="color" value="{{ old('color', '#ffffff') }}"
                                        id="colorPicker" class="form-control mb-2">
                                    <input type="text" id="colorInput" value="{{ old('color', '#ffffff') }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Border --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Border Color <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="borderPreview"
                                            style="width:30px;height:30px;background-color:#000000;border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="borderText">#000000</span>
                                    </div>
                                    <input required type="color" name="border" value="{{ old('border', '#000000') }}"
                                        id="borderPicker" class="form-control mb-2">
                                    <input type="text" id="borderInput" value="{{ old('border', '#000000') }}"
                                        class="form-control">
                                </div>
                            </div>

                            {{-- Shape --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Shape <span class="text-danger">*</span></label>
                                    <select name="shape" class="form-select">
                                        <option value="">Select Shape</option>
                                        @foreach (['circle', 'rectangle', 'circle_with_border', 'rectangle_with_border'] as $shape)
                                            <option value="{{ $shape }}"
                                                {{ old('shape') == $shape ? 'selected' : '' }}>{{ ucfirst($shape) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Image --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Image <span class="text-danger">*</span></label>
                                    <img id="preview-file" src="" alt="" height="200px" class="mb-3">
                                    <input required type="file" name="image" id="image" accept="image/*"
                                        class="form-control">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subcategory_id">Subcategory <span class="text-danger">*</span></label>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror"
                                        name="subcategory_id">
                                        <option value="" disabled selected>Select Subcategory</option>
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                {{ ucfirst($subcategory->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <span class="invalid-feedback" role="alert"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                    <select class="form-select @error('product_id') is-invalid @enderror"
                                        name="product_id">
                                        <option value="" disabled selected>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ ucfirst($product->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>


                            {{-- Status --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12">
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

            // Disable subcategory & product initially
            $('select[name="subcategory_id"]').prop('disabled', true);
            $('select[name="product_id"]').prop('disabled', true);

            // When category changes
            $('select[name="category_id"]').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-subcategories') }}/' +
                            categoryID, // Laravel url helper
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="subcategory_id"]').empty().append(
                                '<option value="" disabled selected>Select Subcategory</option>'
                            );
                            $('select[name="product_id"]').empty().append(
                                '<option value="" disabled selected>Select Product</option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="subcategory_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                            $('select[name="subcategory_id"]').prop('disabled',
                                false); // enable subcategory
                            $('select[name="product_id"]').prop('disabled',
                                true); // disable product
                        }
                    });
                } else {
                    $('select[name="subcategory_id"]').empty().append(
                        '<option value="" disabled selected>Select Subcategory</option>').prop(
                        'disabled', true);
                    $('select[name="product_id"]').empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

            // When subcategory changes
            $('select[name="subcategory_id"]').on('change', function() {
                var subcategoryID = $(this).val();
                if (subcategoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-products') }}/' + subcategoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('select[name="product_id"]').empty().append(
                                '<option value="" disabled selected>Select Product</option>'
                            );
                            $.each(data, function(key, value) {
                                $('select[name="product_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                            $('select[name="product_id"]').prop('disabled',
                                false); // enable product
                        }
                    });
                } else {
                    $('select[name="product_id"]').empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

        });
    </script>


    <script>
        $(document).ready(function() {
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
