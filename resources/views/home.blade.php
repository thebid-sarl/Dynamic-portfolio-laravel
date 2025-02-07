@extends('base')

@section('title')
    @if (empty($person))
        Prenom Nom
    @else
        {{ $person->firstname }} {{ $person->lastname }}
    @endif
@endsection

@section('headerImg')
    @if (empty($person))
        https://bootdey.com/img/Content/avatar/avatar7.png
    @else
        {{ Storage::url($person->headerImage) }}
    @endif
@endsection

@section('name')
    @if (empty($person))
        Prenom Nom
    @else
        {{ $person->firstname }} {{ $person->lastname }}
    @endif
@endsection

@section('github')
    @if (!empty($person->github))
        <a href="{{ $person->github }}" class="github" target="_blank" rel="noreferrer"><i
                class="bx bxl-github"></i></a>
    @endif
@endsection

@section('twitter')
    @if (!empty($person->twitter))
        <a href="{{ $person->twitter }}" class="twitter" target="_blank" rel="noreferrer"><i
                class="bx bxl-twitter"></i></a>
    @endif
@endsection

@section('skype')
    @if (!empty($person->skype))
        <a href="{{ $person->skype }}" class="google-plus" target="_blank" rel="noreferrer"><i
                class="bx bxl-skype"></i></a>
    @endif
@endsection

@section('linkedin')
    @if (!empty($person->linkedin))
        <a href=" {{ $person->linkedin }}" class="linkedin" target="_blank" rel="noreferrer"><i
                class="bx bxl-linkedin"></i></a>
    @endif
@endsection


@section('content')
    <!-- ======= Hero Section ======= -->
    @if (empty($person))
        <section style='background: url("{{ asset('assets/img/cover.jpg') }}") top center; background-size: cover;'
            id="hero" class="d-flex flex-column justify-content-center align-items-center">
            <div class="hero-container" style="margin-left: 10%" data-aos="fade-down">
                <h1 class="mb-5">Prenom Nom</h1>
                <p>I'm in "votre domaine" Domain</p>
            </div>
        </section>
    @else
        <section style="background: url({{ Storage::url($person->coverImage) }}) top center; background-size: cover;"
            id="hero" class="d-flex flex-column justify-content-center align-items-center">
            <div class="hero-container" style="margin-left: 10%" data-aos="fade-down">
                <h1 class="mb-5">{{ $person->firstname }} {{ $person->lastname }}</h1>
                <p>I'm in {{ $person->domain }} Domain</p>
            </div>
        </section>
    @endif
    <!-- End Hero -->


    <main id="main">
    <meta name="csrf-token" content="{{ csrf_token() }}">

            <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container">

                <div class="section-title">
                    <h2>About</h2>
                </div>
                @if (empty($person))
                    <div class="row">
                        <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                            <h3 class="mb-5">Empty</h3>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-lg-4" data-aos="fade-right">
                            <img src="{{ Storage::url($person->aboutImage) }}" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                            <h3 class="mb-5">{{ $person->domain }}</h3>

                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        <li>
                                            <i class="bi bi-chevron-right"></i>
                                            <strong>Birthday:</strong> <span>{{ $person->birthday }}</span>
                                        </li>
                                        <li>
                                            <i class="bi bi-chevron-right"></i>
                                            <strong>Phone:</strong> <span>{{ $person->phone }}</span>
                                        </li>
                                        <li>
                                            <i class="bi bi-chevron-right"></i> <strong>City:</strong>
                                            <span>{{ $person->city }}, {{ $person->country }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <ul>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong>
                                            <span>{{ $age }}</span>
                                        </li>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong>
                                            <span>{{ $person->degree }}</span>
                                        </li>
                                        <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong>
                                            <span>{{ $person->email }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p style="text-align: justify">{{ $person->presentation }}</p>
                            <div class="row">
                            <div class="col">
                            <!-- Like / Dislike Section -->
                            <livewire:like-dislike />
                            </div>
                            <div class="col">
                            @livewire('average-rating')

                             <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal" style="float: right;">
        Donner ma note
    </button>                        
                            </div>
                        </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- End About Section -->
<!-- =============== Modal for Rating  ======================= -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Donner votre note</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                     <!-- Rate Section -->
                     <livewire:rate-content />
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Valider</button>
                </div>
            </div>
        </div>
    </div>
    <!-- =================== End Modal ====================== -->

        <!-- ======= Skills Section ======= -->
        <section id="skills" class="skills section-bg">
            <div class="container">

                <div class="section-title">
                    <h2>Skills</h2>
                </div>
                @if (empty($skills))
                    <div class="row">
                        <div class="col-lg-4">
                            <div data-aos="fade-up">
                                <h5 class="text-primary text-bold">Empty</h5>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach ($skills as $skill)
                            <div class="col-lg-4">
                                <div data-aos="fade-up">
                                    <h5 class="text-primary text-bold">{{ $skill->title }}</h5>
                                    <ul style="text-align: justify">
                                        @foreach (explode(';', $skill->descriptions) as $desc)
                                            <li>{{ $desc }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <!-- End Skills Section -->

        <!-- ======= Experience Section ======= -->

        <section id="experience" class="resume">
            <div class="container">

                <div class="section-title">
                    <h2>Experience</h2>
                </div>
                @if (empty($experiences))
                    <div class="d-flex-lg justify-content-center" data-aos="fade-up">
                        <div class="resume-item">
                            Empty
                        </div>
                    </div>
                @else
                    @foreach ($experiences as $experience)
                        <div class="d-flex-lg justify-content-center" data-aos="fade-up">
                            <div class="resume-item">
                                <h4>{{ $experience->title }}</h4>
                                <h5>{{ $experience->beginDate }} - {{ $experience->endDate }}</h5>
                                <p><em>{{ $experience->companyName }}, {{ $experience->city }},
                                        {{ $experience->country }}</em></p>
                                <ul style="text-align: justify">
                                    @foreach (explode(';', $experience->descriptions) as $desc)
                                        <li>{{ $desc }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
        <!-- End Experience Section -->

        <!-- ======= Education Section ======= -->
        <section id="education" class="resume section-bg">
            <div class="container">

                <div class="section-title">
                    <h2>Education</h2>
                </div>
                @if (empty($formations))
                    <div class="d-flex-lg justify-content-center" data-aos="fade-up">
                        <div class="resume-item">
                            Empty
                        </div>
                    </div>
                @else
                    @foreach ($formations as $formation)
                        <div class="d-flex-lg justify-content-center" data-aos="fade-up">
                            <div class="resume-item">
                                <h4>{{ $formation->title }}</h4>
                                <h5>{{ $formation->beginDate }} - {{ $formation->endDate }}</h5>
                                <p><em>{{ $formation->schoolName }}, {{ $formation->city }},
                                        {{ $formation->country }}</em></p>
                                <p class="col-lg-8" style="text-align: justify">{{ $formation->descriptions }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>
        <!-- End Education Section -->

        <!-- ======= Certification Section ======= -->
        @if (!empty($certificates))
            <section id="certification" class="contact">
                <div class="container">

                    <div class="section-title">
                        <h2>Certification</h2>
                    </div>

                    <div class="row justify-content-center" data-aos="">
                        @foreach ($certificates as $certificate)
                            <div class="col-lg-5 d-flex align-items-stretch">
                                <div class="info mb-4">
                                    <div class="text-break" style="margin-left: -15%">
                                        <h4>{{ $certificate->title }}</h4>
                                        <p class="text-info" style="font-size: 20px">
                                            {{ $certificate->organizationName }}</p>
                                        <p>{{ $certificate->receiptDate }} | {{ $certificate->city }},
                                            {{ $certificate->country }}</p>

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#myModal{{ $certificate->id }}" style="float: right">
                                            Learn more
                                        </button>
                                        <!-- ===============Modal =======================-->
                                        <div class="modal" id="myModal{{ $certificate->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Certification :
                                                            <span class="text-info h5">{{ $certificate->title }}</span>
                                                        </h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <!-- Modal body -->
                                                    <div class="modal-body"
                                                        style="text-align: justify; margin-right:10%">
                                                        <p>{{ $certificate->descriptions }}</p>
                                                    </div>
                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ===================End Modal===================== -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!-- End Certification Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact @if (!empty($certificates)) section-bg @endif">
            <div class="container" style="margin-bottom: 20%">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p style="text-align: justify">
                        Want to know more about my profile ?
                        Contact me by e-mail or directly by phone !
                    </p>
                </div>

                @if (empty($person))
                    <div class="row" data-aos="fade-in">
                        <h5>Empty</h5>
                    </div>
                @else
                    <div class="row" data-aos="fade-in">

                        <div class="col-lg-8 d-flex align-items-stretch">
                            <div class="info mx-lg-5">
                                <div class="address">
                                    <a href="https://www.google.com/maps/place/{{ $person->city }}" target="_blank"
                                        rel="noopener">
                                        <i class="bi bi-geo-alt"></i>
                                    </a>
                                    <h4>Location:</h4>
                                    <p>{{ $person->city }}, {{ $person->country }}</p>
                                </div>

                                <div class="email">
                                    <a href="mailto:{{ $person->email }}">
                                        <i class="bi bi-envelope"></i>
                                    </a>
                                    <h4>Email:</h4>
                                    <p>{{ $person->email }}</p>
                                </div>

                                <div class="phone">
                                    <a href="tel:{{ $phone }}">
                                        <i class="bi bi-phone"></i>
                                    </a>
                                    <h4>Call:</h4>
                                    <p>{{ $person->phone }}</p>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- End Contact Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Dynamic Portfolio</span></strong>
            </div>
            <div class="credits">
                by <a href="https://bootstrapmade.com/">Djimbalinux</a>
            </div>
        </div>
    </footer>
    <!-- End  Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

   


@endsection
