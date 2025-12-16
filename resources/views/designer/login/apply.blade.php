@include('designer.header')
<section class="designer-auth-section"
    style="background-image: url('{{ asset('public/assets/images/designer-login-bg.png') }}')">
    <div class="container">
        <div class="text-center logo">
            <figure class="m-0"><a href="{{ route('designer_home') }}"><img
                        src="{{ asset('public/assets/images/designer-logo.png') }}" alt="Logo"></a>
            </figure>
        </div>
        <div class="designer-auth">
            <p class="creator-name text-white mb-0 text-right">
                <label>Created by</label>
                <span>@maxsteve</span>
            </p>
            <div class="p-0 m-0 row">
                <div class="p-0 col-md-4">
                    <div class="auth-form position-relative">
                        <h2>APPLY NOW</h2>
                        <p class="mb-5"></p>
                        <div class="login-form">
                            <form action="{{ url('designer/apply-now') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input placeholder="Phone number" type="number"
                                        class="form-control @error('mobilenumber') is-invalid @enderror" required
                                        name="mobilenumber">
                                    @error('mobilenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group text-left">
                                    <button href="" class="btn-block yellow-btn" type="submit"
                                        style="cursor: pointer">

                                        <div class="button_inner text-center"><span data-text="Apply Now">Apply
                                                Now</span></div>

                                    </button>
                                </div>
                            </form>
                        </div>
                        <p class="text-center" style="position: absolute; bottom: 10px;left: 45px"><span>Why? </span> <a
                                href="#">Apply For Designer Platform</a></p>
                    </div>

                </div>
                <div class="p-0 col-md-1"></div>
                <div class="p-0 col-md-7">
                    <div class="designer-bg">
                        <img src="{{ asset('public/assets/images/designer-img.jpg') }}" alt="Logo">
                    </div>
                </div>
            </div>
        </div>
        <div class="designer-content">
            <h5><i>Step in to the</i></h5>
            <h3><i>Creator's Cosmos</i></h3>
        </div>
    </div>
</section>
@include('designer.footer')
