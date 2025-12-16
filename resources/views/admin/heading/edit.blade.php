@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Heading Add</h4>
                    <div class="row">
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <form action="{{ url('admin/heading/edit') . '/' . $data->id }}" class="row" method="post"
                            enctype="multipart/form-data" novalidate>@csrf
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Heading One<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('heading_one') is-invalid @enderror"
                                        type=" text" name="heading_one" value="{{ $data->heading_one }}"
                                        placeholder="Enter name*" id="example-text-input">
                                    @error('heading_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Heading Two<span class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('heading_two') is-invalid @enderror"
                                        type=" text" name="heading_two" value="{{ $data->heading_two }}"
                                        placeholder="Enter name*" id="example-text-input">
                                    @error('heading_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="example-text-input" class="form-label">Heading Three<span
                                            class="text-danger">
                                            *</span></label>
                                    <input required class="form-control @error('heading_three') is-invalid @enderror"
                                        type=" text" name="heading_three" value="{{ $data->heading_three }}"
                                        placeholder="Enter name*" id="example-text-input">
                                    @error('heading_three')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="app_bar_color" class="form-label">App Bar Color</label>
                                    <div class="d-flex align-items-center">
                                        <input type="color" class="form-control form-control-color me-2"
                                            id="app_bar_color_picker"
                                            value="{{ old('app_bar_color', $data->app_bar_color ?? '#000000') }}">
                                        <input type="text" class="form-control" name="app_bar_color"
                                            id="app_bar_color_text"
                                            value="{{ old('app_bar_color', $data->app_bar_color ?? '#000000') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="bottom_bar_color" class="form-label">Bottom Bar Color</label>
                                    <div class="d-flex align-items-center">
                                        <input type="color" class="form-control form-control-color me-2"
                                            id="bottom_bar_color_picker"
                                            value="{{ old('bottom_bar_color', $data->bottom_bar_color ?? '#000000') }}">
                                        <input type="text" class="form-control" name="bottom_bar_color"
                                            id="bottom_bar_color_text"
                                            value="{{ old('bottom_bar_color', $data->bottom_bar_color ?? '#000000') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="back_ground_color" class="form-label">Background Color</label>
                                    <div class="d-flex align-items-center">
                                        <input type="color" class="form-control form-control-color me-2"
                                            id="back_ground_color_picker"
                                            value="{{ old('back_ground_color', $data->back_ground_color ?? '#ffffff') }}">
                                        <input type="text" class="form-control" name="back_ground_color"
                                            id="back_ground_color_text"
                                            value="{{ old('back_ground_color', $data->back_ground_color ?? '#ffffff') }}">
                                    </div>
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
        function syncColorInputs(pickerId, textId) {
            const picker = document.getElementById(pickerId);
            const text = document.getElementById(textId);

            // picker → text
            picker.addEventListener('input', () => {
                text.value = picker.value;
            });

            // text → picker (only if valid hex code)
            text.addEventListener('input', () => {
                if (/^#([0-9A-Fa-f]{3}){1,2}$/.test(text.value)) {
                    picker.value = text.value;
                }
            });
        }

        // initialize sync
        syncColorInputs("app_bar_color_picker", "app_bar_color_text");
        syncColorInputs("bottom_bar_color_picker", "bottom_bar_color_text");
        syncColorInputs("back_ground_color_picker", "back_ground_color_text");
    </script>

@stop
