<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon-->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/select2.min.css') ?>">
    <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?= base_url('assets/public/js/bootstrap.bundle.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/public/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/public/css/bootstrap.min.css') ?>">
    <!-- <link rel="stylesheet" href="<?= base_url('assets/public/css/all.min.css') ?>"> -->
    <link rel="stylesheet" href="<?= base_url('assets/public/css/bootstrap-multiselect.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/public/css/jquery.dataTables.min.css') ?>">


    <script src="<?= base_url('assets/public/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/public/js/sweetalert2@11.js') ?>"></script>
    <script src="<?= base_url('assets/public/js/sweetalert.min.js') ?>"></script>
    <!-- <script src="<?= base_url('assets/public/js/bootstrap-multiselect.min.js') ?>"></script> -->
    <script src="<?= base_url('assets/public/js/jquery.dataTables.min.js') ?>"></script>




</head>
<?php
$system_data = $this->db->get('system_settings')->result();
?>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">


            <a href="<?= base_url('home') ?>" style="text-decoration: none;" class="d-none d-md-block">
                <div class="logocon d-flex">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="">
                    <h3 style="color: #082045; padding-top: 15px;">Jagdamba <br /> Polymers</h3>
                </div>
                <p class="texttab" style="color: #cd9933;font-weight: 500;font-size: 14px;" behavior="" direction="">
                    Leading supplier of Pet, Bopp and Cpp film</p>
            </a>


            <div class="navbar-nav">
                <div class="hedar">
                    <a href="https://wa.me/9462277843" target="_blank" style="text-decoration: none; color:unset">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                            style="width: 25px; height: 25px; vertical-align: middle; margin-bottom: 2px;">
                        9462277843
                    </a> &nbsp;
                    <a href="https://wa.me/7600777843" target="_blank" style="text-decoration: none; color:unset;">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                            style="width: 25px; height: 25px; vertical-align: middle; margin-bottom: 2px;">
                        7600777843
                    </a>
                </div>
                <div class="d-flex gap-4">
                    <a class="nav-link " href="<?= base_url('home') ?>">Home</a>
                    <a class="nav-link " href="<?= base_url('home/about_us') ?>">About Us</a>
                </div>
            </div>

            <div class="d-block d-md-none">


                <a href="<?= base_url('home') ?>" style="text-decoration: none;">
                    <div class="logocon d-flex">
                        <img src="<?= base_url('assets/images/logo.png') ?>" alt="">
                        <h3 style="color: #082045; padding-top: 15px;">Jagdamba <br /> Polymers</h3>
                    </div>
                    <p class="texttab" style="color: #cd9933;font-weight: 500;font-size: 14px;" behavior=""
                        direction="">
                        Leading supplier of Pet, Bopp and Cpp film</p>
                </a>


                <a href="https://wa.me/9462277843" target="_blank" style="text-decoration: none; color:unset"
                    class="d-block d-md-none">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                        style="width: 25px; height: 25px; vertical-align: middle; margin-bottom: 2px;">
                    9462277843
                </a> &nbsp;
                <a href="https://wa.me/7600777843" target="_blank" style="text-decoration: none; color:unset;"
                    class="d-block d-md-none">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp"
                        style="width: 25px; height: 25px; vertical-align: middle; margin-bottom: 2px;">
                    7600777843
                </a>

                <a class="nav-link d-block d-md-none" href="<?= base_url('home') ?>">Home</a>
                <a class="nav-link d-block d-md-none" href="<?= base_url('home/about_us') ?>">About Us</a>
            </div>


        </div>


    </nav>
</body>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLink = document.getElementById('logout-link');

        if (logoutLink) {
            logoutLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                // Open SweetAlert popup
                Swal.fire({
                    title: 'Are you sure you want to logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to logout endpoint
                        $.ajax({
                            url: '<?= base_url("auth/logout_user") ?>',
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                // Check if logout was successful
                                if (response.success) {
                                    // Show a success message
                                    window.location.href = '<?= base_url("home") ?>';
                                    // Swal.fire('Logged Out', 'You have been logged out successfully.', 'success')
                                    //     .then((result) => {
                                    //         // Redirect to login page or perform other actions after logout
                                    //         window.location.href = '<?= base_url("home") ?>'; // Reload the page
                                    //     });
                                } else {
                                    // Show an error message
                                    Swal.fire('Error', 'Logout failed', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Show an error message
                                Swal.fire('Error', 'Logout request failed', 'error');
                            }
                        });
                    }
                });
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const logoutLink = document.getElementById('logout-link1');

        if (logoutLink) {
            logoutLink.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior

                // Open SweetAlert popup
                Swal.fire({
                    title: 'Are you sure you want to logout?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to logout endpoint
                        $.ajax({
                            url: '<?= base_url("auth/logout_user") ?>',
                            method: 'post',
                            dataType: 'json',
                            success: function(response) {
                                // Check if logout was successful
                                if (response.success) {
                                    // Show a success message
                                    window.location.href = '<?= base_url("home") ?>';
                                    // Swal.fire('Logged Out', 'You have been logged out successfully.', 'success')
                                    //     .then((result) => {
                                    //         // Redirect to login page or perform other actions after logout
                                    //         window.location.href = '<?= base_url("home") ?>'; // Reload the page
                                    //     });
                                } else {
                                    // Show an error message
                                    Swal.fire('Error', 'Logout failed', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Show an error message
                                Swal.fire('Error', 'Logout request failed', 'error');
                            }
                        });
                    }
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const togglerButton = document.querySelector('.navbar-toggler');
        const saidNavbar = document.querySelector('.side-widget');

        togglerButton.addEventListener('click', function() {
            saidNavbar.classList.toggle('saidbar-active');

            const allSaidNavbars = document.querySelectorAll('.side-widget');
            allSaidNavbars.forEach(function(element) {
                if (element !== saidNavbar) {
                    element.classList.remove('saidbar-active');
                }
            });
        });
    });

    $(document).ready(function() {
        $('.saidnavbar').click(function() {
            $(this).removeClass('saidnavbar-active');
        });
    });
    $(document).ready(function() {
        $('.saidnavbar').click(function() {
            $('.side-widget').removeClass('saidbar-active');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const togglerButton = document.querySelector('.navbar-toggler');
        const saidNavbar = document.querySelector('.saidnavbar');

        togglerButton.addEventListener('click', function() {
            saidNavbar.classList.toggle('saidnavbar-active');


            const allSaidNavbars = document.querySelectorAll('.saidnavbar');
            allSaidNavbars.forEach(function(element) {
                if (element !== saidNavbar) {
                    element.classList.remove('saidnavbar-active');
                }
            });
        });
    });
</script>