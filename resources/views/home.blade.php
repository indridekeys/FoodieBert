<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | Home Page </title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
</head>
<body> @include('components.header')

    <main>
        <section class="hero-section">
            <div class="hero-overlay"></div>
            <div class="hero-container">
                <div class="hero-content">
                    <!-- <span class="hero-subtitle">Premium Culinary Experience</span> -->
                    <h1 class="hero-title">
                        Savor the Art of <br>
                        <span class="text-cursive">Traditional</span> 
                        <span class="text-highlight">Flavors</span>
                    </h1>
                    <p class="hero-description">
                        Taste the excellence of traditional recipes blended with modern culinary arts. 
                        Your destination for premium dining and delivery in the heart of Alaska.
                    </p>
                    
                    <div class="hero-actions">
                        <a href="#menu" class="btn-hero-red">Explore Menu</a>
                        <a href="#reservation" class="btn-hero-outline">Book a Table</a>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <span class="stat-number">15+</span>
                            <span class="stat-label">Years Experience</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">Master Chefs</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-floating-badge">
                <div class="badge-inner">
                    <i class="fas fa-award"></i>
                    <span>Top Rated 2026</span>
                </div>
            </div>
        </section>
<section class="why-choose-us">
    <div class="container">
        <div class="section-top">
            <div class="title-group">
                <span class="text-cursive" style="color: var(--light-red); font-size: 32px;">Our Excellence</span>
                <h2 class="section-title">Why Choose <span class="text-highlight">FoodieBert</span></h2>
            </div>
            <div class="title-description">
                <p>We combine ancient traditions with modern precision to deliver an unforgettable dining experience in Alaska.</p>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                <h3>Master Chefs</h3>
                <p>Our kitchen is led by world-class chefs specializing in authentic regional flavors.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-leaf"></i></div>
                <h3>Fresh Ingredients</h3>
                <p>We source only the finest organic produce and premium meats daily for every dish.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                <h3>Fast Delivery</h3>
                <p>Experience restaurant-quality food at your doorstep with heat-lock packaging.</p>
            </div>
        </div>
    </div>
</section>

<section class="popular-foods">
    <div class="container">
        <div class="section-top">
            <div class="title-group">
                <span class="text-cursive" style="color: var(--light-red); font-size: 32px;">Local Favorites</span>
                <h2 class="section-title">Top Restaurants in <span class="text-highlight">Bertoua</span></h2>
            </div>
            <div class="title-description">
                <p>Explore the best dining spots across the Rising Sun city, from traditional delicacies to modern fusion.</p>
            </div>
        </div>

        <div class="category-filters" style="margin-bottom: 40px;">
            <button class="filter-btn active" onclick="filterCategory('all')">All Spots</button>
            <button class="filter-btn" onclick="filterCategory('traditional')">Traditional</button>
            <button class="filter-btn" onclick="filterCategory('fastfood')">Fast Food</button>
            <button class="filter-btn" onclick="filterCategory('bakery')">Bakeries</button>
        </div>

        <div class="restaurant-grid" id="restaurantGrid">
            <div class="res-card" data-category="traditional">
                <div class="res-image">
                    <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=500&q=80" alt="Le Mistral">
                    <span class="category-badge">Traditional</span>
                </div>
                <div class="res-info">
                    <h3>Le Mistral Bertoua</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        <span>- 120+ Reviews</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Authentic Cameroonian & French Cuisine</p>
                    <div class="res-footer">
                        <button class="ribbon-btn">View Menu</button>
                        <div class="action-icons">
                            <button class="square-icon"><i class="far fa-heart"></i></button>
                            <button class="square-icon"><i class="fas fa-map-marker-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="res-card" data-category="fastfood">
                <div class="res-image">
                    <img src="https://images.unsplash.com/photo-1594179924451-b5d1ad55225f?auto=format&fit=crop&w=500&q=80" alt="Chicken Spot">
                    <span class="category-badge">Fast Food</span>
                </div>
                <div class="res-info">
                    <h3>Bertoua Fried Chicken</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                        <span>- 85 Reviews</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Crispy chicken and local street sides.</p>
                    <div class="res-footer">
                        <button class="ribbon-btn">Order Now</button>
                        <div class="action-icons">
                            <button class="square-icon"><i class="far fa-heart"></i></button>
                            <button class="square-icon"><i class="fas fa-map-marker-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="res-card" data-category="bakery">
                <div class="res-image">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=500&q=80" alt="Sun Bakery">
                    <span class="category-badge">Bakery</span>
                </div>
                <div class="res-info">
                    <h3>The Sun Bakery</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <span>- 210 Reviews</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Fresh pastries and morning coffee.</p>
                    <div class="res-footer">
                        <button class="ribbon-btn">Reserve</button>
                        <div class="action-icons">
                            <button class="square-icon"><i class="far fa-heart"></i></button>
                            <button class="square-icon"><i class="fas fa-map-marker-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="res-card" data-category="traditional">
                <div class="res-image">
                    <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&w=500&q=80" alt="Grill Point">
                    <span class="category-badge">Grill</span>
                </div>
                <div class="res-info">
                    <h3>Central Grill House</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                        <span>- 45 Reviews</span>
                    </div>
                    <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Expertly grilled fish and Ndolé.</p>
                    <div class="res-footer">
                        <button class="ribbon-btn">View Menu</button>
                        <div class="action-icons">
                            <button class="square-icon"><i class="far fa-heart"></i></button>
                            <button class="square-icon"><i class="fas fa-map-marker-alt"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="view-more-container">
            <a href="#" class="view-more-btn">
                View All Restaurants <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</section>

<section class="portal-section dark-theme">
    <div class="container">
        <div class="section-top">
            <div class="title-group">
                <span class="text-cursive" style="color: var(--light-red); font-size: 32px;">Join Our Network</span>
                <h2 class="section-title" style="color: white;">One Platform, <span class="text-highlight">Every</span> Need</h2>
            </div>
            <div class="title-description">
                <p style="color: #cbd5e0;">Whether you are a hungry diner, a professional courier, or a restaurant owner, FoodieBert provides the tools for your success.</p>
            </div>
        </div>

        <div class="portal-grid">
            <div class="portal-card">
                <div class="portal-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Business Account</h3>
                <p>Ideal for corporate catering, bulk orders, and office lunch management with tax-ready invoicing.</p>
                <a href="/register/business" class="btn-portal-outline">Create Account</a>
            </div>

            <div class="portal-card highlighted">
                <div class="portal-icon">
                    <i class="fas fa-moped"></i>
                </div>
                <h3>Delivery Partner</h3>
                <p>Earn on your own schedule. Sign in to your driver dashboard or apply to start delivering today.</p>
                <a href="/login/delivery" class="btn-portal-red">Sign In to Deliver</a>
            </div>

            <div class="portal-card">
                <div class="portal-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3>Restaurant Owner</h3>
                <p>Reach thousands of new customers. Register your kitchen and start growing your business with us.</p>
                <a href="/register/restaurant" class="btn-portal-outline">Register Restaurant</a>
            </div>
        </div>
    </div>
</section>
        

        <section class="blog-section">
    <div class="container">
        <div class="section-top">
            <div class="title-group">
                <span class="text-cursive" style="color: var(--light-red); font-size: 32px;">Latest News</span>
                <h2 class="section-title">Our Culinary <span class="text-highlight">Stories</span></h2>
            </div>
            <div class="title-description">
                <p>Stay updated with the latest recipes, kitchen secrets, and food events happening at FoodieBert Alaska.</p>
            </div>
        </div>

        <div class="blog-grid">
            <article class="blog-card">
                <div class="blog-image">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?auto=format&fit=crop&w=600&q=80" alt="Cooking Secrets">
                    <span class="blog-date">15 Jan 2026</span>
                </div>
                <div class="blog-content">
                    <span class="blog-category">Chef's Secrets</span>
                    <h3>The Secret to the Perfect Traditional Spice Blend</h3>
                    <p>Discover how we balance heat and aroma using traditional Alutiiq influences...</p>
                    <a href="#" class="read-more">Read Story <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image">
                    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=600&q=80" alt="New Menu">
                    <span class="blog-date">10 Jan 2026</span>
                </div>
                <div class="blog-content">
                    <span class="blog-category">Events</span>
                    <h3>Winter Fusion: Our New Seasonal Menu Revealed</h3>
                    <p>This winter, we are introducing five new signature dishes that celebrate local...</p>
                    <a href="#" class="read-more">Read Story <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>

            <article class="blog-card">
                <div class="blog-image">
                    <img src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?auto=format&fit=crop&w=600&q=80" alt="Healthy Eating">
                    <span class="blog-date">05 Jan 2026</span>
                </div>
                <div class="blog-content">
                    <span class="blog-category">Nutrition</span>
                    <h3>From Farm to Table: Sourcing Fresh in Alaska</h3>
                    <p>Learn about the local farmers we partner with to bring organic quality to your plate...</p>
                    <a href="#" class="read-more">Read Story <i class="fas fa-arrow-right"></i></a>
                </div>
            </article>
        </div>

        <div class="view-more-container">
            <a href="#" class="view-more-btn">
                View All Posts <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</section>
    </main>

    @include('components.footer')
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>