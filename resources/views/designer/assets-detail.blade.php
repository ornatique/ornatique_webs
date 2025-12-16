@include('designer.header_main')
<div class="main" style="margin-top: 119px">
    <section class="asset-detail-section">
        <div class="asset-detail-img">
            <div class="container" style="max-width: 1000px">
                <div class="asset-image">
                    <img src="{{ asset('public/assets/images/digitalassets') . '/' . $data->image }}" alt="">
                </div>
            </div>
        </div>
        <div class="asset-detail-content">
            <div class="created-by">
                <span class="crerated-img">
                    <img src="{{ asset('public/assets/images/creators') . '/' . $data->creator->user->image }}"
                        alt="product-image">
                </span>
                <div class="text-btn">
                    <div class="text">
                        <span class="gray-text">Created by</span>
                        <span class="name">{{ ucfirst($data->creator->user->name) }}</span>
                        <p class="mb-0 text-right gray-text">Level5</p>
                    </div>
                    <a href="javascript:void(0);" id=""
                        class="btn btn-black-brd followBtn  @if (count($data->follow) > 0) following @else follow @endif"
                        @if (count($data->follow) > 0) style="background: rgb(252, 236, 2);" @endif
                        data-user-id="{{ $data->user->id }}" data-creator-id="{{ $data->creator->user->id }}">
                        @if (count($data->follow) > 0)
                            Following
                        @else
                            Follow
                        @endif
                    </a>
                </div>
            </div>
            <div class="about-design">
                <h5 class="mb-0">About Design</h5>
                <div class="views-favourite">
                    <a class="mr-2 total-view" href="#">
                        <i class="fas fa-eye"></i>
                        <span class="views">{{ count($data->view) }} Views</span>
                    </a>
                    <a class="total-favourite" href="#">
                        <i class="fas fa-heart"></i>
                        <span class="favourite-list">{{ count($data->wish_count) }} Favourite</span>
                    </a>
                </div>
                <p>
                    <?php echo htmlspecialchars_decode(ucfirst($data->product_details)); ?>
                </p>
                <div class="text-center"><a href="#" class="read-more">Read more...</a></div>
            </div>
            <hr>
            <div class="mb-3 d-flex">
                @if (Auth::check())
                    <div>
                        <span class="@if (count($data->like_count) > 0) wishlist-fav @else wishlist-un @endif "
                            data-like-asset_id="{{ $data->id }}" data-like-user_id="{{ Auth::id() }}">
                            <i class="mr-1 fa fa-heart"></i>
                        </span>
                    </div>
                @else
                    <div>
                        <span class="-un" data-like-asset_id="{{ $data->id }}"
                            data-like-user_id="{{ Auth::id() }}">
                            <a href="{{ route('designer_login') }}">
                                <i class="mr-1 fa fa-heart" style="color: #6c757d;
    font-size: 23px;"></i>
                            </a>
                        </span>
                    </div>
                @endif
                <div class="pl-2">
                    <small><b>{{ count($data->like_count) }} Peoples</b> love this</small>
                </div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                @if ($data->sale)
                    <div class="price-div">
                        <span class="sale-price">₹{{ $data->sale }}</span>
                    @else
                        <span class="sale-price">₹0</span>
                @endif
                @if ($data->regular_price)
                    <span class="mrp-price text-muted">₹{{ $data->regular_price }}</span>
            </div>
            @endif
            <div class="pl-2">
                <button class="yellow-btn" id="cart_button">
                    <div class="button_inner"><span data-text="Add to Cart">Add to
                            Cart</span>
                    </div>
                </button>
            </div>
        </div>
        {{-- Cart Form --}}
        <form action="" id="cart-form">
            <input type="hidden" value="{{ $data['id'] }}" id="asset_id" name="asset_id">
            <input type="hidden" value="{{ $data['sale'] }}" id="sale_price" name="sale_price">
            <input type="hidden" value="{{ $data['regular_price'] }}" id="regular_price" name="regular_price">
            <input type="hidden" value="{{ $data['discount'] }}" id="discount" name="discount">
            <input type="hidden" value="{{ $data['flat'] }}" id="flat" name="flat">
            <input type="hidden" value="1" name="quantity" id="quantity">
        </form>
        {{-- Cart Form --}}
        @if ($data->sponserd)
            <div class="mb-3 sponsored-tag" style="cursor: pointer">
                Design Sponsored by <a href="{{ url('sponsored-brand') }}"><b>{{ ucfirst($data->sponserd) }}</b></a>
            </div>
        @endif
        <div class="asset-accordian">
            <div class="faq-section">
                <div id="accordion0">
                    <div class="card">
                        <div class="card-header" id="heading-1">
                            <h5 class="mb-0">
                                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-0"
                                    aria-expanded="false" aria-controls="collapse-1">
                                    What is Digital Asset?
                                </a>
                            </h5>
                        </div>
                        <div id="collapse-0" class="collapse" data-parent="#accordion0" aria-labelledby="heading-0">
                            <div class="card-body">
                                <p class="mb-2">AlagSEE digital assets include digital designs, illustrations,
                                    and
                                    artworks that
                                    you can buy and then go on to digitally augment on your T Shirts. A
                                    first-of-its-kind idea, digital assets are a cost-effective way to reinvent
                                    your
                                    look and make the same attire look different with every digital design that
                                    you
                                    buy from our app. Curious to see how that works?
                                </p>
                                <div class="watch-video text-right">
                                    <a href="#">Watch Video <i class="fa fa-play-circle fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="share-social">
            <div class="social-links">
                <p>Connect with Artist</p>
                <div class="social-icon">
                    <ul>
                        <li>
                            <a href="{{ $data->creator->facebook }}" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>

                            <a href="{{ $data->creator->instagram }}" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $data->creator->youtube }}" target="_blank">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</div>
</section>
</div>
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.wishlist-un', function(e) {
            e.preventDefault();
            $(this).removeClass('wishlist-un');
            $(this).find('i').removeClass('fa fa-heart');
            $(this).addClass('wishlist-fav');
            $(this).find('i').addClass('fa fa-heart');

            var user_id = $(this).attr('data-like-user_id');
            var asset_id = $(this).attr('data-like-asset_id');
            $.ajax({
                method: 'post',
                url: "{{ url('get/likes') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'user_id': user_id,
                    'asset_id': asset_id
                },
                success: function(data) {
                    location.reload(true);
                }
            });
        });
        $(document).on('click', '.wishlist-fav', function(e) {
            e.preventDefault();
            $(this).removeClass('wishlist-fav');
            $(this).find('i').removeClass('fa fa-heart');
            $(this).addClass('wishlist-un');
            $(this).find('i').addClass('fa fa-heart');

            var user_id = $(this).attr('data-like-user_id');
            var asset_id = $(this).attr('data-like-asset_id');
            $.ajax({
                method: 'post',
                url: "{{ url('unlike') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'asset_id': asset_id,
                    'user_id': user_id
                },
                success: function(data) {
                    location.reload(true);
                }
            })
        });



        $(document).on('click', '.follow', function() {
            // aler();
            $(this).removeAttr('style');
            $(this).removeClass('follow');
            $(this).addClass('following');
            $("#followNotificationMessage").fadeToggle("slow");
            $(".followBtn").css('background', '#fcec02');
            $("#followNotificationMessage").delay(3000).fadeOut(300);
            value = ($(this).text() == "Follow") ? "Following" : "Follow";
            if (value == "Follow") {
                $(".followBtn").css('background', '#fcec02');
                $(this).text('Following');
            }
            var user_id = $(this).attr('data-user-id');
            var creator_id = $(this).attr('data-creator-id');
            $.ajax({
                method: 'post',
                url: "{{ url('follow') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'user_id': user_id,
                    'creator_id': creator_id,
                },
                success: function(data) {
                    // location.reload(true)
                }
            })
        })

        $(document).on('click', '.following', function() {
            $(this).addClass('follow');
            $(this).removeClass('following');
            // $("#followNotificationMessage").fadeToggle("slow");
            $(".followBtn").css('background', '#fcec02');
            $("#followNotificationMessage").delay(3000).fadeOut(300);
            value = ($(this).text() == "Follow") ? "Following" : "Follow";
            if (value == "Follow") {
                $(".followBtn").css('background', '#ffffff');
            }
            $(this).text(value);
            var user_id = $(this).attr('data-user-id');
            var creator_id = $(this).attr('data-creator-id');
            $.ajax({
                method: 'post',
                url: "{{ url('unfollow') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'user_id': user_id,
                    'creator_id': creator_id,
                },
                success: function(data) {
                    // location.reload(true)
                }
            })
        })






        $('#cart_button').click(function() {
            $('#cart_button').addClass('disabled ');
            var form = $('#cart-form')[0];
            var data = new FormData(form);
            data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                enctype: 'multipart/form-data',
                method: 'POST',
                url: "{{ url('insert/cart') }}",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function(data) {
                    // alert(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // User Not Logged In
                    // 401 Unauthorized Response
                    window.location.replace("{{ url('login/form') }}");
                }
            });
        });


    });
</script>
@include('designer.footer')
