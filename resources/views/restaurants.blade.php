@include('components.loader')
@include('components.header')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .simple-page-wrapper { background: #fafafa; font-family: 'Plus Jakarta Sans', sans-serif; color: #2d3436; }

    .hero-banner {
        height: 50vh;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop');
        background-size: cover; background-position: center;
        display: flex; align-items: center; justify-content: center; text-align: center; color: white;
    }

    .restaurant-container { max-width: 1200px; margin: -50px auto 80px; padding: 0 20px; position: relative; z-index: 10; }

    .search-bar-wrapper {
        background: white; padding: 10px; border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 40px;
    }

    .search-bar-wrapper input { width: 100%; padding: 15px 25px; border: none; outline: none; font-size: 1.1rem; }

    .restaurant-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px; }

    .res-card {
        background: white; border-radius: 20px; overflow: hidden;
        transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05);
    }

    .res-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

    .res-image { height: 230px; width: 100%; object-fit: cover; }

    .res-info { padding: 25px; }

    .res-category { font-size: 0.75rem; font-weight: 800; color: #e67e22; text-transform: uppercase; letter-spacing: 1px; }

    .res-name { font-size: 1.5rem; font-weight: 700; margin: 5px 0 15px 0; color: #1a1a1a; }

    .btn-group { display: flex; gap: 12px; }

    /* Updated to full width since it is the only button now */
    .btn-main {
        flex: 1; padding: 12px; text-align: center; background: #1a1a1a; color: white;
        text-decoration: none; border-radius: 12px; font-weight: 600; transition: 0.3s;
    }

    .btn-main:hover { background: #e67e22; border-color: #e67e22; color: white; }
</style>

<div class="simple-page-wrapper">
    
    <section class="hero-banner">
        <div class="animate__animated animate__fadeInUp">
            <h1 style="font-size: 4rem; font-weight: 800; margin: 0;">Bertoua Guide</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">The best flavors in the city, just a click away.</p>
        </div>
    </section>

    <div class="restaurant-container">
        <div class="search-bar-wrapper">
            <input type="text" id="resSearch" placeholder="Search by name or category...">
        </div>

        <div class="restaurant-grid">
            @foreach($restaurants as $res)
            <div class="res-card animate__animated animate__fadeIn">
                <img src="{{ $res->image_url ? asset('storage/' . $res->image_url) : 'https://via.placeholder.com/400x250' }}" class="res-image">
                
                <div class="res-info">
                    <span class="res-category">{{ $res->category }}</span>
                    <h3 class="res-name">{{ $res->name }}</h3>
                    
                    <div class="btn-group">
                        <a href="{{ route('restaurants.menu', $res->id) }}" class="btn-main">
                            View Menu & Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.getElementById('resSearch').addEventListener('input', function(e) {
        let val = e.target.value.toLowerCase();
        let cards = document.querySelectorAll('.res-card');
        cards.forEach(card => {
            card.style.display = card.innerText.toLowerCase().includes(val) ? 'block' : 'none';
        });
    });
</script>

@include('components.footer')