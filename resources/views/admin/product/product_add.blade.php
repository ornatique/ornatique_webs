@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Product Add</h4>
                    <div class="row">
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <form action="{{ url('admin/product/add') }}" class="row" method="post"
                            enctype="multipart/form-data" novalidate>@csrf
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Name <span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('name') is-invalid @enderror" type=" text"
                                        name="name" value="{{ old('name') }}" placeholder="Enter name*"
                                        id="example-text-input">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Category <span class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="category" id="category">
                                        <option value="" hidden selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <input type="hidden" name="category" value="" id="category">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Sub Category <span
                                            class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="sub_category" id="sub_category">
                                        <option value="" hidden selected>Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option data-id="{{ $sub->category_id }}" value="{{ $sub->id }}">
                                                {{ ucwords($sub->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Size <span class="text-danger">
                                            *</span></label>
                                    <input class="form-control @error('size') is-invalid @enderror" type=" text"
                                        name="size" value="{{ old('size') }}" placeholder="Enter Size*"
                                        id="example-text-input">
                                    @error('size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Hole Size</label>
                                    <input class="form-control @error('holesize') is-invalid @enderror" type="text"
                                        name="hole_size" value="{{ old('hole_size') }}" placeholder="Enter Size*"
                                        id="example-text-input">
                                    @error('hole_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Gross Weight<span
                                            class="text-danger">
                                            *</span></label>
                                    <input id="gross_weight"
                                        class="form-control @error('gross_weight') is-invalid @enderror" type="text"
                                        name="gross_weight" value="{{ old('gross_weight') }}"
                                        placeholder="Enter Gross Weight">

                                    @error('gross_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Less Weight<span class="text-danger">
                                            *</span></label>
                                    <input id="less_weight" class="form-control @error('less_weight') is-invalid @enderror"
                                        type="text" name="less_weight" value="{{ old('less_weight') }}"
                                        placeholder="Enter Less Weight">

                                    @error('less_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Net Weight<span
                                            class="text-danger">
                                            *</span></label>
                                    <input id="net_weight" class="form-control @error('weight') is-invalid @enderror"
                                        type="text" name="weight" value="{{ old('weight') }}"
                                        placeholder="Enter Net Weight" readonly>

                                    @error('weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12 mb-3">
                                <label class="control-label col-sm-2 col-md-3 col-lg-5" for="gallery">Gallery:</label>
                                <div class="gallery" style="overflow: hidden!important;">
                                    <div id="gallery_view"></div>
                                    <input required type="file" class="form-control" id="gallery"
                                        placeholder="Enter Name" accept="image/*" multiple>

                                    <span class="text-danger">(Note : Max Size - 2MB)</span>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="label_product" class="form-label">Label<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('label_product') is-invalid @enderror"
                                        type="text" name="label_product" value="{{ old('label_product') }}"
                                        placeholder="Enter Label*" id="label_product">
                                    @error('label_product')
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
                                            style="width: 30px; height: 30px; background-color: {{ old('color', '#000000') }}; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <span id="colorText">{{ old('color', '#000000') }}</span>
                                    </div>
                                    <input required class="form-control mb-2 @error('color') is-invalid @enderror"
                                        type="color" name="color" value="{{ old('color', '#000000') }}"
                                        id="colorPicker">
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="colorInput" name="color_text" placeholder="#000000"
                                        value="{{ old('color', '#000000') }}">
                                    @error('color')
                                        <span class="invalid-feedback"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Other Charges</label>
                                    <input class="form-control @error('charge') is-invalid @enderror" type=" text"
                                        name="charge" value="{{ old('charge') }}" placeholder="Enter Other Charges"
                                        id="example-text-input">
                                    @error('charge')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <hr>
                            <h3>Back Ground Color</h3>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="bgColorPicker" class="form-label">Background Color <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="bgColorPreview"
                                            style="width: 30px; height: 30px; background-color: {{ old('bg_color', '#ffffff') }}; border: 1px solid #ddd; border-radius: 4px;">
                                        </div>
                                        <span id="bgColorText">{{ old('bg_color', '#ffffff') }}</span>
                                    </div>
                                    <input required class="form-control mb-2 @error('bg_color') is-invalid @enderror"
                                        type="color" name="bg_color" value="{{ old('bg_color', '#ffffff') }}"
                                        id="bgColorPicker">
                                    <input type="text" class="form-control @error('bg_color') is-invalid @enderror"
                                        id="bgColorInput" name="bg_color_text" placeholder="#ffffff"
                                        value="{{ old('bg_color', '#ffffff') }}">
                                    @error('bg_color')
                                        <span class="invalid-feedback"><strong
                                                class="text-danger">{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
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
            syncColor("#bgColorPicker", "#bgColorInput", "#bgColorPreview", "#bgColorText");
        });
    </script>

    <script>
        function calculateNetWeight() {
            const gross = parseFloat(document.getElementById('gross_weight').value) || 0;
            const less = parseFloat(document.getElementById('less_weight').value) || 0;
            const net = gross - less;
            const formattedNet = net > 0 ? net.toFixed(3) : '0.000';
            document.getElementById('net_weight').value = formattedNet;
        }

        document.getElementById('gross_weight').addEventListener('input', calculateNetWeight);
        document.getElementById('less_weight').addEventListener('input', calculateNetWeight);
    </script>


    <script>
        $(document).ready(function() {

            $('#sub_category').change(function() {
                $('#category').val($(this).find(':selected').data('id'));
            })



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
        })

        $('#gallery').change(function() {
            let files = this.files;

            for (let i = 0; i < files.length; i++) {
                let form_data = new FormData();
                form_data.append('image', files[i]);
                form_data.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ url('admin/upload-image') }}",
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.fail) {
                            alert(res.errors['image']);
                        } else {
                            if (res.code === 200) {
                                let html = `
                            <div class="col-sm-3 media-thumb-wrap d-inline-block">
                                <figure class="media-thumb">
                                    <img src="{{ asset('public/assets/images/product/${res.file_name}') }}" height="100px" width="100px">
                                    <div class="media-item-actions mt-1">
                                        <a class="icon icon-delete" data-filename="${res.file_name}" href="#">
                                            <!-- delete SVG -->
                                        </a>
                                        <input type="hidden" name="gallery[]" value="${res.file_name}">
                                        <span class="icon icon-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                    </div>
                                </figure>
                            </div>
                        `;
                                $('#gallery_view').append(html);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred! Please try again!');
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        // Delete image from view
        $(document).on("click", ".icon-delete", function(event) {
            event.preventDefault();
            $(this).closest('.media-thumb-wrap').remove();
        });
    </script>
@stop
