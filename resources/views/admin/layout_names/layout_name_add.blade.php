@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Layout Name</h4>
                    <div class="row">
                        <form action="{{ url('admin/layout-names/add') }}" method="post">@csrf
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Name --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="layout_id">Select Layout <span class="text-danger">*</span></label>
                                    <select name="layout_id" class="form-select" required>
                                        <option value="" disabled selected>Select Layout</option>
                                        @foreach ($layouts as $layout)
                                            <option value="{{ $layout->id }}"
                                                {{ (old('layout_id') ?? ($data->layout_id ?? '')) == $layout->id ? 'selected' : '' }}>
                                                {{ ucfirst($layout->name) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('layout_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            {{-- Border Color --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="border_color">Border Color</label>
                                    <input type="color" id="border_color_picker" class="form-control"
                                        value="{{ old('border_color', '#000000') }}">
                                    <input type="text" id="border_color_text" name="border_color"
                                        class="form-control mt-2" value="{{ old('border_color', '#000000') }}">
                                    @error('border_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Shape --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="shape">Shape</label>
                                    <select name="shape" class="form-select">
                                        <option value="" selected disabled>Select Shape</option>
                                        @foreach (['circle', 'rectangle', 'circle_with_border', 'rectangle_with_border'] as $shape)
                                            <option value="{{ $shape }}"
                                                {{ old('shape') == $shape ? 'selected' : '' }}>
                                                {{ ucfirst($shape) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shape')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Subcategory --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subcategory_id">Subcategory</label>
                                    <select name="subcategory_id" class="form-select">
                                        <option value="" disabled selected>Select Subcategory</option>
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                {{ ucfirst($subcategory->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Product --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select name="product_id" class="form-select">
                                        <option value="" disabled selected>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ ucfirst($product->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Background Color --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bg_color">Background Color</label>
                                    <input type="color" id="bg_color_picker" class="form-control"
                                        value="{{ old('bg_color', '#ffffff') }}">
                                    <input type="text" id="bg_color_text" name="bg_color" class="form-control mt-2"
                                        value="{{ old('bg_color', '#ffffff') }}">
                                    @error('bg_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Color --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="color" id="color_picker" class="form-control"
                                        value="{{ old('color', '#000000') }}">
                                    <input type="text" id="color_text" name="color" class="form-control mt-2"
                                        value="{{ old('color', '#000000') }}">
                                    @error('color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12 mt-3">
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
            // Sync border color
            $('#border_color_picker').on('input', function() {
                $('#border_color_text').val($(this).val());
            });
            $('#border_color_text').on('input', function() {
                let val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#border_color_picker').val(val);
                }
            });

            // Sync bg_color
            $('#bg_color_picker').on('input', function() {
                $('#bg_color_text').val($(this).val());
            });
            $('#bg_color_text').on('input', function() {
                let val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#bg_color_picker').val(val);
                }
            });

            // Sync color
            $('#color_picker').on('input', function() {
                $('#color_text').val($(this).val());
            });
            $('#color_text').on('input', function() {
                let val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#color_picker').val(val);
                }
            });

            // Disable subcategory & product initially
            $('select[name="subcategory_id"]').prop('disabled', true);
            $('select[name="product_id"]').prop('disabled', true);

            // Load subcategories dynamically
            $('select[name="category_id"]').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.getJSON('{{ url('admin/get-subcategories') }}/' + categoryID, function(data) {
                        $('select[name="subcategory_id"]').empty().append(
                            '<option value="" disabled selected>Select Subcategory</option>');
                        $('select[name="product_id"]').empty().append(
                            '<option value="" disabled selected>Select Product</option>');
                        $.each(data, function(key, value) {
                            $('select[name="subcategory_id"]').append('<option value="' +
                                value.id + '">' + value.name + '</option>');
                        });
                        $('select[name="subcategory_id"]').prop('disabled', false);
                        $('select[name="product_id"]').prop('disabled', true);
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

            // Load products dynamically
            $('select[name="subcategory_id"]').on('change', function() {
                var subcategoryID = $(this).val();
                if (subcategoryID) {
                    $.getJSON('{{ url('admin/get-products') }}/' + subcategoryID, function(data) {
                        $('select[name="product_id"]').empty().append(
                            '<option value="" disabled selected>Select Product</option>');
                        $.each(data, function(key, value) {
                            $('select[name="product_id"]').append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('select[name="product_id"]').prop('disabled', false);
                    });
                } else {
                    $('select[name="product_id"]').empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });
        });
    </script>
@stop
