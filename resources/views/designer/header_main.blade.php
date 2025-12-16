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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <!-- Stylesheets -->
    <link href="{{ asset('public/assets/fonts/fonts.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap 4 css-->
    <link href="{{ asset('public/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('public/assets/css/designer.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet" type="text/css" /> -->
</head>

<body>

    <div class="menu-overlay"></div>
    <div class="" style="height: 118.86px"></div>
    <header class="header_wrapper sticky-header">
        <div class="container">
            <div class="row align-items-center mobile-hide">
                <div class="col-12 col-md-4 main-logo">
                    <a href="{{ url('designer/home') }}"><img
                            src="{{ asset('public/assets/images/designer-logo.png') }}" alt="logo"></a>
                    </figure>
                </div>
                <div class="col-md-8">
                    <ul class="desktop-nav nav justify-content-end">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('designer/creator-community') }}">Creator
                                Community</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('designer/faq') }}">FAQ's</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Levels</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('designer/login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="row desktop-hide">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}"><img
                        src="{{ asset('public/assets/images/designer-logo.png') }}" alt="logo"></a>
                <button class="navbar-toggler" type="button" id="navbarSideButton">
                    <img src="{{ asset('public/assets/images/menu.png') }}">
                </button>

                <div class="navbar-side" id="#navbarSide">
                    <a class="close-menu" href="#">
                        <i class="fas fa-times"></i>
                    </a>
                    <ul class="navbar-nav mr-auto">
                        <li><a class="nav-link active" href="{{ url('designer/creator-community') }}">Creator
                                Community</a></li>
                        <li><a class="nav-link" href="{{ url('designer/faq') }}">FAQ's</a></li>
                        <li><a class="nav-link" href="#">Levels</a></li>
                        <li><a class="nav-link" href="{{ url('designer/login') }}">Login</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
