@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">
                    <!-- @if ($_GET['type'] == 'admin')
                        {{-- Admin menu --}}
                      Add Admin User
                    @else
                        {{-- Customer menu --}}
                      Add Customer 
                    @endif -->
                
                 Add Customer </h4>
                    <div class="row">
                        <form action="{{ url('admin/user/add') }}" class="row" method="post" enctype="multipart/form-data"
                            id="userForm">
                            @csrf

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ old('name') }}" placeholder="Enter name*"
                                        id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input required class="form-control @error('email') is-invalid @enderror" type="email"
                                        value="{{ old('email') }}" name="email" placeholder="Enter Email*"
                                        id="example-text-input">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col"></div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Number <span
                                            class="text-danger">*</span></label>
                                    <input required class="form-control @error('number') is-invalid @enderror"
                                        type="number" name="number" value="{{ old('number') }}"
                                        placeholder="Enter Number*" id="example-text-input">
                                    @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input required class="form-control @error('password') is-invalid @enderror"
                                        type="password" name="password" value="{{ old('password') }}"
                                        placeholder="Enter Password*" id="example-text-input">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col"></div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Image <span
                                            class="text-danger">*</span></label>
                                    <img src="" alt="" id="preview-file" height="200px" class="mb-3">
                                    <input required type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" value="{{ old('image') }}" accept="image/*">
                                    <span class="text-danger">(Note : Max Size - 2MB)</span>
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input required
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}" placeholder="Enter Confirm Password*"
                                        id="example-text-input">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div></div>
                            <!-- State Dropdown -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State <span
                                            class="text-danger">*</span></label>
                                    <select required name="state" id="state"
                                        class="form-control @error('state') is-invalid @enderror">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state }}"
                                                {{ old('state') == $state ? 'selected' : '' }}>
                                                {{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- City Dropdown (will be populated via AJAX) -->
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City <span
                                            class="text-danger">*</span></label>
                                    <select required name="city" id="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        {{ empty(old('state')) ? 'disabled' : '' }}>
                                        <option value="">Select City</option>
                                        @if (old('city') && old('state'))
                                            <option value="{{ old('city') }}" selected>{{ old('city') }}</option>
                                        @endif
                                    </select>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div id="city-loading" class="spinner-border spinner-border-sm d-none"
                                        role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                            <div></div>
                            {{-- Categories (Multiple) --}}
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Categories <span class="text-danger">*</span>
                                    </label>

                                    <select name="categories[]" class="form-control select2" multiple required
                                        id="categories">
                                        <option value="all">Select All</option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>


                                    @error('categories')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            @if ($isAdminRoute)
                                <div class="col-lg-4">
                                    <div class="form-check mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox" name="admin" id="admin"
                                            value="1" {{ old('admin') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="admin">
                                            Is Admin?
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#categories').select2({
                placeholder: 'Select Categories',
                closeOnSelect: false,
                width: '100%'
            });

            // Handle Select All
            $('#categories').on('change', function() {
                let selected = $(this).val();

                if (selected && selected.includes('all')) {
                    // select all except "all"
                    let allValues = [];

                    $('#categories option').each(function() {
                        if ($(this).val() !== 'all') {
                            allValues.push($(this).val());
                        }
                    });

                    $('#categories').val(allValues).trigger('change.select2');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Image preview
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

            // State change event
            $('#state').change(function() {
                const state = $(this).val();
                const citySelect = $('#city');
                const loadingSpinner = $('#city-loading');

                if (state) {
                    citySelect.prop('disabled', true);
                    loadingSpinner.removeClass('d-none');
                    citySelect.html('<option value="">Loading cities...</option>');

                    $.ajax({
                        url: '{{ route('get.cities') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            state: state
                        },
                        success: function(response) {
                            citySelect.html('<option value="">Select City</option>');
                            if (response.length > 0) {
                                response.forEach(function(city) {
                                    citySelect.append($('<option>', {
                                        value: city,
                                        text: city
                                    }));
                                });
                            } else {
                                citySelect.html('<option value="">No cities found</option>');
                            }
                            citySelect.prop('disabled', false);
                        },
                        error: function() {
                            citySelect.html('<option value="">Failed to load cities</option>');
                            citySelect.prop('disabled', false);
                        },
                        complete: function() {
                            loadingSpinner.addClass('d-none');
                        }
                    });
                } else {
                    citySelect.html('<option value="">Select State first</option>');
                    citySelect.prop('disabled', true);
                }
            });

            // Preselect city if there's old input
            @if (old('state') && old('city'))
                $('#state').trigger('change');
                // Set timeout to ensure cities are loaded before selecting
                setTimeout(function() {
                    $('#city').val('{{ old('city') }}');
                }, 500);
            @endif
        });
    </script>
@stop
