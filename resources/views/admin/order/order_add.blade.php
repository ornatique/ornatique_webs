@extends('admin.template')
@section('main')

    <div class="row">
        <div class="col-12 col-lg-12">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Estimate Status</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Estimate Status</li>
                        </ol>
                    </nav>
                </div>
                @if ($errors->any())
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                @endif
            </div>
            <!--end breadcrumb-->
            <!-- Form Elements -->
            <div class="card">
                <div class="card-body">
                    <div class="overflow-hidden card-title">
                        <span class="float-start fs-5 fw-bolder mb-0">Estimate Status</span>
                        <a href="{{ url()->previous() }}"><button type="button"
                                class="float-end btn btn-danger m-1 px-3">Cancel
                            </button></a>
                    </div>
                    <form class="row g-3" action="{{ route('admin_order_add') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">Estimate Status</label>
                            <input required type="text" value="{{ old('name') }}" placeholder="Enter Order Status"
                                class="form-control  @error('name') is-invalid @enderror" name="name"
                                id="inputFirstName">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="text-start col-12">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                            <a href="{{ url()->previous() }}"><button type="button"
                                    class="btn btn-danger px-5">Cancel</button></a>
                        </div>
                </div>
                </form>
            </div>

        </div>
        <!-- Form Elements -->
    </div>
    </div>
    <script src="{{ asset('public/assets/admin/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#state_dropdown').change(function() {
                let val = $(this).val();
                let url = '{{ url('admin/area/getcity') }}';
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: val,
                    },
                    success: function(data) {
                        $('#city_dropdown').html(data);
                    }
                });
            })
        });

        $('#file').change(function() {
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
    </script>
@stop
