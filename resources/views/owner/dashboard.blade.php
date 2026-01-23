<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Core | Empire HQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <div class="tagline">Merchant Command</div>
        <nav class="flex-grow">
            <a href="javascript:void(0)" class="nav-item active" onclick="showSection('orders', this)"><i class="fas fa-bell"></i> Live Orders</a>
            <a href="javascript:void(0)" class="nav-item" onclick="showSection('menu', this)"><i class="fas fa-utensils"></i> Menu Mastery</a>
            <a href="javascript:void(0)" class="nav-item" onclick="showSection('bookings', this)"><i class="fas fa-calendar-check"></i> Bookings</a>
            <a href="#" class="nav-item"><i class="fas fa-percentage"></i> Promotions</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf 
            <button type="submit" class="nav-item logout-button"><i class="fas fa-power-off"></i> Logout</button>
        </form>
    </aside>

    <main class="main">
        <div class="dashboard-container">
            <nav class="breadcrumb-nav">
                <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-house-chimney"></i> Home</a>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-current" id="breadcrumb-text">Dashboard</span>
            </nav>

            <div class="top-bar">
                <div class="welcome-text">
                    <h2 class="playfair-title">Welcome back, Chef {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <small class="muted-small">Your restaurant, <strong>{{ Auth::user()->restaurant_name ?? 'The Gourmet Empire' }}</strong>, is <span class="status-green">Online</span></small>
                </div>
                <div class="admin-profile">
                    <div class="text-right">
                        <span class="font-bold">{{ Auth::user()->name }}</span><br>
                        <small class="matricule-text">ID: #00{{ Auth::user()->id }}</small>
                    </div>
                    
                    <div class="profile-img-wrapper">
                        @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="profile-img" alt="Profile" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0a192f&color=C5A059&size=128'">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0a192f&color=C5A059&size=128" class="profile-img" alt="Avatar">
                        @endif
                    </div>
                </div>
            </div>

            <div class="metrics-grid">
                <div class="metric-card"><small>Orders Today</small><h3>24</h3></div>
                <div class="metric-card"><small>Gross Sales</small><h3>$1,120.00</h3></div>
                <div class="metric-card"><small>Active Bookings</small><h3>8</h3></div>
                <div class="metric-card"><small>Avg. Prep Time</small><h3>18m</h3></div>
            </div>

            <div id="section-orders" class="dashboard-content">
                <div class="grid-two-col mt-20">
                    <div class="metric-card">
                        <div class="table-header">
                            <h4 class="playfair-title">Incoming Orders</h4>
                            <span class="badge-pulse">Live</span>
                        </div>
                        <div class="table-responsive">
                            <table class="empire-table">
                                <thead>
                                    <tr><th>Order #</th><th>Items</th><th>Action</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>#FB-902</td><td>2x Truffle Pasta</td><td><button class="btn-primary-small">Accept</button></td></tr>
                                    <tr><td>#FB-899</td><td>1x Empire Burger</td><td><button class="btn-primary-small">Accept</button></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="table-header"><h4 class="playfair-title">Reservations</h4></div>
                        <div class="booking-list">
                            <div class="booking-item">
                                <div class="booking-info"><strong>Mr. Kingsley</strong><small>4 People | 19:30</small></div>
                                <span class="status-badge online">Confirmed</span>
                            </div>
                            <div class="booking-item">
                                <div class="booking-info"><strong>Mme. Claire</strong><small>2 People | 20:00</small></div>
                                <span class="status-badge pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-menu" class="dashboard-content" style="display: none;">
                <div class="metric-card">
                    <div class="table-header">
                        <h4 class="playfair-title">Menu Mastery</h4>
                        <button class="btn-primary-small"><i class="fas fa-plus"></i> Add Dish</button>
                    </div>
                    <div class="metrics-grid mt-20">
                        <div class="dish-mini-card">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop" class="dish-thumb">
                            <div class="dish-info">
                                <strong>Truffle Pasta</strong>
                                <span class="text-gold">$24.00</span>
                            </div>
                            <label class="switch-small"><input type="checkbox" checked><span class="slider round"></span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-bookings" class="dashboard-content" style="display: none;">
                <div class="metric-card">
                    <h4 class="playfair-title">Full Reservation Calendar</h4>
                    <p class="muted-small mt-10">Historical bookings and upcoming schedule.</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        function showSection(sectionId, element) {
            document.querySelectorAll('.dashboard-content').forEach(section => { section.style.display = 'none'; });
            document.getElementById('section-' + sectionId).style.display = 'block';
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            element.classList.add('active');
            document.getElementById('breadcrumb-text').innerText = element.innerText.trim();
        }
    </script>
</body>
</html>