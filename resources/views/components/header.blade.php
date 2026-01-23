
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">


<style>
    /* Status Dot Styling */
    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2px solid #fff;
        z-index: 2;
    }
    .status-verified { background-color: #16a34a; } /* Green */
    .status-unverified { background-color: #dc2626; } /* Red */
    
    /* Ensure images fill the circle perfectly */
    .user-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@auth
    @php
        /** * Logic to handle different column names across roles
         * Super Admin uses 'profile_photo_path'
         * Regular Users use 'picture'
         */
        $userPhoto = Auth::user()->profile_photo_path ?? Auth::user()->picture;
        $avatarUrl = $userPhoto 
            ? asset('storage/' . $userPhoto) 
            : "https://ui-avatars.com/api/?name=" . urlencode(Auth::user()->name) . "&background=0a192f&color=C5A059";
    @endphp
@endauth

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
        @guest
            <a href="{{ url('/login') }}" class="btn-login">Login</a>
            <a href="{{ url('/register') }}" class="btn-register">Register</a>
        @endguest

        @auth
            <a href="{{ route('login') }}" class="user-profile-link" title="Profile">
                <div class="avatar-wrapper">
                    <div class="user-avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid #C5A059; background: #0a192f;">
                        <img src="{{ $avatarUrl }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <span class="status-indicator {{ Auth::user()->is_verified ? 'status-verified' : 'status-unverified' }}"></span>
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" style="margin-left: 15px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#C5A059; cursor:pointer; font-size: 1.2rem;" title="Logout">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
        @endauth
    </div>

    <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </div>
</header>

<div class="mobile-nav" id="mobileNav">
    @auth
        <div class="mobile-profile-section" style="padding: 20px; display: flex; align-items: center; background: rgba(10, 25, 47, 0.05); border-bottom: 1px solid rgba(197, 160, 89, 0.2);">
            <div class="avatar-wrapper">
                <div class="user-avatar-circle" style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; border: 2px solid #C5A059; background: #0a192f;">
                    <img src="{{ $avatarUrl }}" alt="{{ Auth::user()->name }}">
                </div>
                <span class="status-indicator {{ Auth::user()->is_verified ? 'status-verified' : 'status-unverified' }}" style="width:12px; height:12px;"></span>
            </div>
            <div class="mobile-user-info" style="margin-left: 15px;">
                <span style="font-weight:600; display: block; color: #0a192f;">{{ Auth::user()->name }}</span>
                <small style="color: #C5A059; font-weight: bold; text-transform: uppercase;">{{ str_replace('_', ' ', Auth::user()->role) }}</small>
            </div>
        </div>
    @endauth

    <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
    <a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
    <a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
    <a href="{{ route('restaurants') }}" class="nav-link"><i class="fas fa-utensils"></i> Restaurants</a>
    
    @guest
        <a href="{{ url('/login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
        <a href="{{ url('/register') }}" class="btn-register" style="text-align:center; color: white; margin: 10px 20px;">Register</a>
    @endguest

    @auth
    <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-user-circle"></i> View Dashboard</a>
    <form method="POST" action="{{ route('logout') }}" style="padding: 0 20px;">
        @csrf
        <button type="submit" class="nav-link" style="background:none; border:none; width:100%; text-align:left; cursor:pointer; color: #dc2626;">
            <i class="fas fa-power-off"></i> Logout
        </button>
    </form>
    @endauth
</div>

<script>
    window.addEventListener('scroll', function() {
        const header = document.getElementById('mainHeader');
        if (header) {
            window.scrollY > 50 ? header.classList.add('scrolled') : header.classList.remove('scrolled');
        }
    });

    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobileNav');
    if(hamburger && mobileNav) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            mobileNav.classList.toggle('active');
        });
    }
</script>