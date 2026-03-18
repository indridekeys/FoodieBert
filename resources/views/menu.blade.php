@include('components.loader')
@include('components.header')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@300;400;600;700&family=Great+Vibes&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #0a192f;
        --accent-gold: #C5A059;
        --light-yellow: #fdf5e6;
        --light-red: #e74c3c;
        --dark-red: #b03a2e;
        --text-gray: #4a4a4a;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--light-yellow);
        color: var(--primary-blue);
        margin: 0;
    }

    /* --- HERO SECTION --- */
    .hero-banner {
        height: 100vh;
        background: linear-gradient(rgba(10, 25, 47, 0.6), rgba(10, 25, 47, 0.6)), 
                    url('{{ asset("storage/" . $restaurant->image_url) }}') center/cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        clip-path: polygon(0 0, 100% 0, 100% 95%, 50% 100%, 0 95%);
    }

    .hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3.5rem, 8vw, 6rem);
        color: white;
        margin-bottom: 0;
        text-transform: uppercase;
        letter-spacing: 4px;
    }

    .hero-content p {
        font-family: 'Great Vibes', cursive;
        color: var(--accent-gold);
        font-size: 2.5rem;
    }

    /* --- RIBBON ELEMENT --- */
    .ribbon {
        background: linear-gradient(45deg, var(--dark-red), var(--light-red));
        color: white;
        padding: 10px 40px;
        position: absolute;
        bottom: 50px;
        right: 0;
        font-weight: 800;
        letter-spacing: 2px;
        box-shadow: -5px 5px 15px rgba(0,0,0,0.3);
    }

    /* --- ABOUT SECTION --- */
    .section-padding { padding: 100px 10%; }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
    }

    .gold-title {
        color: var(--accent-gold);
        font-weight: 700;
        letter-spacing: 2px;
        display: block;
        margin-bottom: 10px;
    }

    .playfair-heading {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        margin-bottom: 30px;
    }

    /* --- MENU SECTION --- */
    .menu-section {
        background: var(--primary-blue);
        color: white;
        border-top: 5px solid var(--accent-gold);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin-top: 50px;
    }

    .menu-item {
        border-bottom: 1px dashed rgba(197, 160, 89, 0.3);
        padding-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .menu-item h4 { margin: 0; font-family: 'Playfair Display'; font-size: 1.4rem; color: var(--accent-gold); }
    .menu-price { color: var(--light-red); font-weight: 800; }

    /* --- GALLERY SECTION --- */
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 250px;
        gap: 15px;
        padding: 15px;
    }

    @media (max-width: 768px) {
        .gallery-container { grid-template-columns: repeat(2, 1fr); }
    }

    .gallery-item { overflow: hidden; position: relative; cursor: pointer; }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-item:nth-child(1) { grid-column: span 2; grid-row: span 2; }

    /* --- TEAM SECTION --- */
    .team-card {
        background: white;
        padding: 0;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid #eee;
    }

    .team-img { height: 350px; width: 100%; object-fit: cover; }
    .team-info { padding: 25px; }

    /* --- BLOG SECTION --- */
    .blog-card {
        background: #fff;
        border-left: 5px solid var(--dark-red);
        transition: 0.3s;
        height: 100%;
    }
    .blog-card:hover { transform: translateY(-10px); }

    .btn-gold {
        background: var(--accent-gold);
        color: white;
        padding: 15px 40px;
        border: none;
        text-decoration: none;
        font-weight: 800;
        display: inline-block;
        transition: 0.3s;
    }
    .btn-gold:hover { background: var(--primary-blue); border: 1px solid var(--accent-gold); }

</style>

<div class="restaurant-master">

    <section class="hero-banner">
        <div class="hero-content animate__animated animate__fadeInUp">
            <p>Welcome to</p>
            <h1>{{ $restaurant->name }}</h1>
            <div style="width: 100px; height: 3px; background: var(--accent-gold); margin: 20px auto;"></div>
            <a href="#menu" class="btn-gold">VIEW TODAY'S MENU</a>
        </div>
        <div class="ribbon">TOP RATED BERTOUA 2026</div>
    </section>

    <section class="section-padding">
        <div class="about-grid">
            <div class="animate__animated animate__fadeInLeft">
                <span class="gold-title">OUR STORY</span>
                <h2 class="playfair-heading">A Culinary Journey Since {{ $restaurant->created_at->format('Y') }}</h2>
                <p style="line-height: 2; font-size: 1.1rem; color: var(--text-gray);">
                    {{ $restaurant->description }}
                </p>
            </div>
            <div class="animate__animated animate__fadeInRight" style="position: relative;">
                <img src="{{ asset('storage/' . $restaurant->image_url) }}" style="width: 100%; border: 20px solid white; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
                <div style="position: absolute; bottom: -30px; left: -30px; background: var(--primary-blue); color: white; padding: 40px; width: 200px; text-align: center;">
                    <span style="font-size: 3rem; font-weight: 900; display: block;">12+</span>
                    <span style="font-size: 0.8rem; letter-spacing: 2px;">YEARS EXPERIENCE</span>
                </div>
            </div>
        </div>
    </section>

    <section id="menu" class="section-padding menu-section">
        <div style="text-align: center; margin-bottom: 60px;">
            <span class="gold-title">THE CUISINE</span>
            <h2 class="playfair-heading" style="color: white;">Chef's Recommendations</h2>
        </div>

        <div class="menu-grid">
            @forelse($restaurant->menus as $item)
                <div class="menu-item">
                    <div>
                        <h4>{{ $item->dish_name }}</h4>
                        <small style="color: #888;">{{ $item->ingredients }}</small>
                    </div>
                    <div class="menu-price">${{ $item->price }}</div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; opacity: 0.5;">Our seasonal menu is being updated.</p>
            @endforelse
        </div>
        
        <div style="text-align: center; margin-top: 60px;">
            <a href="#" class="btn-gold">DOWNLOAD FULL PDF MENU</a>
        </div>
    </section>

    <section class="section-padding">
        <div style="text-align: center; margin-bottom: 50px;">
            <span class="gold-title">VISUAL FEAST</span>
            <h2 class="playfair-heading">Inside {{ $restaurant->name }}</h2>
        </div>
        <div class="gallery-container">
            {{-- Check both possible relationship names --}}
            @forelse($restaurant->galleries ?? $restaurant->gallery ?? [] as $photo)
                <div class="gallery-item">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Gallery">
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; color: var(--text-gray);">Gallery coming soon.</p>
            @endforelse
        </div>
    </section>

    <section class="section-padding" style="background: #fff;">
        <div style="text-align: center; margin-bottom: 50px;">
            <span class="gold-title">THE MASTERS</span>
            <h2 class="playfair-heading">Meet Our Team</h2>
        </div>
        <div class="about-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            @forelse($restaurant->staff as $member)
                <div class="team-card">
                    <img src="{{ $member->photo ? asset('storage/' . $member->photo) : 'https://ui-avatars.com/api/?name='.urlencode($member->name).'&background=001f3f&color=D4AF37' }}" class="team-img">
                    <div class="team-info">
                        <h3 style="font-family: 'Playfair Display'; margin: 0;">{{ $member->name }}</h3>
                        <span style="color: #D4AF37; font-size: 0.9rem; font-weight: 700;">{{ $member->position }}</span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; color: #D4AF37; opacity: 0.6;">
                    Our team of culinary masters is preparing for your arrival.
                </p>
            @endforelse
        </div>
    </section>

    <section class="section-padding">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
            <div>
                <span class="gold-title">FROM THE KITCHEN</span>
                <h2 class="playfair-heading">Latest Stories & Recipes</h2>
            </div>
            <a href="#" style="color: var(--primary-blue); font-weight: 800; text-decoration: none;">VIEW ALL POSTS →</a>
        </div>
        
        <div class="menu-grid">
            @forelse($restaurant->posts ?? [] as $post)
                <div class="blog-card">
                    <div style="padding: 30px;">
                        <small style="color: var(--accent-gold); font-weight: 800;">{{ $post->created_at->format('M d, Y') }}</small>
                        <h3 style="font-family: 'Playfair Display'; margin: 15px 0;">{{ $post->title }}</h3>
                        <p style="color: var(--text-gray); font-size: 0.95rem;">{{ Str::limit($post->content, 100) }}</p>
                        <a href="#" style="color: var(--light-red); text-decoration: none; font-weight: 700;">Read More</a>
                    </div>
                </div>
            @empty
                <div class="col-12" style="text-align: center; padding: 40px; border: 1px dashed #ccc; grid-column: 1/-1;">
                    <p style="color: var(--text-gray);">Check back soon for new stories and updates!</p>
                </div>
            @endforelse
        </div>
    </section>

</div>

@include('components.footer')