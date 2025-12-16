@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" action="{{ url('admin/store/edit/' . $data['id']) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2 overflow-hidden">
                            <h4 class="card-title float-start">Stores</h4>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4 py-3">
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                                    id="category_id">
                                    <option value="">Please select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $data->category_id == $category->id ? 'selected' : '' }}>
                                            {{ ucwords($category->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Subcategory --}}
                        <div class="col-md-4 py-3">
                            <div class="form-group">
                                <label for="subcategory_id">Subcategory <span class="text-danger">*</span></label>
                                <select class="form-select @error('subcategory_id') is-invalid @enderror"
                                    name="subcategory_id" id="subcategory_id">
                                    <option value="">Please select subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            {{ $data->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                            {{ ucwords($subcategory->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Product --}}
                        <div class="col-md-4 py-3">
                            <div class="form-group">
                                <label for="product_id">Product <span class="text-danger">*</span></label>
                                <select class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                    id="product_id">
                                    <option value="">Please select product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $data->product_id == $product->id ? 'selected' : '' }}>
                                            {{ ucwords($product->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="text-danger">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="col-lg-12">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Image <span class="text-danger">*</span></label>
                                    <img src="{{ asset('public/assets/images/store/' . $data->image) }}" id="preview-file"
                                        alt="" height="200px" class="mb-3">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="file">
                                    <span class="text-danger">(Note : Max Size - 2MB)</span>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary w-md">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // Disable subcategory & product if category not selected
            if (!$('#category_id').val()) {
                $('#subcategory_id').prop('disabled', true);
                $('#product_id').prop('disabled', true);
            }

            // Load subcategories on category change
            $('#category_id').on('change', function() {
                let categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-subcategories') }}/' + categoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#subcategory_id').empty().append(
                                '<option value="">Please select subcategory</option>');
                            $('#product_id').empty().append(
                                '<option value="">Please select product</option>');
                            $.each(data, function(key, value) {
                                $('#subcategory_id').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                            $('#subcategory_id').prop('disabled', false);
                            $('#product_id').prop('disabled', true);
                        }
                    });
                } else {
                    $('#subcategory_id').empty().append(
                        '<option value="">Please select subcategory</option>').prop('disabled', true);
                    $('#product_id').empty().append('<option value="">Please select product</option>').prop(
                        'disabled', true);
                }
            });

            // Load products on subcategory change
            $('#subcategory_id').on('change', function() {
                let subcategoryID = $(this).val();
                if (subcategoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-products') }}/' + subcategoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#product_id').empty().append(
                                '<option value="">Please select product</option>');
                            $.each(data, function(key, value) {
                                $('#product_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('#product_id').prop('disabled', false);
                        }
                    });
                } else {
                    $('#product_id').empty().append('<option value="">Please select product</option>').prop(
                        'disabled', true);
                }
            });

            // Image preview
            $('#file').change(function() {
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
