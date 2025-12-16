@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" action="{{ url('admin/product/banner/edit') . '/' . $data['id'] }}" method="post"
                        enctype="multipart/form-data">
                        <div class="mb-2 overflow-hidden">
                            <h4 class="card-title float-start">Banners</h4>

                        </div>
                        @csrf
                        <div class="row">


                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-email-input">Product</label><span class="text-danger">*</span>
                                    <select class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                        aria-label="Default select example">
                                        <option selected value="0">Please select product</option>
                                        @foreach ($products as $product)
                                            <option {{ $product->id == $data['product_id'] ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ ucwords($product->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-category-input">Category</label><span class="text-danger">*</span>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" aria-label="Default select example">
                                        <option selected value="0">Please select category</option>
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

                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-subcategory-input">Subcategory</label><span
                                        class="text-danger">*</span>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror"
                                        name="subcategory_id" aria-label="Default select example">
                                        <option selected value="0">Please select subcategory</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id', $data->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ ucwords($subcategory->name) }}
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

                            <div class="col-lg-12">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="example-text-input" class="form-label">Image <span class="text-danger">
                                                *</span></label>
                                        <img src="{{ asset('public/assets/images/banners') . '/' . $data->image }}"
                                            alt="" id="preview-file" height="200px" class="mb-3">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            name="image" id="file">
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
                            <button type="submit" class="btn btn-primary w-md">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

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

        })
    </script>
@stop
