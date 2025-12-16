@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Essential</h4>
                    <div class="row">
                        <form action="{{ url('admin/essential/add') }}" method="post">@csrf

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
                                    <select class="form-select @error('product_id') is-invalid @enderror" name="product_id">
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bg_color">Background Color <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="color" id="bg_color_picker" class="form-control"
                                            value="{{ old('bg_color', '#ffffff') }}">
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        <input type="text" id="bg_color_text" name="bg_color" class="form-control"
                                            value="{{ old('bg_color', '#ffffff') }}">
                                    </div>
                                    @error('bg_color')
                                        <span class="invalid-feedback" role="alert"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Color <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="color" id="color_picker" class="form-control"
                                            value="{{ old('color', '#000000') }}">
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        <input type="text" id="color_text" name="color" class="form-control"
                                            value="{{ old('color', '#000000') }}">
                                    </div>
                                    @error('color')
                                        <span class="invalid-feedback" role="alert"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3 mt-3">
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
            // Sync bg_color
            $('#bg_color_picker').on('input', function() {
                $('#bg_color_text').val($(this).val());
            });
            $('#bg_color_text').on('input', function() {
                var val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#bg_color_picker').val(val);
                }
            });

            // Sync color
            $('#color_picker').on('input', function() {
                $('#color_text').val($(this).val());
            });
            $('#color_text').on('input', function() {
                var val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#color_picker').val(val);
                }
            });
        });
    </script>

@stop
