@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Category Edit</h4>
                    <form action="{{ url('admin/category/edit') . '/' . $data['id'] }}" method="post"
                        enctype="multipart/form-data">@csrf

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type=" text"
                                        name="name" value="{{ $data['name'] }}" placeholder="Enter name*"
                                        id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 mt-10">
                                <div class="form-group">
                                    <label for="formrow-email-input">User</label><span class="text-danger">*</span>
                                    <select class="form-control " id="userMobileId" name="user_id[]" multiple="multiple"
                                        data-placeholder="Please select User" data-id="{{ $data->user_id }}">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->number }}">
                                                {{ ucfirst($user->number) }}
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="formrow-email-input">Priority<span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="priority"
                                        placeholder="Enter Priority (Ex: 1)" value="{{ $data->priority }}">
                                    @error('priority')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                            *</span></label>
                                    <img src="{{ asset('public/assets/images/categories') . '/' . $data['image'] }}"
                                        alt="" id="preview-file" height="200px" class="mb-3">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name=" image" id="image">
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
                                    <label for="color" class="form-label">Color <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width: 30px; height: 30px; background-color: {{ old('color', $data->color) }}; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <span id="colorText">{{ old('color', $data->color) }}</span>
                                    </div>

                                    <!-- Native color picker -->
                                    <input required class="form-control mb-2 @error('color') is-invalid @enderror"
                                        type="color" name="color" value="{{ old('color', $data->color) }}"
                                        id="colorPicker">

                                    <!-- Extra text input for pasting hex code -->
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="colorInput" placeholder="#000000" value="{{ old('color', $data->color) }}">

                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Shape <span class="text-danger">*</span></label>
                                    <select name="shape" class="form-select">
                                        @foreach (['circle', 'rectangle', 'circle_with_border', 'rectangle_with_border'] as $shape)
                                            <option value="{{ $shape }}"
                                                {{ old('shape', $data->shape) == $shape ? 'selected' : '' }}>
                                                {{ ucfirst($shape) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="home" id="home"
                                    value="1" {{ isset($data->home) && $data->home == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="home">
                                    Display on Mobile Home Screen?
                                </label>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="mb-3">
                                <button class="btn btn-primary" type="submit">Updated</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function updateColor(val) {
                if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) { // validate hex
                    $('#colorPicker').val(val);
                    $('#colorInput').val(val);
                    $('#colorPreview').css('background-color', val);
                    $('#colorText').text(val);
                }
            }

            $('#colorPicker').on('input', function() {
                updateColor($(this).val());
            });

            $('#colorInput').on('input paste', function() {
                updateColor($(this).val());
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: false,
            });
            var user_id = $('#userMobileId').attr('data-id');
            if (user_id) {
                $('#userMobileId').val(JSON.parse(user_id)).trigger('change');
            }
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
        })
    </script>
@stop
