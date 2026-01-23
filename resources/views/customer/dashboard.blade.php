<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cravings | FoodieBert</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <div class="tagline">Personal Gourmet</div>
        <nav class="flex-grow">
            <a href="#" class="nav-item active"><i class="fas fa-pizza-slice"></i> My Orders</a>
            <a href="#" class="nav-item"><i class="fas fa-heart"></i> Favorites</a>
            <a href="#" class="nav-item"><i class="fas fa-wallet"></i> Foodie Wallet</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf 
            <button type="submit" class="nav-item logout-button"><i class="fas fa-power-off"></i> Logout</button>
        </form>
    </aside>

    <main class="main">
        <nav class="breadcrumb-nav">
            <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-house-chimney"></i> Home</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-current">My Account</span>
        </nav>

        <div class="top-bar">
            <div class="welcome-text">
                <h2>Time for a treat, {{ explode(' ', Auth::user()->name)[0] }}?</h2>
                <small class="muted-small">You have 1 order currently in transit.</small>
            </div>
            <div class="admin-profile">
                <img src="{{ Auth::user()->picture ? asset('storage/'.Auth::user()->picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" class="profile-img">
            </div>
        </div>

        <div class="metric-card" style="background: linear-gradient(135deg, var(--primary-blue), #1a2a44); color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 class="playfair-title" style="color: var(--accent-gold);">Current Order Status</h4>
                    <p style="font-size: 1.2rem; margin: 10px 0;">Agent is picking up your food!</p>
                    <small style="opacity: 0.8;">Estimated Delivery: 12:45 PM</small>
                </div>
                <i class="fas fa-motorcycle" style="font-size: 3rem; color: var(--accent-gold); opacity: 0.3;"></i>
            </div>
        </div>

        <div class="metrics-grid mt-20">
            <div class="metric-card"><small>Total Spent</small><h3>$450.20</h3></div>
            <div class="metric-card"><small>Loyalty Points</small><h3>1,200</h3></div>
            <div class="metric-card"><small>Saved Spots</small><h3>5</h3></div>
        </div>
    </main>
</body>
</html>