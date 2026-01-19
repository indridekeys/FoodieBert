<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | Home</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

   
    <x-header />

    <main>
        <section class="hero" id="home" style="background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.2)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center;">
            <div class="hero-content reveal">
                <span class="label font-curly" style="font-size: 2.5rem; text-transform: none; letter-spacing: normal;">The Rising Sun City</span>
                <h2 class="font-serif">Experience Bertoua <br> Through Taste</h2>
                <p>Navigating the rich culinary landscape of Cameroon's Rising Sun city, from local heritage to modern refinement.</p>
                <div class="hero-btns">
                    <a href="#locations" class="btn btn-primary">Find a Restaurant</a>
                    <a href="#about" class="btn btn-outline" style="border-color: white; color: white;">Our Story</a>
                </div>
            </div>
        </section>

        <section id="about" style="background: white; padding: 100px 10%;">
            <div class="story-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
                <div class="story-img reveal">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8degMhB-kpdvb-Lj_HCz1FK-_HJKE8Ei4WQ&s" alt="Chef in Bertoua" style="width: 100%; border-radius: 15px; box-shadow: 20px 20px 0px var(--accent-dark);">
                </div>
                <div class="reveal">
                    <span class="label" style="color: var(--accent-dark);">Since 1994</span>
                    <h3 class="font-serif" style="font-size: 3rem; margin: 20px 0;">Our Legacy in the East</h3>
                    <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 20px;">
                        L'Éclat began as a humble kitchen in the heart of Bertoua. We grew alongside the city, witnessing its transformation while remaining dedicated to the traditional flavors of the East Region.
                    </p>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        Today, we serve as a bridge between ancestral Cameroonian recipes and the sophisticated techniques of global gastronomy, ensuring Bertoua remains a destination for food lovers.
                    </p>
                </div>
            </div>
        </section> 
<section id="portal" style="background: #fff5f7; padding: 120px 0; overflow: hidden; border-top: 1px solid rgba(0,0,0,0.03);">
    <div class="portal-tabs reveal" style="display: flex; justify-content: center; gap: 4rem; margin-bottom: 60px;">
        <button class="portal-tab-btn font-curly active" data-target="restaurants" style="background: none; border: none; color: #04120c; font-size: 2.2rem; cursor: pointer; opacity: 1; transition: 0.4s; position: relative;">
            Restaurants
            <span class="active-dot" style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 6px; height: 6px; background: #04120c; border-radius: 50%;"></span>
        </button>
        <button class="portal-tab-btn font-curly" data-target="couriers" style="background: none; border: none; color: #04120c; font-size: 2.2rem; cursor: pointer; opacity: 0.4; transition: 0.4s;">
            Couriers
        </button>
        <button class="portal-tab-btn font-curly" data-target="account" style="background: none; border: none; color: #04120c; font-size: 2.2rem; cursor: pointer; opacity: 0.4; transition: 0.4s;">
            Account
        </button>
    </div>

    <div class="portal-content-area reveal" style="max-width: 1200px; margin: 0 auto; padding: 0 5%; position: relative; min-height: 500px;">
        
        <div class="portal-view active" id="restaurants" style="transition: all 0.6s ease-in-out;">
            <div class="portal-card" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; background: #ffffff; padding: 60px; border-radius: 4px; box-shadow: 0 30px 60px rgba(4, 18, 12, 0.04); border: 1px solid rgba(4, 18, 12, 0.02);">
                <div>
                    <span class="label" style="color: #04120c; opacity: 0.5; letter-spacing: 2px;">LOCAL NETWORK</span>
                    <h3 class="font-serif" style="margin-bottom: 2rem; color: #04120c; font-size: 3rem; line-height: 1.1;">The Guild of Flavor</h3>
                    <p style="color: #555; margin-bottom: 2.5rem; line-height: 1.9; font-size: 1.15rem;">
                        A curated selection of the East Region's finest sister establishments. From colonial heritage bistros to modern gardens, explore the Bertoua hospitality map.
                    </p>
                    <a href="#locations" class="btn btn-primary" style="background: #04120c; color: #ffffff; padding: 18px 45px; text-decoration: none; display: inline-block; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; border: 1px solid #04120c; transition: 0.3s;">Browse Locations</a>
                </div>
                <div class="dish-img" style="height: 450px; overflow: hidden; border-radius: 2px; position: relative;">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=2070&auto=format&fit=crop" alt="Restaurant Interior" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <div class="portal-view" id="couriers" style="display: none; opacity: 0; transform: translateY(10px); transition: all 0.6s ease-in-out;">
            <div class="portal-card" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; background: #ffffff; padding: 60px; border-radius: 4px; box-shadow: 0 30px 60px rgba(4, 18, 12, 0.04); border: 1px solid rgba(4, 18, 12, 0.02);">
                <div>
                    <span class="label" style="color: #04120c; opacity: 0.5; letter-spacing: 2px;">WHITE GLOVE SERVICE</span>
                    <h3 class="font-serif" style="margin-bottom: 2rem; color: #04120c; font-size: 3rem; line-height: 1.1;">City Delivery</h3>
                    <p style="color: #555; margin-bottom: 2.5rem; line-height: 1.9; font-size: 1.15rem;">
                        Our private couriers navigate Bertoua with precision. Your Kwem and Mbol are transported in climate-controlled vessels to ensure perfection at your doorstep.
                    </p>
                    <a href="#" class="btn btn-primary" style="background: #04120c; color: #ffffff; padding: 18px 45px; text-decoration: none; display: inline-block; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem; border: 1px solid #04120c;">Track My Order</a>
                </div>
                <div class="dish-img" style="height: 450px; overflow: hidden; border-radius: 2px;">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070&auto=format&fit=crop" alt="Delivery" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>

        <div class="portal-view" id="account" style="display: none; opacity: 0; transform: translateY(10px); transition: all 0.6s ease-in-out;">
            <div class="portal-card" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; background: #ffffff; padding: 60px; border-radius: 4px; box-shadow: 0 30px 60px rgba(4, 18, 12, 0.04); border: 1px solid rgba(4, 18, 12, 0.02);">
                <div>
                    <span class="label" style="color: #04120c; opacity: 0.5; letter-spacing: 2px;">ELITE MEMBERSHIP</span>
                    <h3 class="font-serif" style="margin-bottom: 2rem; color: #04120c; font-size: 3rem; line-height: 1.1;">Mokolo Lounge</h3>
                    <p style="color: #555; margin-bottom: 2.5rem; line-height: 1.9; font-size: 1.15rem;">
                        Manage your Bertoua reservations, access exclusive "After-Harvest" menu previews, and review your private chef history.
                    </p>
                    <div style="display: flex; gap: 1.5rem;">
                        <a href="#" class="btn btn-primary" style="background: #04120c; color: #ffffff; padding: 18px 45px; text-decoration: none; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem;">Sign In</a>
                        <a href="#" class="btn btn-outline" style="border: 1px solid #04120c; color: #04120c; padding: 18px 45px; text-decoration: none; text-transform: uppercase; letter-spacing: 2px; font-size: 0.85rem;">Join</a>
                    </div>
                </div>
                <div class="dish-img" style="height: 450px; overflow: hidden; border-radius: 2px;">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=2070&auto=format&fit=crop" alt="Account" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

       

        <section class="map-section" id="locations">
            <div class="reveal" style="text-align: center; margin-bottom: 4rem;">
                <span class="label">Interactive Guide</span>
                <h3 class="font-serif">Real Locations in Bertoua</h3>
            </div>

            <div class="map-container reveal">
                <div class="map-sidebar">
                    <div class="search-box" style="margin-bottom: 1.5rem;">
                        <input type="text" id="mapSearch" placeholder="Filter Bertoua restaurants..." 
                            style="width: 100%; padding: 1.2rem; border-radius: 12px; border: 1px solid rgba(176, 141, 87, 0.3); background: rgba(255,255,255,0.05); color: white; outline: none;">
                    </div>

                    <div class="location-list" id="restaurant-list">
                        <div class="location-item active" onclick="updateMap(this, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.2415136868296!2d13.684155999999999!3d4.586617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10f799868d2204ab%3A0xc813f2f25a481036!2sBH%20Apero%20Club!5e0!3m2!1sen!2scm!4v1715424000000!5m2!1sen!2scm')">
                            <h4>BH Apero Club</h4>
                            <p>Avenue Commerciale, Bertoua</p>
                        </div>
                        
                        <div class="location-item" onclick="updateMap(this, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.241!2d13.685!3d4.587!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10f7993e3d071e3f%3A0xe5334dff0a783870!2sRestaurant%20La%20Petite%20Pygm%C3%A9e!5e0!3m2!1sen!2scm!4v1715424000000!5m2!1sen!2scm')">
                            <h4>La Petite Pygmée</h4>
                            <p>Rue 876, Bertoua</p>
                        </div>

                        <div class="location-item" onclick="updateMap(this, 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.2!2d13.682!3d4.585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10f79bba97b7a767%3A0x5030430f3b438b!2sLe%20D%C3%A9lice%20Sucr%C3%A9%20Sal%C3%A9!5e0!3m2!1sen!2scm!4v1715424000000!5m2!1sen!2scm')">
                            <h4>Le Délice Sucré Salé</h4>
                            <p>N1 Rue Goliké Fabien, Bertoua</p>
                        </div>
                    </div>
                </div>
                
                <div class="map-visual">
                    <iframe id="bertoua-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.2415136868296!2d13.684155999999999!3d4.586617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10f799868d2204ab%3A0xc813f2f25a481036!2sBH%20Apero Club!5e0!3m2!1sen!2scm!4v1715424000000!5m2!1sen!2scm" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </section>
    </main>

    <x-footer />

    <script>
        // SIDEBAR & HEADER
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const header = document.getElementById('mainHeader');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        if(menuBtn) menuBtn.addEventListener('click', toggleSidebar);
        if(overlay) overlay.addEventListener('click', toggleSidebar);

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        });

        // MAP SEARCH
        const searchInput = document.getElementById('mapSearch');
        const locationItems = document.querySelectorAll('.location-item');

        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                locationItems.forEach(item => {
                    const name = item.querySelector('h4').textContent.toLowerCase();
                    const addr = item.querySelector('p').textContent.toLowerCase();
                    item.style.display = (name.includes(term) || addr.includes(term)) ? 'block' : 'none';
                });
            });
        }

        function updateMap(element, mapUrl) {
            document.getElementById('bertoua-map').src = mapUrl;
            locationItems.forEach(item => item.classList.remove('active'));
            element.classList.add('active');
        }

        // REVEAL
        function reveal() {
            const reveals = document.querySelectorAll(".reveal");
            reveals.forEach(el => {
                const windowHeight = window.innerHeight;
                const elementTop = el.getBoundingClientRect().top;
                if (elementTop < windowHeight - 100) el.classList.add("active");
            });
        }
        window.addEventListener("scroll", reveal);
        window.addEventListener("load", reveal);

        //portal tabs
        document.addEventListener('DOMContentLoaded', () => {
    const tabBtns = document.querySelectorAll('.portal-tab-btn');
    const portalViews = document.querySelectorAll('.portal-view');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target');

            // 1. Update Button States
            tabBtns.forEach(b => {
                b.classList.remove('active');
                b.style.opacity = "0.5";
            });
            btn.classList.add('active');
            btn.style.opacity = "1";

            // 2. Animate Views
            portalViews.forEach(view => {
                // Fade out current active view
                if (view.classList.contains('active')) {
                    view.style.opacity = "0";
                    setTimeout(() => {
                        view.style.display = 'none';
                        view.classList.remove('active');
                        
                        // Show and Fade in target view
                        const targetView = document.getElementById(targetId);
                        targetView.style.display = 'block';
                        setTimeout(() => {
                            targetView.style.opacity = "1";
                            targetView.classList.add('active');
                        }, 50);
                    }, 400); // Matches transition duration
                }
            });
        });
    });
});
    </script>
</body>
</html>