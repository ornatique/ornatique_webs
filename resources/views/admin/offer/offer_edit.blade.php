@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Offer Edit</h4>
                    <form action="{{ url('admin/offer/edit') . '/' . $data->id }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ old('name', ucfirst($data->name)) }}"
                                        placeholder="Enter name*" id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="colorPicker" class="form-label">Color <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width: 30px; height: 30px; background-color: {{ old('color', $data->color) }}; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <span id="colorText">{{ old('color', $data->color) }}</span>
                                    </div>

                                    <!-- native color picker -->
                                    <input required class="form-control mb-2 @error('color') is-invalid @enderror"
                                        type="color" name="color" value="{{ old('color', $data->color) }}"
                                        id="colorPicker">

                                    <!-- extra text input for hex code -->
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="colorInput" placeholder="#000000" value="{{ old('color', $data->color) }}">

                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="mb-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                    <a href="{{ url('admin/offer/list') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function syncColor(picker, input, preview, text) {
                function update(val) {
                    if (/^#([0-9A-F]{3}){1,2}$/i.test(val)) {
                        $(picker).val(val);
                        $(input).val(val.toUpperCase());
                        $(preview).css("background-color", val);
                        $(text).text(val.toUpperCase());
                    }
                }
                $(picker).on("input", function() {
                    update($(this).val());
                });
                $(input).on("input paste", function() {
                    update($(this).val());
                });
            }

            syncColor("#colorPicker", "#colorInput", "#colorPreview", "#colorText");
        });
    </script>


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
        })
    </script>
@stop
