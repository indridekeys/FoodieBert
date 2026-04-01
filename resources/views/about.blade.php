

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | About Us </title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body>@include('components.loader')
@include('components.header')

<main class="about-page">
    <section class="hero-section about-hero-sub">
        <div class="hero-overlay"></div>
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-subtitle">Our Journey & Vision</span>
                <h1 class="hero-title">
                    The Pulse of <br>
                    <span class="text-cursive">Bertoua's</span> 
                    <span class="text-highlight">Cuisine</span>
                </h1>
                <p class="hero-description">
                    From local street food to fine dining, we are digitizing the flavors of the East Region, one plate at a time.
                </p>
            </div>
        </div>
    </section>

    <section class="why-choose-us" style="background: #fff;">
        <div class="container">
            <div class="section-top">
                <div class="title-group">
                    <span class="text-cursive" style="color: var(--light-red); font-size: 32px;">What We Do</span>
                    <h2 class="section-title">Our <span class="text-highlight">Services</span></h2>
                </div>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <h3>Fast Delivery</h3>
                    <p>Heat-lock technology ensuring your meal arrives as fresh as it left the kitchen.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                    <h3>Table Booking</h3>
                    <p>Skip the queue. Reserve your favorite spot at any Bertoua restaurant in seconds.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-concierge-bell"></i></div>
                    <h3>Premium Catering</h3>
                    <p>Professional food services for your corporate events and private celebrations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                    <h3>Business Support</h3>
                    <p>We provide local restaurants with data tools to grow their brand and reach.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-foods" style="padding: 60px 0;">
        <div class="container">
            <div class="section-top">
                <h2 class="section-title">Signature <span class="text-highlight">Plates</span></h2>
            </div>
            <div class="restaurant-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                @foreach(['Kondre', 'Grilled Fish', 'Ndole'] as $dish)
                <div class="gallery-card-mini">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80" alt="{{ $dish }}">
                    <div class="gallery-mini-overlay">
                        <span class="price-tag">From 2,500 FCFA</span>
                        <h4>{{ $dish }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="portal-section dark-theme">
        <div class="container">
            <div class="section-top">
                <div class="title-group">
                    <h2 class="section-title" style="color:white;">The <span class="text-highlight">Team</span></h2>
                </div>
            </div>
            <div class="swiper teamSwiper">
                <div class="swiper-wrapper">
                    @foreach([['name'=>'Bertin N.', 'role'=>'CEO'], ['name'=>'Sarah M.', 'role'=>'COO'], ['name'=>'Paul K.', 'role'=>'CTO']] as $member)
                    <div class="swiper-slide">
                        <div class="team-card-small">
                            <div class="team-img-small">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80" alt="">
                            </div>
                            <div class="team-meta">
                                <h4>{{ $member['name'] }}</h4>
                                <span>{{ $member['role'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <section class="contact-footer">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <h3>Get in Touch</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Bertoua, East Region, Cameroon</p>
                    <p><i class="fas fa-phone"></i> +237 683 067 844</p>
                    <p><i class="fas fa-envelope"></i> contactfoodiebert@gmail.com</p>
                </div>
                <div class="contact-social">
                    <h3>Follow Us</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


@include('components.footer')
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
    new Swiper(".teamSwiper", {
        slidesPerView: 1,
        spaceBetween: 20,
        pagination: { el: ".swiper-pagination", clickable: true },
        breakpoints: { 768: { slidesPerView: 3 } }
    });
</script>
</body>
</html>