 <!-- Footer -->
 <footer class="black-bg footer">
     <div class="container">

         <div class="row align-items-end top-footer">
             <div class="col-md-4 social-icon">
                 <h4>Connect with us</h4>
                 <ul class="d-flex flex-wrap">
                     <li><a href="#" target="_blank"><img src="{{ asset('public/assets/images/fb.svg') }}" alt="FB"></a>
                     </li>
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
             <div class="text-center col-md-4 footer-logo">
                 <figure class="m-0"><a href="{{ route('designer_home') }}"><img
                             src="{{ asset('public/assets/images/designer-logo.png') }}" alt="footer logo"></a>
                 </figure>
             </div>
             <div class="text-center col-md-4 experience-app">
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
         <!-- Bottom -->
         <div class="designer-container">
             <div class="row bottom-footer">
                 <div class="col-md-2 text-center"><a href="{{ url('/') }}">AlagSEE Home</a></div>
                 <div class="col-md-2 text-center"><a href="{{ url('designer/home') }}">AlagSEE Designer</a></div>
                 <div class="col-md-2 text-center"><a href="#">How It Works</a></div>
                 <div class="col-md-2 text-center"><a href="#">Terms & Condition</a></div>
                 <div class="col-md-2 text-center"><a href="#">Privacy Policy</a></div>
                 <div class="col-md-2 text-center"><a href="#">Contact Us</a></div>

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
 <script>
$(document).ready(function() {
    $('#navbarSideButton').on('click', function() {
        $('.navbar-side').addClass('reveal');
        $('.menu-overlay').show();
    });

    $('.menu-overlay, .close-menu').on('click', function() {
        $('.navbar-side').removeClass('reveal');
        $('.menu-overlay').hide();
    });
});
 </script>
 <!-- Scripts -->
 </body>

 </html>