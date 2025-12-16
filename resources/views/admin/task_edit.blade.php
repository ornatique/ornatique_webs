@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Custom Notification Edit</h4>
                    <form action="{{ url('admin/custom/edit/' . $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Title -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Title <span class="text-danger">*</span></label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text"
                                        name="title" value="{{ old('title', $data->title) }}" placeholder="Enter title*">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Description <span class="text-danger">*</span></label>
                                    <input class="form-control @error('description') is-invalid @enderror" type="text"
                                        name="description" value="{{ old('description', $data->description) }}"
                                        placeholder="Enter description*">
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <img id="preview-file"
                                        src="{{ asset('public/assets/images/notification/' . $data->image) }}"
                                        alt="Notification Image" height="200px" class="mb-3">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" accept="image/*">
                                    <span class="text-danger">(Note : Max Size - 2MB)</span>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id">
                                        <option value="" hidden>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>
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

                            <!-- Subcategory -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="sub_category" class="form-label">Sub Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror"
                                        name="subcategory_id" id="sub_category">
                                        <option value="" hidden>Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option value="{{ $sub->id }}" data-id="{{ $sub->category_id }}"
                                                {{ old('subcategory_id', $data->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                                {{ ucwords($sub->name) }}
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

                            <!-- Product -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="product_id" class="form-label">Product <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                        id="product_id">
                                        <option value="" hidden>Select Product</option>
                                        @if (old('product_id', $data->product_id))
                                            <option value="{{ $data->product_id }}" selected>
                                                {{ optional($data->product)->name }}</option>
                                        @endif
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">State</label>
                                <select class="form-select" name="state" id="state_id">
                                    <option value="" hidden>Select State</option>
                                    @foreach ($states as $st)
                                        <option value="{{ $st }}" {{ $st == $state ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">City</label>
                                <select class="form-select" name="city" id="city_id" {{ !$city ? 'disabled' : '' }}>
                                    @if ($city)
                                        <option value="{{ $city }}" selected>{{ $city }}</option>
                                    @else
                                        <option hidden>Select City</option>
                                    @endif
                                </select>
                            </div>


                            <div class="col-lg-4">
                                <label class="form-label">Users</label>
                                <select class="form-select select2" name="users[]" id="user_id" multiple
                                    {{ empty($cityUsers) ? 'disabled' : '' }}>
                                    @foreach ($cityUsers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, $selectedUsers) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Update</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {


            $('.select2').select2({
                closeOnSelect: false
            });

            $('#state_id').on('change', function() {
                let state = $(this).val();
                if (!state) return;

                $.get('{{ url('admin/get-cities') }}/' + state, function(cities) {
                    $('#city_id').empty().append('<option hidden>Select City</option>');
                    $('#user_id').empty().prop('disabled', true).trigger('change');

                    $.each(cities, function(_, city) {
                        $('#city_id').append(`<option value="${city}">${city}</option>`);
                    });

                    $('#city_id').prop('disabled', false);
                });
            });

            $('#city_id').on('change', function() {
                let state = $('#state_id').val();
                let city = $(this).val();
                if (!state || !city) return;

                $.get('{{ url('admin/get-users') }}/' + state + '/' + city, function(users) {
                    $('#user_id').empty();
                    $.each(users, function(_, user) {
                        $('#user_id').append(
                            `<option value="${user.id}">${user.name} (${user.email})</option>`
                        );
                    });
                    $('#user_id').prop('disabled', false).trigger('change');
                });
            });



            // Image preview
            $('#image').change(function() {
                previewUploadImage(this, 'preview-file');
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

            // Disable product initially
            $('#product_id').prop('disabled', true);

            // Function to load products
            function loadProducts(subcategoryId, selectedProductId = null) {
                if (!subcategoryId) {
                    $('#product_id').empty().append('<option value="" hidden>Select Product</option>').prop(
                        'disabled', true);
                    return;
                }
                $.ajax({
                    url: '{{ url('admin/get-products') }}/' + subcategoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#product_id').empty().append(
                            '<option value="" hidden>Select Product</option>');
                        $.each(data, function(key, value) {
                            var selected = (value.id == selectedProductId) ? 'selected' : '';
                            $('#product_id').append('<option value="' + value.id + '" ' +
                                selected + '>' + value.name + '</option>');
                        });
                        $('#product_id').prop('disabled', false);
                    }
                });
            }

            // Load subcategories when category changes
            $('#category_id').on('change', function() {
                var categoryID = $(this).val();
                $('#sub_category').empty().append(
                    '<option value="" hidden selected>Select Sub Category</option>');
                $('#product_id').empty().append('<option value="" hidden selected>Select Product</option>')
                    .prop('disabled', true);

                if (!categoryID) return;

                $.ajax({
                    url: '{{ url('admin/get-subcategories') }}/' + categoryID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                        $('#sub_category').prop('disabled', false);

                        // If editing, select old subcategory and load products
                        var oldSubCategory =
                            "{{ old('subcategory_id', $data->subcategory_id) }}";
                        if (oldSubCategory) {
                            $('#sub_category').val(oldSubCategory);
                            loadProducts(oldSubCategory,
                                "{{ old('product_id', $data->product_id) }}");
                        }
                    }
                });
            });

            // Trigger change on page load to load subcategories & products for edit
            var initialCategory = $('#category_id').val();
            if (initialCategory) {
                $('#category_id').trigger('change');
            }

            // When subcategory changes manually
            $('#sub_category').on('change', function() {
                var subcategoryId = $(this).val();
                loadProducts(subcategoryId);
            });
        });
    </script>
@stop
