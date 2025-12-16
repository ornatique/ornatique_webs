@include('designer.header')
<div class="menu-overlay"></div>

<section class="home-banner-section" style="background-image: url('{{ asset('public/assets/images/home-banner.png') }}')">
    <header class="header_wrapper" style="box-shadow: unset">
        <div class="container">
            <div class="row align-items-center mobile-hide">
                <div class="col-12 col-md-4 main-logo">
                    <a href="{{ route('designer_home') }}"><img class="invisible"
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
        <div class="p-0 m-0 row desktop-hide">
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
                        <li><a href="#">Discover</a></li>
                        <li><a href="{{ url('designer/faq') }}">FAQ's</a></li>
                        <li><a href="#">Levels</a></li>
                        <li><a href="{{ url('designer/login') }}">Login</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="designer-banner-container">
            <div class="row">
                <div class="col-md-3 col-12">
                    <a href="{{ route('designer_home') }}">
                        <div class="designer-logo">
                            <img src="{{ asset('public/assets/images/designer-logo.png') }}" alt="">
                        </div>
                    </a>
                </div>
                <div class="col-md-9 col-12">
                    <div class="banner-content">
                        <p>It is a long established fact that a reader will be distracted by
                            the readable content of a page when looking at its layout</p>
                        <div class="pr-4 text-right">
                            <a href="{{ route('apply_now') }}" class="yellow-btn">
                                <div class="button_inner"><span data-text="Apply Now">Apply Now</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="designer-assets-section">
    <div class="container">
        <div class="designer-container">
            <div class="designer-assets-list">
                @foreach ($assets as $asset)
                    <div class="product-list asset_digital" data-id="{{ $asset->id }}">
                        <div class="arrival-info">
                            <a href="{{ url('designer/assets-detail') . '/' . $asset->id }}">
                                <div class="product-img">
                                    <figure><img
                                            src="{{ asset('public/assets/images/digitalassets') . '/' . $asset->image }}"
                                            alt="product-image">
                                    </figure>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <h2 class="my-4">FREQUENTLY ASKED QUESTIONS</h2>
            <div class="contact-tab">
                @foreach ($headers as $i => $header)
                    <div class="faq-section">
                        <div id="accordion{{ $i }}">
                            <div class="card">
                                <div class="card-header" id="heading-1">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            href="#collapse-{{ $i }}"
                                            aria-expanded="{{ $i == 0 ? 'true' : '' }}" aria-controls="collapse-1">
                                            {{ $i + 1 }}. {{ ucfirst($header->question) }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-{{ $i }}" class="{{ $i == 0 ? 'show' : '' }} collapse"
                                    data-parent="#accordion{{ $i }}"
                                    aria-labelledby="heading-{{ $i }}">
                                    <div class="card-body">
                                        <p>
                                            <?php echo htmlspecialchars_decode(ucfirst($header->paragraph)); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="designer-blog-section">
    <div class="container">
        <div class="designer-container">
            <div class="row align-items-center" data-aos="fade-up">
                <h2>OUR BLOG</h2>
            </div>
            <div class="row blog-list" data-aos="fade-up">
                @foreach ($blogs as $blog)
                    <div class="col-md-3">
                        <div class="blog-info designer-blog-info" id="blog-info">
                            <a href="javascript:void(0)" class="blog-info-a">
                                <div class="product-img">
                                    <figure><img
                                            @if ($blog->image) src="{{ asset('public/assets/images/blogs') . '/' . $blog->image }}" @endif
                                            alt="product-image">
                                    </figure>
                                </div>
                                <div class="blog-content">
                                    <h3>{{ ucfirst($blog->title) }}</h3>
                                    <p class="creator-name">
                                        By John Doe
                                    </p>
                                    <div>
                                        <button href="#" class="yellow-btn">
                                            <div class="button_inner"><span data-text="Read More">Read More</span>
                                            </div>
                                        </button>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="col-md-3">
                    <div class="blog-info designer-blog-info" id="blog-info">
                        <a href="#" class="blog-info-a">
                            <div class="product-img">
                                <figure><img src="{{ asset('public/assets/images/blog-img.jpg') }}"
                alt="product-image">
                </figure>
            </div>
            <div class="blog-content">
                <h3>There are many variations of passages of Lorem test majority</h3>
                <p class="creator-name">
                    By John Doe
                </p>
                <div>
                    <button href="#" class="yellow-btn">
                        <div class="button_inner"><span data-text="Read More">Read More</span>
                        </div>
                    </button>
                </div>

            </div>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="blog-info designer-blog-info" id="blog-info">
            <a href="#" class="blog-info-a">
                <div class="product-img">
                    <figure><img src="{{ asset('public/assets/images/blog-img.jpg') }}" alt="product-image">
                    </figure>
                </div>
                <div class="blog-content">
                    <h3>There are many variations of passages of Lorem test majority</h3>
                    <p class="creator-name">
                        By John Doe
                    </p>
                    <div>
                        <button href="#" class="yellow-btn">
                            <div class="button_inner"><span data-text="Read More">Read More</span>
                            </div>
                        </button>
                    </div>

                </div>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="blog-info designer-blog-info" id="blog-info">
            <a href="#" class="blog-info-a">
                <div class="product-img">
                    <figure><img src="{{ asset('public/assets/images/blog-img.jpg') }}" alt="product-image">
                    </figure>
                </div>
                <div class="blog-content">
                    <h3>There are many variations of passages of Lorem test majority</h3>
                    <p class="creator-name">
                        By John Doe
                    </p>
                    <div>
                        <button href="#" class="yellow-btn">
                            <div class="button_inner"><span data-text="Read More">Read More</span>
                            </div>
                        </button>
                    </div>

                </div>
            </a>
        </div>
    </div> --}}
            </div>
        </div>
    </div>

</section>
</div>

<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 60) {
                $('header').addClass("sticky-header");
                $('.main-logo img').removeClass("invisible");
            } else {
                $('header').removeClass("sticky-header");
                $('.main-logo img').addClass("invisible");
            }
        });

        $('.asset_digital').click(function() {
            // alert();
            var id = $(this).attr('data-id');
            $.ajax({
                url: "{{ url('digital/asset') }}",
                data: {
                    id: id,
                }
            })
        })

    });
</script>
@include('designer.footer')
