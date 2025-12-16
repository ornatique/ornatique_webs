@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Edit Essential</h4>
                    <div class="row">

                        <form action="{{ url('admin/essential/edit/' . $data->id) }}" method="post">
                            @csrf

                            {{-- Category --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-select @error('category') is-invalid @enderror" name="category">
                                        <option value="">Please select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $data->category_id == $category->id ? 'selected' : '' }}>
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
                                        name="sub_category">
                                        <option value="">Please select Subcategory</option>
                                        @foreach ($sub_categories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ $data->subcategory_id == $subcategory->id ? 'selected' : '' }}>
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
                                    <select class="form-select @error('product') is-invalid @enderror" name="product">
                                        <option value="">Please select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $data->product_id == $product->id ? 'selected' : '' }}>
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

                            {{-- Background Color --}}
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="bg_color">Background Color</label>
                                    <div class="input-group">
                                        <input type="color" id="bg_color_picker" class="form-control"
                                            value="{{ old('bg_color', $data->bg_color ?? '#ffffff') }}">
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        <input type="text" id="bg_color_text" name="bg_color" class="form-control"
                                            value="{{ old('bg_color', $data->bg_color ?? '#ffffff') }}">
                                    </div>
                                    @error('bg_color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Color --}}
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <div class="input-group">
                                        <input type="color" id="color_picker" class="form-control"
                                            value="{{ old('color', $data->color ?? '#000000') }}">
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        &nbsp;
                                        <input type="text" id="color_text" name="color" class="form-control"
                                            value="{{ old('color', $data->color ?? '#000000') }}">
                                    </div>
                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Buttons --}}
                            <div class="mb-3 mt-4">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <a href="{{ route('admin_essential_list') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery AJAX and color sync --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            // Sync bg_color picker & text
            $('#bg_color_picker').on('input', function() {
                $('#bg_color_text').val($(this).val());
            });
            $('#bg_color_text').on('input', function() {
                var val = $(this).val();
                if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                    $('#bg_color_picker').val(val);
                }
            });

            // Sync color picker & text
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
