@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" action="{{ route('admin_banners_edit') }}" method="post"
                        enctype="multipart/form-data">
                        <div class="mb-2 overflow-hidden">
                            <h4 class="card-title float-start">Banners</h4>
                            <!--<a href="#" class="float-end ms-2">-->
                            <!--    <button type="submit" class="btn btn-primary w-md">Submit</button>-->
                            <!--</a>-->
                            <!--<a href="{{ url()->previous() }}" class="float-end">-->
                            <!--    <button type="submit" class="btn btn-danger w-md">Cancel</button>-->
                            <!--</a>-->
                        </div>
                        @csrf
                        <div class="row">



                            {{-- <div class="col-md-12">
                                <label class="control-label col-sm-2 col-md-3 col-lg-5" for="gallery">Advertise
                                    Gallery:</label>
                                <div class="gallery" style="overflow: hidden!important;">
                                    <div id="gallery_view">
                                        <div id="place_gallery_thumbs1"></div>
                                        @isset($data['gallery_adv'])
                                            <?php $images = json_decode($data['gallery_adv']); ?>
                                            @foreach ($images as $i => $image)
                                                <div class="col-sm-1 media-thumb-wrap d-inline-block">
                                                    <figure class="media-thumb">
                                                        <img src="{{ asset('public/assets/images/banners/' . $image) }}"
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
                                                            <input type="hidden" name="gallery_adv[]"
                                                                value="{{ $image }}">
                                                            <span class="icon icon-loader d-none"><i
                                                                    class="fa fa-spinner fa-spin"></i></span>
                                                        </div>
                                                    </figure>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                    <input type="file" class="form-control  " id="gallery" placeholder="Enter Name"
                                        accept="image/*">
                                    <span class="text-danger">(Note : Max Size - 3MB)</span>
                                </div>
                            </div> --}}


                            <div class="col-lg-12">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                                *</span></label>
                                        <img src="" alt="" id="preview-file" height="200px" class="mb-3">
                                        <input required type="file" value="{{ old('image') }}"
                                            class="form-control @error('image') is-invalid @enderror" name=" image"
                                            id="image">
                                        <span class="text-danger">(Note : Max Size -
                                            2MB)</span>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="text-danger">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>




                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-primary w-md">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

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


            $('#gallery').change(function() {
                var form_data = new FormData();
                form_data.append('image', this.files[0]);
                form_data.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/upload/banners') }}",
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

                                <div class="col-sm-1 media-thumb-wrap d-inline-block">
                                    <figure class="media-thumb">
                                        <img src="{{ asset('public/assets/images/banners/${res.file_name}') }}" height="100px" width="100px">
                                        <div class="media-item-actions mt-1">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16">
                                                    <g fill="#5D5D5D" fill-rule="nonzero">
                                                        <path d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z"></path>
                                                        <path d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <input type="hidden" name="gallery_adv[]" value="${res.file_name}">
                                            <span class="icon icon-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>

                            `;
                                $('#place_gallery_thumbs1').append(html);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred! Please try again!');
                        console.log(xhr.responseText);
                    }
                });

            });



            $('#gallery_cat').change(function() {
                var form_data = new FormData();
                form_data.append('image', this.files[0]);
                form_data.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ url('admin/upload/banners') }}",
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

                                <div class="col-sm-1 media-thumb-wrap d-inline-block">
                                    <figure class="media-thumb">
                                        <img src="{{ asset('public/assets/images/banners/${res.file_name}') }}" height="100px" width="100px">
                                        <div class="media-item-actions mt-1">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16">
                                                    <g fill="#5D5D5D" fill-rule="nonzero">
                                                        <path d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z"></path>
                                                        <path d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <input type="hidden" name="gallery_cat[]" value="${res.file_name}">
                                            <span class="icon icon-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>

                            `;
                                $('#place_gallery_thumbs_cat').append(html);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred! Please try again!');
                        console.log(xhr.responseText);
                    }
                });

            });


            $(document).on("click", ".icon-delete", function(event) {
                event.preventDefault();
                let thumbnail = $(this).closest('.media-thumb-wrap');
                thumbnail.remove();
            });


        })
    </script>
@stop
