@include('designer.header')
<section class="designer-auth-section"
    style="background-image: url('{{ asset('public/assets/images/designer-login-bg.png') }}')">
    <div class="container">
        <div class="text-center logo">
            <figure class="m-0"><a href="{{ route('designer_home') }}"><img
                        src="{{ asset('public/assets/images/designer-logo.png') }}" alt="Logo"></a>
            </figure>
        </div>
        <div class="designer-container">
            <div class="designer-auth">
                <div class="p-0 m-0 row justify-content-center">
                    <div class="p-0 col-md-11">
                        <div class="apply-form-holder position-relative">
                            <div class="apply-form">
                                <form action="{{ route('form') }}" method="POST">
                                    @csrf
                                    <div class="m-0 p-0 row">
                                        <div class="col-md-4">
                                            <h2>LET'S START</h2>
                                            <p class="mb-4" style="font-size: 16px"><a href="#">Provide your
                                                    Social
                                                    Handles (any one)</a></p>

                                            <div class="form-group">
                                                <input placeholder="Name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" required
                                                    name="name" value="{{ old('name') }}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input placeholder="Email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" required
                                                    name="email" value="{{ old('email') }}">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group social-url position-relative">
                                                <span class="social-profile"><img
                                                        src="{{ asset('public/assets/images/facebook.png') }}"></span>
                                                <input placeholder="Add your facebook url" type="text"
                                                    class="form-control @error('facebook') is-invalid @enderror"
                                                    name="facebook" value="{{ old('facebook') }}">
                                                @error('facebook')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group social-url position-relative">
                                                <span class="social-profile"><img
                                                        src="{{ asset('public/assets/images/insta.png') }}"></span>
                                                <input placeholder="Add your Instagram url" type="text"
                                                    class="form-control @error('instagram') is-invalid @enderror"
                                                    name="instagram" value="{{ old('instagram') }}">
                                                @error('instagram')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group social-url position-relative">
                                                <span class="social-profile"><img
                                                        src="{{ asset('public/assets/images/pinterest.png') }}"></span>
                                                <input placeholder="Add your Pinterest url" type="text"
                                                    class="form-control @error('pintrest') is-invalid @enderror"
                                                    name="pintrest" value="{{ old('pintrest') }}">
                                                @error('pintrest')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input placeholder="Enter referal code(optional)" type="text"
                                                    class="form-control" name="referal" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group social-url position-relative">
                                                <span class="social-profile"><img
                                                        src="{{ asset('public/assets/images/behance.png') }}"></span>
                                                <input placeholder="Add your behance url" type="text"
                                                    class="form-control @error('behance') is-invalid @enderror"
                                                    name="behance" value="{{ old('behance') }}">
                                                @error('behance')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group social-url position-relative">
                                                <span class="social-profile"><img
                                                        src="{{ asset('public/assets/images/dribble.png') }}"></span>
                                                <input placeholder="Add your dribble url" type="text"
                                                    class="form-control @error('dribble') is-invalid @enderror"
                                                    name="dribble" value="{{ old('dribble') }}">
                                                @error('dribble')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input placeholder="Add your website / Portfolio link" type="text"
                                                    class="form-control @error('portfolio') is-invalid @enderror"
                                                    name="portfolio" value="{{ old('link') }}">
                                            </div>
                                            <div class="form-group text-left">
                                                <button class="btn-block yellow-btn" type="submit"
                                                    style="cursor: pointer">
                                                    <div class="button_inner"><span data-text="Apply Now">Apply
                                                            Now</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                                <div class="m-0 p-0 row">
                                    <div class="col-md-12 share-portfolio">
                                        <h6 class="title">Shared your socials and design portfolio?</h6>
                                        <p class="">
                                            Just allow our team 48hrs to get back to your AlagSEE Designer registration
                                            request.
                                            Post which we'll drop your password and access details to your registered
                                            email.
                                            See
                                            you super-soon!
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

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
