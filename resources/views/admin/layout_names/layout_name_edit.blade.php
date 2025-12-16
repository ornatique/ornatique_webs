@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Inside App Layout</h4>
                    <div class="row">
                        <form action="{{ url('admin/layout-names/edit/' . $data->id) }}" method="post">@csrf

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
                                        value="{{ old('border_color', $data->border_color ?? '#000000') }}">
                                    <input type="text" id="border_color_text" name="border_color"
                                        class="form-control mt-2"
                                        value="{{ old('border_color', $data->border_color ?? '#000000') }}">
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
                                        <option value="" disabled>Select Shape</option>
                                        @foreach (['circle', 'rectangle', 'circle_with_border', 'rectangle_with_border'] as $shape)
                                            <option value="{{ $shape }}"
                                                {{ old('shape', $data->shape) == $shape ? 'selected' : '' }}>
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
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>
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
                                        <option value="" disabled>Select Subcategory</option>
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id', $data->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
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
                                        <option value="" disabled>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id', $data->product_id) == $product->id ? 'selected' : '' }}>
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
                                        value="{{ old('bg_color', $data->bg_color ?? '#ffffff') }}">
                                    <input type="text" id="bg_color_text" name="bg_color" class="form-control mt-2"
                                        value="{{ old('bg_color', $data->bg_color ?? '#ffffff') }}">
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
                                        value="{{ old('color', $data->color ?? '#000000') }}">
                                    <input type="text" id="color_text" name="color" class="form-control mt-2"
                                        value="{{ old('color', $data->color ?? '#000000') }}">
                                    @error('color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12 mt-3">
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
            // Sync color pickers
            function syncColor(pickerId, textId) {
                $(pickerId).on('input', function() {
                    $(textId).val($(this).val());
                });
                $(textId).on('input', function() {
                    let val = $(this).val();
                    if (/^#[0-9A-Fa-f]{6}$/.test(val)) $(pickerId).val(val);
                });
            }
            syncColor('#border_color_picker', '#border_color_text');
            syncColor('#bg_color_picker', '#bg_color_text');
            syncColor('#color_picker', '#color_text');

            // Disable subcategory & product initially
            const subcatSelect = $('select[name="subcategory_id"]');
            const productSelect = $('select[name="product_id"]');
            subcatSelect.prop('disabled', true);
            productSelect.prop('disabled', true);

            // Load subcategories dynamically
            $('select[name="category_id"]').on('change', function() {
                let categoryID = $(this).val();
                if (categoryID) {
                    $.getJSON('{{ url('admin/get-subcategories') }}/' + categoryID, function(data) {
                        subcatSelect.empty().append(
                            '<option value="" disabled selected>Select Subcategory</option>');
                        productSelect.empty().append(
                            '<option value="" disabled selected>Select Product</option>');
                        $.each(data, function(key, val) {
                            subcatSelect.append('<option value="' + val.id + '">' + val
                                .name + '</option>');
                        });
                        subcatSelect.prop('disabled', false);
                        productSelect.prop('disabled', true);
                    });
                } else {
                    subcatSelect.empty().append(
                        '<option value="" disabled selected>Select Subcategory</option>').prop(
                        'disabled', true);
                    productSelect.empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

            // Load products dynamically
            subcatSelect.on('change', function() {
                let subcatID = $(this).val();
                if (subcatID) {
                    $.getJSON('{{ url('admin/get-products') }}/' + subcatID, function(data) {
                        productSelect.empty().append(
                            '<option value="" disabled selected>Select Product</option>');
                        $.each(data, function(key, val) {
                            productSelect.append('<option value="' + val.id + '">' + val
                                .name + '</option>');
                        });
                        productSelect.prop('disabled', false);
                    });
                } else {
                    productSelect.empty().append(
                        '<option value="" disabled selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

            // Preload subcategory & product if already selected
            let selectedCategory = '{{ $data->category_id }}';
            let selectedSubcategory = '{{ $data->subcategory_id }}';
            let selectedProduct = '{{ $data->product_id }}';

            if (selectedCategory) {
                $.getJSON('{{ url('admin/get-subcategories') }}/' + selectedCategory, function(data) {
                    subcatSelect.empty().append('<option value="" disabled>Select Subcategory</option>');
                    $.each(data, function(key, val) {
                        let selected = val.id == selectedSubcategory ? 'selected' : '';
                        subcatSelect.append('<option value="' + val.id + '" ' + selected + '>' + val
                            .name + '</option>');
                    });
                    subcatSelect.prop('disabled', false);
                });
            }

            if (selectedSubcategory) {
                $.getJSON('{{ url('admin/get-products') }}/' + selectedSubcategory, function(data) {
                    productSelect.empty().append('<option value="" disabled>Select Product</option>');
                    $.each(data, function(key, val) {
                        let selected = val.id == selectedProduct ? 'selected' : '';
                        productSelect.append('<option value="' + val.id + '" ' + selected + '>' +
                            val.name + '</option>');
                    });
                    productSelect.prop('disabled', false);
                });
            }
        });
    </script>
@stop
