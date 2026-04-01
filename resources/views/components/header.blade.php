<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">

<style>
    /* --- COMPACT SQUARE LOGO BOX --- */
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
        /* --light-red: #e74c3c;           
    --dark-red: #b03a2e; */
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
                        <!-- <li><a href="#"><i class="fas fa-fire"></i> Hot Deals</a></li> -->
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

<div id="cartModal" class="cart-modal">
    <div class="cart-header">
        <h2><i class="fas fa-shopping-basket"></i> Your Cart</h2>
        <button id="closeCart" class="close-cart-btn">&times;</button>
    </div>
    <div class="cart-body" id="cartItems">
        <p style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>
    </div>
    <div class="cart-footer">
        <div style="display:flex; justify-content:space-between; margin-bottom:15px; font-weight:bold; font-size:1.1rem;">
            <span>Total:</span>
            <span id="cartTotal">0 FCFA</span>
        </div>
        <button class="checkout-btn">Proceed to Checkout</button>
    </div>
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
    <li><a href="{{ route('about') }}" class="nav-link"><i class="fas fa-info-circle"></i> About</a></li>
    <li><a href="{{ route('contact') }}" class="nav-link"><i class="fas fa-envelope"></i> Contact</a></li>
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
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    const cartTrigger = document.getElementById('cartTrigger');
    const cartModal = document.getElementById('cartModal');
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

    let cartData = [];

    function addToCart(name, price) {
        cartData.push({ name, price });
        updateCartDisplay();
    }

    function removeFromCart(index) {
        cartData.splice(index, 1);
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const container = document.getElementById('cartItems');
        const count = document.getElementById('cart-count');
        const total = document.getElementById('cartTotal');
        
        if(!container || !count || !total) return;
        count.innerText = cartData.length;
        
        if(cartData.length === 0) {
            container.innerHTML = '<p style="text-align:center; margin-top:50px; color:#999;">Your cart is currently empty.</p>';
            total.innerText = '0 FCFA';
            return;
        }
        
        let totalVal = 0;
        container.innerHTML = cartData.map((item, index) => {
            totalVal += item.price;
            return `
                <div style="padding:15px; border-bottom:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <span style="display:block; font-weight:600; color:#0a192f;">${item.name}</span>
                        <small style="color:#FF69B4;">${item.price.toLocaleString()} FCFA</small>
                    </div>
                    <button onclick="removeFromCart(${index})" style="background:none; border:none; color:#dc2626; cursor:pointer; padding:5px;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>`;
        }).join('');
        
        total.innerText = totalVal.toLocaleString() + ' FCFA';
    }

    const checkoutBtn = document.querySelector('.checkout-btn');
    if(checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (cartData.length === 0) {
                alert("Your cart is empty! Please add some food first.");
                return;
            }
            localStorage.setItem('foodieCart', JSON.stringify(cartData));
            window.location.href = "{{ route('proceed.page') }}";
        });
    }
</script>