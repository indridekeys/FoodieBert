<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">

<header class="foodie-header" id="mainHeader">
    <a href="{{ route('home') }}" class="header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
        <h1 class="logo-text">
            <span class="logo-white">Foodie</span><span class="logo-yellow">Bert</span>
        </h1>
    </a>

    <nav class="nav-container">
        <ul class="nav-menu">
            <li><a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
            
            <li class="dropdown-trigger">
                <a href="#" class="nav-link">
                    <i class="fas fa-utensils"></i> Pages 
                    <i class="fas fa-chevron-down" style="font-size:10px;margin-left:5px;"></i>
                </a>
                <div class="mega-dropdown">
                    <ul class="dropdown-list">
                        <li><a href="{{ route('restaurants') }}"><i class="fas fa-store"></i> Restaurants</a></li>
                        <li><a href="#"><i class="fas fa-fire"></i> Hot Deals</a></li>
                        <li><a href="#"><i class="fas fa-user-chef"></i> Chefs Special</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <div class="auth-group">
        <a href="{{ url('/login') }}" class="btn-login">Login</a>
        <a href="{{ url('/register') }}" class="btn-register">Register</a>
    </div>

    <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </div>
</header>

<div class="mobile-nav" id="mobileNav">
    <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
    <a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
    <a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
    <a href="{{ route('restaurants') }}" class="nav-link"><i class="fas fa-utensils"></i> Restaurants</a>
    <a href="{{ url('/login') }}" class="nav-link"><i class="fas fa-user"></i> Login</a>
    <a href="{{ url('/register') }}" class="btn-register" style="text-align:center; color: white;">Register</a>
</div>

<script>
    const header = document.getElementById('mainHeader');
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobileNav');

    window.addEventListener('scroll', () => {
        header.classList.toggle('scrolled', window.scrollY > 40);
    });

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobileNav.classList.toggle('active');
    });

    // Close mobile nav when clicking a link
    document.querySelectorAll('.mobile-nav .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileNav.classList.remove('active');
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1100) {
            hamburger.classList.remove('active');
            mobileNav.classList.remove('active');
        }
    });
</script>