<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">

<style>
  
    .header-logo-box {
        display: flex;
        align-items: center;
        background: #0a192f; 
        border: 2px solid #C5A059;
        padding: 5px 12px;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-right: 80px;
    }

    .header-logo-box:hover {
        background: #112240;
    }

    .crazy-icons-static {
        display: flex;
        align-items: center;
        margin-right: 10px;
        font-size: 1.8rem; 
        line-height: 1;
    }
    
    .icon-fork { 
        color: #e74c3c; 
        transform: rotate(0deg); 
        display: inline-block;
        vertical-align: middle;
    }

    .logo-text {
        font-family: 'Comic Sans MS', 'Cursive', sans-serif;
        font-size: 1.3rem;
        margin: 0;
        line-height: 1;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
        transition: transform 0.3s ease;
    }
    .avatar-wrapper:hover { transform: scale(1.05); }
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
    .status-verified { background-color: #16a34a; }
    .status-unverified { background-color: #dc2626; }
    
    .user-avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-name-pink {
        color: #e74c3c !important; 
        font-weight: bold;
        font-size: 0.95rem;
        text-shadow: 0 0 8px rgba(255, 105, 180, 0.3);
    }

    .role-badge {
        color: #C5A059;
        text-transform: uppercase;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .user-profile-link {
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .cart-modal {
        position: fixed;
        top: 0;
        right: -100%;
        width: 100%;
        max-width: 450px;
        height: 100%;
        background: #fff;
        z-index: 9999;
        transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: -5px 0 15px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }
    .cart-modal.active { right: 0; }
    .cart-header {
        padding: 20px;
        background: #0a192f;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .close-cart-btn {
        background: none;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
    }
    .cart-body { flex: 1; overflow-y: auto; padding: 20px; color: #333; }
    .cart-footer { padding: 20px; border-top: 1px solid #eee; background: #f9f9f9; }
    .checkout-btn {
        width: 100%;
        background: #e74c3c;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
    }
    #cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #e74c3c;
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 50%;
    }
</style>

@auth
    @php
        $userPhoto = Auth::user()->profile_photo ?? Auth::user()->profile_photo_path ?? Auth::user()->picture;
        $avatarUrl = $userPhoto 
            ? asset('storage/' . $userPhoto) 
            : "https://ui-avatars.com/api/?name=" . urlencode(Auth::user()->name) . "&background=0a192f&color=C5A059";
    @endphp
@endauth

<header class="foodie-header" id="mainHeader">
    <a href="{{ route('home') }}" class="header-logo-box">
        <div class="crazy-icons-static">
            <i class="fas fa-utensils icon-fork"></i>
        </div>
        <h1 class="logo-text">
            <span style="color: #fff;">Foodie</span><span style="color: #C5A059;">Bert</span>
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
                        <li><a href="{{ route('restaurants') }}"><i class="fas fa-store"></i> Blog</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <div class="auth-group">
        <div id="cartTrigger" style="cursor: pointer; position: relative; margin-right: 20px; display: flex; align-items: center;">
            <i class="fas fa-shopping-cart" style="color: #C5A059; font-size: 1.2rem;"></i>
            <span id="cart-count">0</span>
        </div>

        @guest
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        @endguest

        @auth
            <div class="user-meta d-none d-lg-flex flex-column text-right" style="line-height: 1.2; margin-right: 15px; text-align: right;">
                <span class="user-name-pink">{{ Auth::user()->name }}</span>
                <small class="role-badge">{{ str_replace('_', ' ', Auth::user()->role) }}</small> 
            </div>

            <a href="{{ route('reverify') }}" class="user-profile-link" title="Re-authenticate to Access Dashboard">
                <div class="avatar-wrapper">
                    <div class="user-avatar-circle" style="width: 42px; height: 42px; border-radius: 50%; overflow: hidden; border: 2px solid #C5A059; background: #0a192f;">
                        <img src="{{ $avatarUrl }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <span class="status-indicator {{ Auth::user()->is_verified ? 'status-verified' : 'status-unverified' }}"></span>
                </div>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" style="margin-left: 15px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:#C5A059; cursor:pointer; font-size: 1.1rem;" title="Logout">
                    <i class="fas fa-power-off"></i>
                </button>
            </form>
        @endauth
    </div>

    <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </div>
</header>

@if ($errors->any())
    <div style="position: fixed; top: 80px; right: 20px; z-index: 10000; background: #dc3545; color: white; padding: 15px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
        <strong style="display:block; margin-bottom: 5px;">Order Failed:</strong>
        <ul style="margin:0; padding-left:20px; font-size: 0.85rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:white; float:right; cursor:pointer;">&times;</button>
    </div>
@endif

@if(session('success'))
    <div id="successMessage" style="position: fixed; top: 20px; right: 20px; z-index: 10000; background: #28a745; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px; animation: slideIn 0.5s ease-out;">
        <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
        <div>
            <strong style="display: block;">{{ str_contains(session('success'), 'order') || str_contains(session('success'), 'placed') ? 'Order Sent!' : 'Success!' }}</strong>
            <span style="font-size: 0.9rem;">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" style="background:none; border:none; color:white; margin-left:15px; cursor:pointer; font-size:1.2rem;">&times;</button>
    </div>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('successMessage');
            if(msg) {
                msg.style.opacity = '0';
                msg.style.transition = 'opacity 0.5s ease';
                setTimeout(() => msg.remove(), 500);
            }
        }, 5000);
    </script>
@endif

<div id="cartModal" class="cart-modal">
    <div class="cart-header">
        <h2><i class="fas fa-shopping-basket"></i> Your Cart</h2>
        <button id="closeCart" class="close-cart-btn" type="button">&times;</button>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
        @csrf
        <div class="cart-body" id="cartItemsList">
            <p id="emptyCartMsg" style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>
        </div>

        <div class="cart-footer">
            <div style="margin-bottom: 15px; padding: 0 15px;">
                <label style="display:block; margin-bottom:5px; font-weight:bold; font-size: 0.9rem; color: #0a192f;">
                    <i class="fas fa-map-marker-alt" style="color: #e74c3c;"></i> Delivery Address:
                </label>
                <input type="text" name="delivery_address" id="delivery_address" class="form-control" 
                       placeholder="Street, Quarter, or House No." required 
                       style="width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; transition: border-color 0.3s;"
                       onfocus="this.style.borderColor='#e74c3c'">
            </div>

            <div style="display:flex; justify-content:space-between; padding: 10px 15px; font-weight:bold; font-size:1.1rem; border-top: 1px solid #eee;">
                <span>Total:</span>
                <span id="cartDisplayTotal" style="color: #0a192f;">0 FCFA</span>
                <input type="hidden" name="total_price" id="hiddenCartTotal" value="0">
            </div>

            <div style="padding: 15px;">
                <button type="submit" class="checkout-btn" 
                        style="width: 100%; background: #e74c3c; color: white; padding: 14px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-size: 1rem; transition: background 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <i class="fas fa-paper-plane"></i> Confirm Order
                </button>
            </div>
        </div>
    </form>
</div>

<div class="mobile-nav" id="mobileNav">
    @auth
        <div class="mobile-profile-section" style="padding: 20px; display: flex; align-items: center; background: rgba(10, 25, 47, 0.05); border-bottom: 1px solid rgba(197, 160, 89, 0.1);">
            <a href="{{ route('reverify') }}" style="text-decoration: none; display: flex; align-items: center;">
                <div class="avatar-wrapper">
                    <div class="user-avatar-circle" style="width: 50px; height: 50px; border-radius: 50%; overflow: hidden; border: 2px solid #C5A059; background: #0a192f;">
                        <img src="{{ $avatarUrl }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <span class="status-indicator {{ Auth::user()->is_verified ? 'status-verified' : 'status-unverified' }}" style="width:12px; height:12px;"></span>
                </div>
                <div class="mobile-user-info" style="margin-left: 15px;">
                    <span class="user-name-pink" style="display: block;">{{ Auth::user()->name }}</span>
                    <small class="role-badge">{{ str_replace('_', ' ', Auth::user()->role) }}</small>
                </div>
            </a>
        </div>
    @endauth

    <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Home</a>
    <a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i> About</a>
    <a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a>
    @guest
        <a href="{{ route('register') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Register</a>
        <a href="{{ route('login') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
    @endguest
    @auth
        <a href="{{ route('reverify') }}" class="nav-link"><i class="fas fa-shield-halved"></i> Verify & Access Dashboard</a>
        <form method="POST" action="{{ route('logout') }}" style="padding: 20px;">
            @csrf
            <button type="submit" style="background:none; border:none; color:#dc2626; font-size: 1rem; cursor:pointer;">
                <i class="fas fa-power-off"></i> Sign Out
            </button>
        </form>
    @endauth
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobileNav');
    if(hamburger && mobileNav) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            mobileNav.classList.toggle('active');
        });
    }

    window.addEventListener('scroll', () => {
        const header = document.getElementById('mainHeader');
        if (header) {
            if (window.scrollY > 50) header.classList.add('scrolled');
            else header.classList.remove('scrolled');
        }
    });

    let cart = [];
    const cartModal = document.getElementById('cartModal');
    const cartTrigger = document.getElementById('cartTrigger');
    const closeCart = document.getElementById('closeCart');

    if(cartTrigger) {
        cartTrigger.addEventListener('click', () => {
            cartModal.classList.add('active');
        });
    }

    if(closeCart) {
        closeCart.addEventListener('click', () => {
            cartModal.classList.remove('active');
        });
    }

    function addToCart(name, price, restaurantId) {
        cart.push({
            name: name,
            price: parseFloat(price),
            restaurant_id: restaurantId
        });
        
        cartModal.classList.add('active');
        renderCartItems();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCartItems();
    }

    function renderCartItems() {
        const listContainer = document.getElementById('cartItemsList');
        const totalText = document.getElementById('cartDisplayTotal');
        const totalInput = document.getElementById('hiddenCartTotal');
        const countSpan = document.getElementById('cart-count');
        
        countSpan.innerText = cart.length;

        if (cart.length === 0) {
            listContainer.innerHTML = '<p id="emptyCartMsg" style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>';
            totalText.innerText = "0 FCFA";
            totalInput.value = 0;
            return;
        }

        let html = '';
        let total = 0;
        
        // Grab restaurant_id from the first item
        const resId = cart[0].restaurant_id;

        cart.forEach((item, index) => {
            total += item.price;
            html += `
                <div class="item-row" style="display:flex; justify-content:space-between; padding: 15px; border-bottom: 1px solid #eee; background:#fff; margin-bottom:10px; border-radius:8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <div>
                        <strong style="display:block; color:#0a192f;">${item.name}</strong>
                        <small style="color:#C5A059; font-weight:bold;">${item.price.toLocaleString()} FCFA</small>
                        
                        <input type="hidden" name="food_names[]" value="${item.name}">
                        <input type="hidden" name="prices[]" value="${item.price}">
                        <input type="hidden" name="quantities[]" value="1">
                    </div>
                    <button type="button" onclick="removeFromCart(${index})" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:1.2rem;">&times;</button>
                </div>
            `;
        });

        // Crucial: Single restaurant_id input for the whole order
        html += `<input type="hidden" name="restaurant_id" value="${resId}">`;

        listContainer.innerHTML = html;
        totalText.innerText = total.toLocaleString() + " FCFA";
        totalInput.value = total;
    }

    const checkoutForm = document.getElementById('checkoutForm');
    if(checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert("Please add items to your cart first.");
            }
        });
    }
</script>