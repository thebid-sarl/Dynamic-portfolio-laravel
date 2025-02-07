<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <livewire:styles />
    <!-- Template Main CSS File -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/typed.js/typed.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <livewire:scripts />
     


</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

    <!-- ======= Header ======= -->
    <header id="header">
        <div class="d-flex flex-column">

            <div class="profile">
                <img src="@yield('headerImg')" alt="" class="img-fluid rounded-circle">
                <h1 class="text-light text-center"><a>@yield('name')</a></h1>
                <div class="social-links mt-3 text-center">
                    @yield('github')
                    @yield('twitter')
                    @yield('skype')
                    @yield('linkedin')
                </div>
            </div>

            <nav id="navbar" class="nav-menu navbar">
                <ul>
                    <li>
                        <a href="#hero" class="nav-link scrollto active">
                            <i class="bx bx-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#about" class="nav-link scrollto">
                            <i class="bx bx-user"></i>
                            <span>About</span>
                        </a>
                    </li>
                    <li>
                        <a href="#skills" class="nav-link scrollto">
                            <i class="bi bi-arrows-angle-expand"></i>
                            <span>Skills</span>
                        </a>
                    </li>
                    <li>
                        <a href="#experience" class="nav-link scrollto">
                            <i class="bi bi-arrow-up-right-circle"></i>
                            <span>Experience</span>
                        </a>
                    </li>
                    <li>
                        <a href="#education" class="nav-link scrollto">
                            <i class="bx bx-book-content"></i>
                            <span>Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="#certification" class="nav-link scrollto">
                            <i class="bi bi-patch-check"></i>
                            <span>Certification</span>
                        </a>
                    </li>
                    <li>
                        <a href="#contact" class="nav-link scrollto">
                            <i class="bx bx-envelope"></i>
                            <span>Contact</span>
                        </a>
                    </li>
                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->
    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
