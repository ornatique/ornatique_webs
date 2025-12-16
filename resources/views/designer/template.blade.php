<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1" />
    <meta charset="UTF-8">
    <!-- Required Title -->
    <title>AlagSEE Designer</title>
    <link rel="icon" href="{{ asset('public/assets/admin/images/favicon.png') }}" type="image/png" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <!-- Stylesheets -->
    <link href="{{ asset('public/assets/fonts/fonts.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 4 css-->
    <link href="{{ asset('public/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('public/assets/css/designer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    @yield('main')

    <!-- Footer -->
    <footer class="black-bg footer">
        <div class="container">

            <div class="row align-items-end top-footer">
                <div class="col-md-4 social-icon">
                    <h4>Connect with us</h4>
                    <ul class="d-flex flex-wrap">
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/fb.svg') }}"
                                    alt="FB"></a></li>
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/insta.svg') }}"
                                    alt="insta"></a></li>
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/linkedin.svg') }}"
                                    alt="linkedin"></a></li>
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/pintest.svg') }}"
                                    alt="Pintest"></a></li>
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/youtube.svg') }}"
                                    alt="youtube"></a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-logo">
                    <figure><a href="{{ url('/') }}"><img src="{{ asset('public/assets/images/alagSee-logo.png') }}"
                                alt="footer logo"></a>
                    </figure>
                </div>
                <div class="col-md-4 experience-app">
                    <h4>Experience the App</h4>
                    <ul class="d-flex flex-wrap">
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/app-store.png') }}"
                                    alt=""></a>
                        </li>
                        <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/google-play.png') }}"
                                    alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row copyright">
                <div class="col-12 text-center">
                    <p>© 2022 <a href="#">AlagSEE.com</a> | All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 js -->
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
    <!-- jQueryUI js -->
    <script src="{{ asset('public/assets/js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/assets/js/popper.min.js') }}"></script>

    <!-- Wow Animation js -->
    <script src="{{ asset('public/assets/js/wow.min.js') }}" type="text/javascript"></script>

    <!-- Scripts -->
</body>

</html>