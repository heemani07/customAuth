<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Travel Explorer</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        /* Header */
        .header-fixed {
            position: fixed;
            top: 0;
            width: 100%;
            background: #ffffff;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .nav-link-custom {
            color: #000;
            font-weight: 500;
        }
        .nav-link-custom:hover,
        .nav-link-active {
            color: #007bff;
        }

        /* Mobile Menu */
        @media (max-width: 992px) {
            #navbarNav {
                background: white;
                padding: 15px;
                border-radius: 10px;
            }
        }

        /* Hero Carousel */
        .hero-slide {
            height: 90vh;
            background-size: cover;
            background-position: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.35);
        }

        .hero-title {
            font-size: 4rem;
        }

        /* Card Truncate */
        .truncate-text {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        footer ul li a {
            color: #fff;
            text-decoration: none;
        }
        footer ul li a:hover {
            text-decoration: underline;
        }
        .destination-img {
    width: 100%;
    height: 250px; /* set equal height */
    object-fit: cover; /* crop beautifully */
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
    </style>

</head>
<body>

<!-- HEADER -->
<header class="header-fixed py-3">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- LOGO -->
        <a href="/" class="d-flex align-items-center">
            <img src="https://raw.githubusercontent.com/mustafadalga/tour-and-travel/master/assets/img/logo.svg"
                 alt="Logo" style="height:45px;">
        </a>

        <!-- NAVIGATION -->
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse text-center" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-lg-4">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom nav-link-active" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link nav-link-custom" href="{{ route('destinations.index') }}">Destinations</a> -->
                         <a class="nav-link nav-link-custom" href="#destinations-section">Packages</a>

                    </li>
                 <li class="nav-item">
                         <a class="nav-link nav-link-custom" href="#reviews-section">Reviews</a>

                    </li>
                    <li class="nav-item">
    <a class="nav-link nav-link-custom" href="#contact-section">Contact</a>
</li>

                </ul>

                <!-- Auth Buttons -->
                <div class="d-flex gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                </div>

            </div>
        </nav>

    </div>
</header>

<!-- Padding below fixed header -->
<div style="margin-top:95px;"></div>

<!-- HERO CAROUSEL -->
<section class="hero-banner mb-5">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-inner">
            @foreach($destinations as $index => $destination)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="hero-slide"
                         style="background-image: url('{{ asset('storage/'.$destination->image) }}');">
                        <div class="hero-overlay"></div>

                        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                            <h1 class="fw-bold hero-title">{{ $destination->name }}</h1>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- POPULAR DESTINATIONS -->
<section class="py-5" id="destinations-section">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Popular Destinations</h2>

        <div class="row g-4">
            @foreach($destinations as $destination)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="{{ asset('storage/' . $destination->image) }}"
     class="card-img-top destination-img"
     alt="{{ $destination->name }}">

                        <div class="card-body">
                            <h5 class="fw-bold">{{ $destination->name }}</h5>
                            <p class="text-muted small">{{ $destination->country }}</p>

                            <p class="truncate-text">
                                {{ Str::limit(strip_tags($destination->description), 120) }}
                            </p>

                            <a href="{{ route('packages.index', $destination->id) }}" class="btn btn-primary btn-sm">
                                View Packages
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- TESTIMONIALS -->
<section class="py-5 bg-light" id="reviews-section">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">What Our Customers Say</h2>

        <div class="row">
            @foreach($testimonials as $testimonial)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <p>{{ $testimonial->message }}</p>
                            <h6 class="fw-bold">{{ $testimonial->name }}</h6>
                            <small class="text-muted">{{ $testimonial->designation }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- TRENDING STORIES -->
<section class="py-5">
    <div class="container">
        <h3 class="fw-bold mb-4">Trending Stories</h3>

        <div class="row g-4">

            @for($i=1; $i<=4; $i++)
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm">
                        <img src="https://raw.githubusercontent.com/mustafadalga/tour-and-travel/master/assets/img/stories/story-{{ $i }}.jpg"
                             class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title">Story Title {{ $i }}</h5>
                            <p class="truncate-text">Sample travel story description...</p>
                            <a href="#" class="text-primary">Read More</a>
                        </div>
                    </div>
                </div>
            @endfor

        </div>

    </div>
</section>
<!-- CONTACT US -->
<section class="py-5 bg-light" id="contact-section">
    <div class="container" style="max-width: 700px;">
        <h2 class="fw-bold text-center mb-4">Contact Us</h2>

        <form action="{{ route('contact.send') }}" method="POST" class="card shadow-sm p-4 bg-white">
            @csrf

            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Your Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" rows="4" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</section>


<!-- FOOTER -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <h5>Top Destinations</h5>
                <ul class="list-unstyled">
                    @foreach($destinations->take(4) as $dest)
                        <li><a href="#">{{ $dest->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-8 text-end">
                <p class="mb-0">&copy; {{ date('Y') }} Travel Explorer. All rights reserved.</p>
            </div>
        </div>

    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
