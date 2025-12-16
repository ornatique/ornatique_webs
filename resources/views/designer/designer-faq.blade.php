@include('designer.header_main')
<div class="main">
    <section class="designer-faq-section">
        <div class="container">
            <div class="designer-container">
                <p class="mb-0">Home / FAQ's</p>
                <h2 class="mt-0 mb-4">FREQUENTLY ASKED QUESTIONS</h2>
                <div class="contact-tab">

                    @foreach ($headers as $i => $header)
                    <div class="faq-section">
                        <div id="accordion{{ $i }}">
                            <div class="card">
                                <div class="card-header" id="heading-1">
                                    <h5 class="mb-0">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                            href="#collapse-{{ $i }}" aria-expanded="{{ $i == 0 ? 'true' : '' }}"
                                            aria-controls="collapse-1">
                                            {{ $i + 1 }}. {{ ucfirst($header->question) }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-{{ $i }}" class="{{ $i == 0 ? 'show' : '' }} collapse"
                                    data-parent="#accordion{{ $i }}" aria-labelledby="heading-{{ $i }}">
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

</div>
@include('designer.footer')