@extends('admin.template')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" action="{{ route('admin_products_add') }}" method="post"
                        enctype="multipart/form-data">
                        <div class="mb-2 overflow-hidden">
                            <h4 class="card-title float-start">Banners</h4>
                            <a href="#" class="float-end ms-2">
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </a>
                            <a href="{{ url()->previous() }}" class="float-end">
                                <button type="submit" class="btn btn-danger w-md">Cancel</button>
                            </a>
                        </div>
                        @csrf
                        <div class="row">


                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-product-input">Product</label><span class="text-danger">*</span>
                                    <select class="form-select @error('product_id') is-invalid @enderror" name="product_id"
                                        id="product_id" aria-label="Default select example">
                                        <option selected value="0">Please select product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ ucfirst($product->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Category Dropdown -->
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-category-input">Category</label><span class="text-danger">*</span>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                        name="category_id" id="category_id" aria-label="Default select example">
                                        <option selected value="0">Please select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ ucfirst($category->name) }}
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

                            <!-- Subcategory Dropdown -->
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-subcategory-input">Subcategory</label><span
                                        class="text-danger">*</span>
                                    <select class="form-select @error('subcategory_id') is-invalid @enderror"
                                        name="subcategory_id" id="subcategory_id" aria-label="Default select example">
                                        <option selected value="0">Please select subcategory</option>
                                    </select>
                                    @error('subcategory_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="formrow-image-input">Image</label><span class="text-danger">*</span>
                                    <input required type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" value="{{ old('image') }}">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
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
