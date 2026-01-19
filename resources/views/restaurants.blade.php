<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Map | FoodieBert Gastronomy</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Pinyon+Script&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        :root {
            --onyx: #121212;
            --gold: #d4af37;
            --gold-soft: rgba(212, 175, 55, 0.1);
            --bg-silk: #faf9f6;
            --white: #ffffff;
            --transition: all 0.7s cubic-bezier(0.19, 1, 0.22, 1);
            --radius-lg: 40px; /* New design token for curviness */
            --radius-md: 20px;
        }

        body, html { 
            margin: 0; 
            padding: 0; 
            background: var(--bg-silk); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: var(--onyx);
            overflow-x: hidden;
        }

        .page-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* --- COMPONENT HARMONIZATION (STRICT CURVY OVERRIDES) --- */
        /* Increased specificity to ensure logos and branding elements stay curvy */
        .include-wrap img[class*="logo"], 
        .include-wrap .logo-container,
        .include-wrap .logo,
        .include-wrap .brand-logo,
        .include-wrap [class*="Logo"] img,
        .include-wrap .avatar,
        .include-wrap button,
        .include-wrap .nav-link {
            border-radius: var(--radius-lg) !important;
            overflow: hidden !important; /* Ensures the image doesn't bleed out of curves */
        }

        /* Sidebar and Header container curves */
        .include-wrap .sidebar-card,
        .include-wrap .header-inner,
        .include-wrap .footer-logo-wrap {
            border-radius: var(--radius-md) !important;
        }

        /* --- HERO IMAGE SECTION --- */
        .editorial-hero {
            position: relative;
            height: 95vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: var(--onyx);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.65;
            transform: scale(1.1);
            transition: transform 10s linear;
        }

        .hero-vignette {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, transparent 20%, rgba(0,0,0,0.4) 100%);
            z-index: 1;
        }

        .editorial-hero:hover .hero-bg {
            transform: scale(1);
        }

        .hero-overlay {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            padding: 0 5%;
        }

        .hero-label {
            font-family: 'Pinyon Script', cursive;
            font-size: clamp(2.2rem, 5vw, 4rem);
            color: var(--gold);
            margin-bottom: 15px;
            display: block;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .hero-overlay h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3.5rem, 12vw, 8.5rem);
            line-height: 0.9;
            font-weight: 400;
            margin: 0;
            letter-spacing: -3px;
            text-transform: capitalize;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .hero-scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
            color: var(--white);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            opacity: 0.8;
        }

        .scroll-line {
            width: 1px;
            height: 80px;
            background: linear-gradient(to bottom, var(--gold), transparent);
            animation: growLine 2s infinite alternate ease-in-out;
        }

        @keyframes growLine {
            from { height: 40px; transform: scaleY(0.8); opacity: 0.3; }
            to { height: 80px; transform: scaleY(1); opacity: 1; }
        }

        /* --- STICKY NAV --- */
        .nav-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(250, 249, 246, 0.95);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .category-nav {
            display: flex;
            justify-content: center;
            padding: 25px 0;
            gap: 40px;
        }

        .cat-btn {
            background: none;
            border: none;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999;
            cursor: pointer;
            transition: var(--transition);
            padding: 8px 0;
            position: relative;
        }

        .cat-btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .cat-btn.active { color: var(--onyx); }
        .cat-btn.active::after { width: 100%; }
        .cat-btn:hover { color: var(--gold); }

        /* --- CARD GRID --- */
        .discovery-grid {
            padding: 100px 8%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 80px 60px;
            max-width: 1800px;
            margin: 0 auto;
        }

        .res-card {
            background: var(--white);
            padding: 25px;
            transition: var(--transition);
            text-decoration: none;
            color: inherit;
            box-shadow: 0 15px 45px rgba(0,0,0,0.03);
            position: relative;
            border: 1px solid rgba(0,0,0,0.02);
            border-radius: var(--radius-md); 
            overflow: hidden;
        }

        .res-card:hover {
            transform: translateY(-20px);
            box-shadow: 0 40px 80px rgba(0,0,0,0.08);
            border-color: var(--gold-soft);
        }

        .image-container {
            width: 100%;
            aspect-ratio: 1/1.2;
            overflow: hidden;
            position: relative;
            background: var(--onyx);
            border-radius: calc(var(--radius-md) - 10px); 
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 2s cubic-bezier(0.19, 1, 0.22, 1);
            opacity: 0.9;
        }

        .res-card:hover .image-container img {
            transform: scale(1.1);
            opacity: 1;
        }

        .card-body {
            padding: 40px 15px 15px;
            text-align: center;
        }

        .card-category {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 4px;
            display: block;
            margin-bottom: 15px;
        }

        .card-body h3 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin: 0 0 18px;
            font-weight: 400;
            color: var(--onyx);
            line-height: 1.1;
        }

        .card-body p {
            font-size: 0.9rem;
            color: #777;
            line-height: 2;
            margin-bottom: 30px;
            height: 4em;
            overflow: hidden;
        }

        .card-link {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--onyx);
            display: inline-flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .card-link::after {
            content: '';
            width: 40px;
            height: 1px;
            background: var(--gold);
            transition: var(--transition);
        }

        .res-card:hover .card-link {
            color: var(--gold);
        }

        .res-card:hover .card-link::after {
            width: 65px;
        }

        /* --- COMPONENT ISOLATION --- */
        .include-wrap { all: revert; }

        @media (max-width: 1024px) {
            .discovery-grid { grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
        }

        @media (max-width: 768px) {
            .discovery-grid { grid-template-columns: 1fr; padding: 60px 5%; }
            .category-nav { gap: 20px; overflow-x: auto; padding: 20px 5%; justify-content: flex-start; }
            .cat-btn { font-size: 0.7rem; }
            .editorial-hero { height: 70vh; }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="include-wrap">
        @include('components.sidebar')
    </div>

    <div class="main-content">
        <div class="include-wrap">
            @include('components.header')
        </div>

        <!-- HERO SECTION -->
        <section class="editorial-hero">
            <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2000" class="hero-bg" alt="Luxury Dining Room">
            <div class="hero-vignette"></div>
            <div class="hero-overlay">
                <span class="hero-label">The Gastronomy Map</span>
                <h1>Epicurean<br>Dimensions</h1>
            </div>
            <div class="hero-scroll-indicator">
                <span>Discover More</span>
                <div class="scroll-line"></div>
            </div>
        </section>

        <!-- CATEGORY NAVIGATION -->
        <div class="nav-wrapper">
            <nav class="category-nav">
                <button class="cat-btn active" onclick="filterRes('all', event)">All Establishments</button>
                <button class="cat-btn" onclick="filterRes('fine-dining', event)">Fine Dining</button>
                <button class="cat-btn" onclick="filterRes('eateries', event)">Eateries</button>
                <button class="cat-btn" onclick="filterRes('cafes', event)">Cafés</button>
                <button class="cat-btn" onclick="filterRes('snack-bar', event)">Snacks & Bars</button>
            </nav>
        </div>

        <main class="discovery-grid" id="discoveryGrid">
            @forelse($restaurants as $res)
                <a href="{{ route('restaurants.show', $res->id) }}" class="res-card restaurant-item" data-category="{{ Str::slug($res->category) }}">
                    <div class="image-container">
                        <img src="{{ $res->image_url ? asset('storage/'.$res->image_url) : 'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=800' }}" alt="{{ $res->name }}">
                    </div>
                    <div class="card-body">
                        <span class="card-category">{{ $res->category }} • {{ $res->location }}</span>
                        <h3>{{ $res->name }}</h3>
                        <p>{{ Str::limit($res->description, 100) }}</p>
                        <span class="card-link">View Details</span>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1/-1; padding: 150px 0; text-align: center;">
                    <span class="hero-label">Uncharted</span>
                    <p style="font-family: 'Playfair Display', serif; font-size: 1.8rem; opacity: 0.3;">The culinary archives are currently empty.</p>
                </div>
            @endforelse
        </main>

        <div class="include-wrap">
            @include('components.footer')
        </div>
    </div>
</div>

<script>
    function filterRes(category, event) {
        document.querySelectorAll('.cat-btn').forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');
        
        const items = document.querySelectorAll('.restaurant-item');
        const grid = document.getElementById('discoveryGrid');
        
        grid.style.opacity = '0';
        grid.style.transform = 'translateY(15px)';
        
        setTimeout(() => {
            items.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                if (category === 'all' || itemCat === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            grid.style.opacity = '1';
            grid.style.transform = 'translateY(0)';
        }, 400);
    }

    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const heroBg = document.querySelector('.hero-bg');
        const heroOverlay = document.querySelector('.hero-overlay');
        
        if(heroBg) {
            heroBg.style.transform = `scale(${1.1 - (scrolled * 0.0001)}) translateY(${scrolled * 0.25}px)`;
        }
        if(heroOverlay) {
            heroOverlay.style.opacity = 1 - (scrolled / 700);
            heroOverlay.style.transform = `translateY(${scrolled * 0.1}px)`;
        }
    });

    document.getElementById('discoveryGrid').style.transition = 'all 0.6s cubic-bezier(0.19, 1, 0.22, 1)';
</script>

</body>
</html>