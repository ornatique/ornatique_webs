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
                    <div class="auth-form">
                        <h2>LOGIN</h2>
                        <p class=""><span>Don't have username? </span>
                            <a href="{{ url('designer/apply-now') }}">Apply Now</a>
                        </p>
                        <div class="login-form">
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input placeholder="Username" type="text"
                                        class="form-control @error('email') is-invalid @enderror" required
                                        name="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="Password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group text-left">
                                    <button class="btn-block yellow-btn" type="submit" style="cursor: pointer">
                                        <div class="button_inner"><span data-text="Login">Login</span></div>
                                    </button>
                                    <div class="terms-div">By clicking on Login, I accept the Terms & Conditions &
                                        Privacy Policy</div>
                                </div>
                            </form>
                        </div>

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
