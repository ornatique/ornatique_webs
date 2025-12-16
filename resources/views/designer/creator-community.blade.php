@include('designer.header_main')
<section class="community-banner">
    <div class="container">
        <div class="community-banner-content">
            <h3>Creator Community</h3>
        </div>
    </div>
</section>
<section class="community-banner2">
    <div class="container">
        <div class="designer-container">
            <div class="align-items-center row">
                <div class="col-md-6">
                    <div class="">
                        <img src="{{ asset('public/assets/images/designer-logo.png') }}" alt=""
                            style="width: 340px">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="community-content text-right">
                        <h2>We are AlagSEE designer</h2>
                        <p>AlagSEE Designer is a network of creative platforms aimed at building a barrier-free
                            space for your talent.
                        </p>
                        <h6>We are a global commons.<br>
                            Made up of your creativity.</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="community-offer-section">
    <div class="container">
        <div class="align-items-center row p-0 m-0">
            <div class="col-lg-4 col-md-12 col-12">
                <div class="community-content">
                    <h2>We are <br>AlagSEE designer</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="offer-item">
                    <div style="z-index: 1">
                        <div class="offer-img">
                            <img src="{{ asset('public/assets/images/networking.png') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="offer-text">
                            <p>Get up to 50% discount on<br>
                                designs and merch.<br>
                                And, never wait for a Black Friday again!
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="offer-item">
                    <div style="z-index: 1">
                        <div class="offer-img">
                            <img src="{{ asset('public/assets/images/clipboard.png') }}" alt="">
                        </div>
                    </div>
                    <div>
                        <div class="offer-text">
                            <p>All the latest products, activities,<br>
                                and trends, gets to you straight<br>
                                and first, period.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
<section class="community-banner-3">
    <div class="container">
        <div class="designer-container">
            <div class="community-network">
                <div class="title-text-blur">
                    <h2>We are AlagSEE Designer</h2>
                </div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                        <h2 class="community-network-title text-right text-white">WE ARE ALAGSEE DESIGNER</h2>
                        <div class="community-network-content">
                            <p>AlagSEE Designer is a network of creative platforms aimed at building a barrier-free
                                space for your talent.
                            </p>
                            <h6>We are a global commons.<br>
                                Made up of your creativity.</h6>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="community-banner-4">
    <div class="container">
        <div class="designer-container">
            <div class="align-items-center row p-0 m-0">
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <div class="about-content">
                        <h2>WE ARE ALAGSEE DESIGNER</h2>
                        <p>Bombay Sapphire is the world's number one premium gin by value. Based on a 1761 recipe,
                            Bombay Sapphire gin is created by perfectly balancing a unique combination of 10
                            hand-selected exotic botanicals from around the world. The BOMBAY distillery at </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="animated-image">
                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets9.lottiefiles.com/private_files/lf30_yoav1gka.json"
                            background="transparent" speed="1" loop autoplay style="width: 300px; height: 300px;">
                        </lottie-player>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="align-items-center row p-0 m-0">
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="animated-image">
                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets9.lottiefiles.com/packages/lf20_fonjkhhq.json"
                            background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
                        </lottie-player>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-content">
                        <h2 class="text-right">WE ARE ALAGSEE DESIGNER</h2>
                        <p class="text-right">Bombay Sapphire is the world's number one premium gin by value. Based on a
                            1761 recipe,
                            Bombay Sapphire gin is created by perfectly balancing a unique combination of 10
                            hand-selected exotic </p>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="about-content">
                        <h2 class="mb-4">Frequently Asked Questions</h2>

                        @foreach ($faqs as $i => $faq)
                            <div class="faq-section">
                                <div id="accordion{{ $i }}">
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h5 class="mb-0">
                                                <a class="collapsed" role="button" data-toggle="collapse"
                                                    href="#collapse-0{{ $i }}"
                                                    aria-expanded="{{ $i == 0 ? 'true' : '' }}"
                                                    aria-controls="collapse-1">
                                                    {{ $i + 1 }}. {{ ucfirst($faq->question) }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapse-0{{ $i }}"
                                            class="{{ $i == 0 ? 'show' : '' }} collapse"
                                            data-parent="#accordion{{ $i }}"
                                            aria-labelledby="heading-0{{ $i }}" style="">
                                            <div class="card-body">
                                                <?php echo htmlspecialchars_decode(ucfirst($faq->answer)); ?>
                                                <p></p>
                                                {{-- <p></p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="faq-section">
                            <div id="accordion1">
                                <div class="card">
                                    <div class="card-header" id="heading-2">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2"
                                                aria-expanded="" aria-controls="collapse-2">
                                                2. How do I make a premium user?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapse-2" class=" collapse" data-parent="#accordion1"
                                        aria-labelledby="heading-2">
                                        <div class="card-body">
                                            <p>simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type
                                                and
                                                scrambled it to make a type specimen book. It has survived not only five
                                                centuries</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="faq-section">
                            <div id="accordion2">
                                <div class="card">
                                    <div class="card-header" id="heading-3">
                                        <h5 class="mb-0">
                                            <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3"
                                                aria-expanded="" aria-controls="collapse-3">
                                                3. How do I make a premium user?
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapse-3" class=" collapse" data-parent="#accordion2"
                                        aria-labelledby="heading-3">
                                        <div class="card-body">
                                            <p>simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy
                                                text ever since the 1500s, when an unknown printer took a galley of type
                                                and
                                                scrambled it to make a type specimen book. It has survived not only five
                                                centuries</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>
        </div>
    </div>
</section>
@include('designer.footer')
