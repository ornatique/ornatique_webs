@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Custom Notification Add</h4>
                    <form action="{{ url('admin/custom/add') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Title <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('title') is-invalid @enderror" type=" text"
                                        name="title" value="{{ old('title') }}" placeholder="Enter title*"
                                        id="example-text-input">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Description <span
                                            class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('description') is-invalid @enderror"
                                        type=" text" name="description" value="{{ old('description') }}"
                                        placeholder="Enter description*" id="example-text-input">
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>






                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                            *</span></label>
                                    <img src="" alt="" id="preview-file" height="200px" class="mb-3">
                                    <input required type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" accept="image/*">

                                    <span class="text-danger">(Note : Max Size -
                                        2MB)</span>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category_id" id="category_id">
                                        <option value="" hidden selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Sub Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="sub_category" id="sub_category" disabled>
                                        <option value="" hidden selected>Select Sub Category</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <select class="form-select" name="product_id" id="product_id" disabled>
                                        <option value="" hidden selected>Select Product</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select" name="state" id="state_id">
                                        <option value="" hidden selected>Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <select class="form-select" name="city" id="city_id" disabled>
                                        <option value="" hidden selected>Select City</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Users <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="users[]" id="user_id"
                                        multiple="multiple" disabled>
                                        <option value="" hidden selected>Select Users</option>
                                    </select>
                                </div>
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
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

            $('#userMobileId').multiselect({
                columns: 1,
                placeholder: 'Select User',
                search: true,
                selectAll: true
            });


            // Category -> Subcategory -> Products AJAX
            $('#category_id').on('change', function() {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-subcategories') }}/' + categoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_category').empty().append(
                                '<option value="" hidden selected>Select Sub Category</option>'
                            );
                            $('#product_id').empty().append(
                                    '<option value="" hidden selected>Select Product</option>')
                                .prop('disabled', true);
                            $.each(data, function(key, value) {
                                $('#sub_category').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('#sub_category').prop('disabled', false);
                        }
                    });
                } else {
                    $('#sub_category').empty().append(
                        '<option value="" hidden selected>Select Sub Category</option>').prop(
                        'disabled', true);
                    $('#product_id').empty().append(
                        '<option value="" hidden selected>Select Product</option>').prop('disabled',
                        true);
                }
            });

            $('#sub_category').on('change', function() {
                var subCategoryID = $(this).val();
                if (subCategoryID) {
                    $.ajax({
                        url: '{{ url('admin/get-products') }}/' + subCategoryID,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#product_id').empty().append(
                                '<option value="" hidden selected>Select Product</option>');
                            $.each(data, function(key, value) {
                                $('#product_id').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                            $('#product_id').prop('disabled', false);
                        }
                    });
                } else {
                    $('#product_id').empty().append(
                        '<option value="" hidden selected>Select Product</option>').prop('disabled',
                        true);
                }
            });



        })
    </script>


    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Select Users',
                allowClear: true,
                width: '100%'
            });

            // State -> City
            $('#state_id').on('change', function() {
                var state = $(this).val();
                if (state) {
                    $.ajax({
                        url: '{{ url('admin/get-cities') }}/' + state,
                        type: 'GET',
                        dataType: 'json',
                        success: function(cities) {
                            $('#city_id').empty().append(
                                '<option value="" hidden selected>Select City</option>');
                            $('#user_id').empty().trigger('change').prop('disabled', true);
                            $.each(cities, function(key, city) {
                                $('#city_id').append('<option value="' + city + '">' +
                                    city + '</option>');
                            });
                            $('#city_id').prop('disabled', false);
                        }
                    });
                } else {
                    $('#city_id').empty().append('<option value="" hidden selected>Select City</option>')
                        .prop('disabled', true);
                    $('#user_id').empty().append('<option value="" hidden selected>Select Users</option>')
                        .prop('disabled', true).trigger('change');
                }
            });

            // City -> Users
            $('#city_id').on('change', function() {
                var state = $('#state_id').val();
                var city = $(this).val();
                if (state && city) {
                    $.ajax({
                        url: '{{ url('admin/get-users') }}/' + state + '/' + city,
                        type: 'GET',
                        dataType: 'json',
                        success: function(users) {
                            $('#user_id').empty();
                            $.each(users, function(key, user) {
                                $('#user_id').append('<option value="' + user.id +
                                    '">' + user.name + ' (' + user.email +
                                    ')</option>');
                            });
                            $('#user_id').prop('disabled', false).trigger('change');
                        }
                    });
                } else {
                    $('#user_id').empty().append('<option value="" hidden selected>Select Users</option>')
                        .prop('disabled', true).trigger('change');
                }
            });
        });
    </script>


@stop
