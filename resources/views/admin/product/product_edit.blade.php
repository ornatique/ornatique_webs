@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Product Edit</h4>
                    <div class="row">
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <form action="{{ url('admin/product/edit') . '/' . $data['id'] }}" class="row" method="post"
                            enctype="multipart/form-data">@csrf
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
                            {{-- <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Category <span class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="category" id="category">
                                        <option value="" hidden selected>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option {{ $category->id == $data['category_id'] ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ ucwords($category->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <input type="hidden" name="category" value="{{ $data->category_id }}" id="category">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Sub Category <span
                                            class="text-danger">
                                            *</span></label>
                                    <select class="form-select" name="sub_category" id="sub_category">
                                        <option value="" hidden selected>Select Sub Category</option>
                                        @foreach ($sub_categories as $sub)
                                            <option data-id="{{ $sub->category_id }}" value="{{ $sub->id }}"
                                                {{ $sub->id == $data['subcategory_id'] ? 'selected' : '' }}>
                                                {{ ucwords($sub->name) }}
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

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Size <span class="text-danger">
                                            *</span></label>
                                    <input class="form-control @error('size') is-invalid @enderror" type=" text"
                                        name="size" value="{{ $data['size'] }}" placeholder="Enter Size*"
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
                                    <label for="example-text-input" class="form-label">Hole Size <span class="text-danger">
                                            *</span></label>
                                    <input class="form-control @error('holesize') is-invalid @enderror" type=" text"
                                        name="hole_size" value="{{ $data['hole_size'] }}" placeholder="Enter Size*"
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
                                    <label for="gross_weight" class="form-label">Gross Weight <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('gross_weight') is-invalid @enderror" type="text"
                                        name="gross_weight" value="{{ $data['gross_weight'] ?? '' }}"
                                        placeholder="Enter Gross Weight" id="gross_weight">
                                    @error('gross_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="less_weight" class="form-label">Less Weight <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('less_weight') is-invalid @enderror" type="text"
                                        name="less_weight" value="{{ $data['less_weight'] ?? '' }}"
                                        placeholder="Enter Less Weight" id="less_weight">
                                    @error('less_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="weight" class="form-label">Net Weight <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('weight') is-invalid @enderror" type="text"
                                        name="weight" value="{{ $data['weight'] ?? '' }}" placeholder="Net Weight"
                                        id="net_weight" readonly>
                                    @error('weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3 col-lg-5" for="gallery">Gallery:</label>
                                <div class="gallery" style="overflow: hidden!important;">
                                    <div id="gallery_view">
                                        @isset($data['gallery'])
                                            @if ($data['gallery'])
                                                <?php $images = json_decode($data['gallery']); ?>
                                                @foreach ($images as $i => $image)
                                                    <div class="col-sm-3 media-thumb-wrap d-inline-block">
                                                        <figure class="media-thumb">
                                                            <img src="{{ asset('public/assets/images/product/' . $image) }}"
                                                                height="100px" width="100px">
                                                            <div class="media-item-actions  mt-1">
                                                                <a class="icon icon-delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="15"
                                                                        height="16" viewBox="0 0 15 16">
                                                                        <g fill="#5D5D5D" fill-rule="nonzero">
                                                                            <path
                                                                                d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z">
                                                                            </path>
                                                                            <path
                                                                                d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z">
                                                                            </path>
                                                                        </g>
                                                                    </svg>
                                                                </a>
                                                                <input type="hidden" name="gallery[]"
                                                                    value="{{ $image }}">
                                                                <span class="icon icon-loader d-none"><i
                                                                        class="fa fa-spinner fa-spin"></i></span>
                                                            </div>
                                                        </figure>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endisset
                                    </div>
                                    <input type="file" class="form-control" id="gallery" placeholder="Enter Name"
                                        accept="image/*" multiple>

                                    <span class="text-danger">(Note : Max Size - 2MB)</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="label_product" class="form-label">Label<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control @error('label_product') is-invalid @enderror"
                                        type="text" name="label_product" value="{{ $data->label_product }}"
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
                                    <label for="color" class="form-label">Color <span
                                            class="text-danger">*</span></label>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="colorPreview"
                                            style="width:30px;height:30px;background-color:{{ $data->color }};border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="colorText">{{ $data->color }}</span>
                                    </div>

                                    <!-- Native color picker -->
                                    <input required class="form-control mb-2 @error('color') is-invalid @enderror"
                                        type="color" name="color" value="{{ $data->color }}" id="colorPicker">

                                    <!-- Hex code input -->
                                    <input type="text" class="form-control @error('color') is-invalid @enderror"
                                        id="colorInput" placeholder="#000000" value="{{ $data->color }}">

                                    @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="charge" class="form-label">Other Charges</label>
                                    <input class="form-control @error('charge') is-invalid @enderror" type="text"
                                        name="charge" value="{{ $data->charge }}" placeholder="Enter Other Charges"
                                        id="charge">
                                    @error('charge')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <h3>Background Color</h3>


                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="bg_color" class="form-label">Background Color <span
                                            class="text-danger">*</span></label>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <div id="bgColorPreview"
                                            style="width:30px;height:30px;background-color:{{ $data->bg_color }};border:1px solid #ddd;border-radius:4px;">
                                        </div>
                                        <span id="bgColorText">{{ $data->bg_color }}</span>
                                    </div>

                                    <!-- Native color picker -->
                                    <input required class="form-control mb-2 @error('bg_color') is-invalid @enderror"
                                        type="color" name="bg_color" value="{{ $data->bg_color }}"
                                        id="bgColorPicker">

                                    <!-- Hex code input -->
                                    <input type="text" class="form-control @error('bg_color') is-invalid @enderror"
                                        id="bgColorInput" placeholder="#000000" value="{{ $data->bg_color }}">

                                    @error('bg_color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
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
            // Helper: validate hex color
            function isHex(val) {
                return /^#([0-9A-F]{3}){1,2}$/i.test(val);
            }

            // Generic sync function
            function syncColor(picker, input, preview, text) {
                function update(val) {
                    if (isHex(val)) {
                        $(picker).val(val);
                        $(input).val(val.toUpperCase());
                        $(preview).css('background-color', val);
                        $(text).text(val.toUpperCase());
                    }
                }
                $(picker).on('input', function() {
                    update($(this).val());
                });
                $(input).on('input paste', function() {
                    update($(this).val());
                });
                update($(picker).val()); // initialize
            }

            // 🔹 Product color sync
            syncColor('#colorPicker', '#colorInput', '#colorPreview', '#colorText');

            // 🔹 Background color sync
            syncColor('#bgColorPicker', '#bgColorInput', '#bgColorPreview', '#bgColorText');
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
            // $('#category').change(function() {
            //     var id = $(this).val();
            //     $.ajax({
            //         method: 'post',
            //         url: "{{ url('admin/get-subcategory') }}",
            //         data: {
            //             '_token': '{{ csrf_token() }}',
            //             id: id,
            //         },
            //         success: function(data) {
            //             $('#sub_category').html(data);
            //         }
            //     })
            // })

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
                                            <!-- delete SVG here -->
                                        </a>
                                        <input type="hidden" name="gallery[]" value="${res.file_name}">
                                        <span class="icon icon-loader d-none"><i class="fa fa-spinner fa-spin"></i></span>
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

        // Delete image from view (same as earlier)
        $(document).on("click", ".icon-delete", function(event) {
            event.preventDefault();
            $(this).closest('.media-thumb-wrap').remove();
        });
    </script>
@stop
