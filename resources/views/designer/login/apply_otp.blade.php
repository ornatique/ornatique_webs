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
                        <h2>ENTER OTP</h2>
                        <p class="mb-4">We've sent an OTP to your phone number.</p>
                        <div class="login-form">
                            @if (session('msg'))
                                <div id="successMessage"
                                    class="alert alert-danger text-center border-0 bg-danger alert-dismissible fade show">
                                    <div class="text-white"> &#128533 {{ session('msg') }}</div>
                                </div>
                            @endif
                            <form action="{{ url('designer/verify-otp') }}" method="POST">
                                @csrf
                                @php
                                    $data = Request::session()->get(csrf_token());
                                @endphp
                                <div class="form-group">
                                    <input placeholder="Phone number" type="number" readonly
                                        class="form-control @error('phonenumber') is-invalid @enderror"
                                        name="phonenumber" id="phonenumber"
                                        @if ($data) value="{{ $data->contact }}" @endif>
                                    @error('phonenumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="One time password" type="number" required
                                        class="form-control @error('otp') is-invalid @enderror" name="otp"
                                        value="{{ old('otp') }}">
                                    @error('otp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong class="text-danger">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="pt-2 text-center"><a href="javascript:void();" id="resend"
                                            style="color: var(--themeCyan)">Resend</a>
                                    </div>
                                </div>
                                <div class="form-group text-left">
                                    <button href="#" class="btn-block yellow-btn" type="submit"
                                        style="cursor: pointer">
                                        <div class="button_inner text-center"><span data-text="Verify OTP">Verify
                                                OTP</span></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="p-0 col-md-1"></div>
                <div class="p-0 col-md-7">
                    <div class="designer-bg">
                        <img src="{{ asset('public/assets/images/designer-img1.jpg') }}" alt="Logo">
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
<script>
    $(document).ready(function() {
        var phone = $('#phonenumber').val();
        $('#resend').click(function() {
            $.ajax({
                method: 'post',
                url: "{{ url('resend/otp') }}",
                data: {
                    'phone': phone,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(data) {}
            })
        })
    })
</script>
@include('designer.footer')
