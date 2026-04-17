@include('components.loader')
@include('components.header')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --primary-blue: #0a192f;
        --accent-gold: #C5A059;
        --soft-cream: #fafaf7;
        --deep-red: #8e2117;
        --text-main: #2d3436;
        --text-light: #636e72;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--soft-cream);
        color: var(--primary-blue);
        margin: 0;
        overflow-x: hidden;
    }

    /* --- ENHANCED HERO --- */
    .hero-banner {
        height: 85vh;
        background: linear-gradient(rgba(10, 25, 47, 0.5), rgba(10, 25, 47, 0.5)), 
                    url('{{ asset("storage/" . $restaurant->image_url) }}') center/cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        clip-path: inset(0 0 0 0);
    }

    .hero-content h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(3rem, 10vw, 5.5rem);
        color: white;
        margin: 10px 0;
        font-weight: 900;
        letter-spacing: -2px;
    }

    .hero-content p {
        color: var(--accent-gold);
        text-transform: uppercase;
        letter-spacing: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* --- REFINED ABOUT SECTION --- */
    .section-padding { padding: 120px 8%; }

    .about-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 100px;
        align-items: center;
    }

    @media (max-width: 992px) {
        .about-grid { grid-template-columns: 1fr; gap: 50px; }
    }

    .gold-title {
        color: var(--accent-gold);
        font-weight: 700;
        letter-spacing: 4px;
        font-size: 0.8rem;
        display: block;
        margin-bottom: 15px;
        text-transform: uppercase;
    }

    .playfair-heading {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        line-height: 1.1;
        margin-bottom: 30px;
    }

    /* --- SCOPED MENU STYLING --- */
    #exclusive-menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 40px;
        margin-top: 60px;
    }

    #exclusive-menu-grid .menu-card-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 20px;
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        gap: 15px;
        cursor: pointer;
    }

    #exclusive-menu-grid .menu-card-item:hover {
        background: rgba(255, 255, 255, 0.07);
        transform: translateY(-5px);
        border-color: var(--accent-gold);
    }

    #exclusive-menu-grid .menu-thumb {
        width: 100%;
        height: 180px;
        overflow: hidden;
        border-radius: 10px;
    }

    #exclusive-menu-grid .menu-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #exclusive-menu-grid .item-details {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    #exclusive-menu-grid .item-name {
        font-family: 'Playfair Display';
        font-size: 1.4rem;
        color: #fff;
        margin: 0;
    }

    #exclusive-menu-grid .item-price {
        color: var(--accent-gold);
        font-weight: 700;
        font-size: 1.1rem;
    }

    #exclusive-menu-grid .item-desc {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
        line-height: 1.5;
        margin: 0;
    }

    /* --- GALLERY --- */
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .gallery-item { 
        position: relative; 
        overflow: hidden; 
        border-radius: 8px; 
        cursor: pointer;
        aspect-ratio: 1 / 1;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .gallery-item img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1); 
    }

    .gallery-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 31, 63, 0.85); 
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        opacity: 0; 
        transition: opacity 0.5s ease;
        z-index: 2;
    }

    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-item:hover .gallery-overlay { opacity: 1; }

    .cart-modal {
        position: fixed;
        right: -400px;
        top: 0;
        width: 380px;
        height: 100%;
        background: white;
        box-shadow: -5px 0 30px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .cart-modal.active { right: 0; }

    .cart-header {
        padding: 25px;
        background: var(--primary-blue);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-cart-btn {
        background: none; border: none;
        color: white; font-size: 2rem; cursor: pointer;
    }

    .cart-body { flex: 1; overflow-y: auto; padding: 20px; }

    .cart-footer {
        padding: 25px;
        border-top: 1px solid #eee;
        background: #fdfdfd;
    }

    .btn-gold {
        background: var(--accent-gold);
        color: white;
        padding: 20px 50px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 2px;
        display: inline-block;
        transition: 0.4s;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
    }
</style>

<div id="cartModal" class="cart-modal">
    <div class="cart-header">
        <h2><i class="fas fa-shopping-basket"></i> Your Cart</h2>
        <button id="closeCart" class="close-cart-btn" type="button">&times;</button>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="cart-body" id="cartItemsList">
            <p style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>
        </div>

        <div class="cart-footer">
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:bold; font-size: 0.9rem;">Delivery Address:</label>
                <input type="text" name="delivery_address" class="form-control" 
                       placeholder="Street, Quarter, or House No." required 
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div style="display:flex; justify-content:space-between; padding: 10px 0; font-weight:bold; font-size:1.1rem; border-top: 1px solid #eee;">
                <span>Total:</span>
                <span id="cartDisplayTotal">0 FCFA</span>
                <input type="hidden" name="total_price" id="hiddenCartTotal" value="0">
                {{-- Restaurant ID will be injected via JS --}}
                <div id="hiddenFields"></div>
            </div>

            <button type="submit" style="width: 100%; background: #28a745; color: white; padding: 15px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top:10px;">
                <i class="fas fa-check-circle"></i> Confirm Order
            </button>
        </div>
    </form>
</div>

<div class="restaurant-master">
    <section class="hero-banner">
        <div class="hero-content animate__animated animate__fadeIn">
           
            <h1>{{ $restaurant->name }}</h1>
            <div style="width: 60px; height: 2px; background: var(--accent-gold); margin: 30px auto;"></div>
            <a href="#menu-section" class="btn-gold">Explore The Menu</a>
        </div>
    </section>

    <section class="section-padding">
        <div class="about-grid">
            <div class="animate__animated animate__fadeInLeft">
                <span class="gold-title">Our Heritage</span>
                <h2 class="playfair-heading">A Legacy of Taste Since {{ $restaurant->created_at->format('Y') }}</h2>
                <p style="line-height: 1.8; font-size: 1.15rem; color: var(--text-light);">
                    {{ $restaurant->description }}
                </p>
            </div>
            <div class="animate__animated animate__fadeInRight">
                <img src="{{ asset('storage/' . $restaurant->image_url) }}" style="width: 100%; height: 500px; object-fit: cover; box-shadow: 40px 40px 0 -10px var(--accent-gold);">
            </div>
        </div>
    </section>

    <section id="menu-section" style="background: #0d1b2a; padding: 100px 8%;">
        <div style="text-align: center; margin-bottom: 80px;">
            <span class="gold-title">The Collection</span>
            <h2 class="playfair-heading" style="color: white;">Chef's Recommendations</h2>
        </div>

        <div id="exclusive-menu-grid">
            @forelse($restaurant->menus as $item)
                <div class="menu-card-item" onclick="addToCart('{{ $item->name }}', '{{ $item->price }}', '{{ $restaurant->id }}')">
                    <div class="menu-thumb">
                        <img src="{{ $item->dish_image }}" alt="{{ $item->name }}">
                    </div>
                    <div class="item-details">
                        <h4 class="item-name">{{ $item->name }}</h4>
                        <div class="item-price">{{ number_format($item->price) }} CFA</div>
                    </div>
                    <p class="item-desc">
                        {{ $item->description ?? 'Traditional speciality made with the freshest ingredient' }}
                    </p>
                    <p style="color:var(--accent-gold); font-size:0.7rem; margin-top:auto; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                        <i class="fas fa-plus-circle"></i> Add to Cart
                    </p>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; opacity: 0.5; padding: 40px; color: white;">Our seasonal menu is being updated.</p>
            @endforelse
        </div>
    </section>

    <section class="section-padding">
        <div style="text-align: center; margin-bottom: 70px;">
            <span class="gold-title">Gallery</span>
            <h2 class="playfair-heading">Atmosphere & Spirit</h2>
        </div>
        <div class="gallery-container">
            @forelse($restaurant->galleries ?? $restaurant->gallery ?? [] as $photo)
                <div class="gallery-item">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="{{ $photo->name }}">
                    <div class="gallery-overlay">
                        <h3>{{ $photo->name ?? 'Exquisite Meal' }}</h3>
                        <p style="color: #D4AF37; font-weight: bold; margin-bottom: 15px;">{{ number_format($photo->price ?? 0) }} FCFA</p>
                        <button type="button" class="btn-gold" style="padding: 10px 20px;" onclick="addToCart('{{ $photo->name }}', '{{ $photo->price }}', '{{ $restaurant->id }}')">
                            ADD TO CART
                        </button>
                    </div>
                </div>
            @empty
                <p style="text-align: center; grid-column: 1/-1; color: #666;">Visual experience coming soon.</p>
            @endforelse
        </div>
    </section>
</div>

<script>
let cart = [];

function addToCart(name, price, restaurantId) {
    cart.push({
        name: name,
        price: parseFloat(price),
        restaurant_id: restaurantId
    });

    document.getElementById('cartModal').classList.add('active');
    renderCartItems();
}

function renderCartItems() {
    const listContainer = document.getElementById('cartItemsList');
    const totalText = document.getElementById('cartDisplayTotal');
    const totalInput = document.getElementById('hiddenCartTotal');
    const hiddenFields = document.getElementById('hiddenFields');
    
    if (cart.length === 0) {
        listContainer.innerHTML = '<p style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>';
        totalText.innerText = "0 FCFA";
        totalInput.value = 0;
        hiddenFields.innerHTML = "";
        return;
    }

    let html = '';
    let inputs = '';
    let total = 0;

    cart.forEach((item, index) => {
        total += item.price;
        html += `
            <div style="display:flex; justify-content:space-between; padding: 15px; border-bottom: 1px solid #eee; background:#fff; margin-bottom:10px; border-radius:8px;">
                <div>
                    <strong style="display:block; color:var(--primary-blue);">${item.name}</strong>
                    <small style="color:var(--accent-gold);">${item.price.toLocaleString()} FCFA</small>
                </div>
                <button type="button" onclick="removeFromCart(${index})" style="background:none; border:none; color:#ff4d4d; cursor:pointer; font-size:1.2rem;">&times;</button>
            </div>
        `;

        inputs += `
            <input type="hidden" name="food_names[]" value="${item.name}">
            <input type="hidden" name="prices[]" value="${item.price}">
            <input type="hidden" name="restaurant_id" value="${item.restaurant_id}">
            <input type="hidden" name="quantities[]" value="1">
        `;
    });

    listContainer.innerHTML = html;
    hiddenFields.innerHTML = inputs;
    totalText.innerText = total.toLocaleString() + " FCFA";
    totalInput.value = total;
}

function removeFromCart(index) {
    cart.splice(index, 1);
    renderCartItems();
}

document.getElementById('closeCart').onclick = function() {
    document.getElementById('cartModal').classList.remove('active');
};


document.getElementById('checkoutForm').onsubmit = function(e) {
    if(cart.length === 0) {
        e.preventDefault();
        alert('Please add items to your cart first.');
    }
};
</script>

@include('components.footer')