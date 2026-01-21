<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Mastery | Empire HQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
</head>
<body>
    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <div class="tagline">Merchant Command</div>
        <nav class="flex-grow">
            <a href="{{ route('owner.dashboard') }}" class="nav-item"><i class="fas fa-bell"></i> Live Orders</a>
            <a href="#" class="nav-item active"><i class="fas fa-utensils"></i> Menu Mastery</a>
            <a href="#" class="nav-item"><i class="fas fa-calendar-check"></i> Bookings</a>
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
                <span class="breadcrumb-current">Menu Mastery</span>
            </nav>

            <div class="top-bar">
                <div class="welcome-text">
                    <h2 class="playfair-title">Culinary Catalog</h2>
                    <p class="muted-small">Manage dishes, prices, and availability.</p>
                </div>
                <button class="btn-primary-small" onclick="openMenuModal()"><i class="fas fa-plus"></i> Create New Dish</button>
            </div>

            <div class="category-filter mb-20">
                <button class="cat-pill active">All Items</button>
                <button class="cat-pill">Starters</button>
                <button class="cat-pill">Main Course</button>
                <button class="cat-pill">Desserts</button>
                <button class="cat-pill">Beverages</button>
            </div>

            <div class="metrics-grid">
                <div class="metric-card dish-card">
                    <div class="dish-img-container">
                        <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=300&q=80" alt="Truffle Pasta" class="dish-image">
                        <span class="price-tag">$24.00</span>
                    </div>
                    <div class="dish-details">
                        <h4 class="playfair-title">Truffle Pasta</h4>
                        <p class="muted-small">Handmade tagliatelle with black truffle cream.</p>
                        
                        <div class="dish-status-row">
                            <span class="status-label">Available</span>
                            <label class="switch-small">
                                <input type="checkbox" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-action view"><i class="fas fa-edit"></i></button>
                        <button class="btn-action disable"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                </div>
        </div>
    </main>

    <div class="modal-overlay" id="dish-modal">
        <div class="modal-content profile-modal">
            <div class="modal-header">
                <h3 class="playfair-title">Add New Dish</h3>
                <button onclick="closeMenuModal()" class="close-btn">&times;</button>
            </div>
            <form action="#" method="POST">
                <div class="input-group">
                    <label class="label-caps">Dish Name</label>
                    <input type="text" class="form-control" placeholder="e.g. Empire Steak">
                </div>
                <div class="grid-two-col">
                    <div class="input-group">
                        <label class="label-caps">Category</label>
                        <select class="form-control">
                            <option>Main Course</option>
                            <option>Starters</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label-caps">Price ($)</label>
                        <input type="number" step="0.01" class="form-control" placeholder="15.00">
                    </div>
                </div>
                <button type="submit" class="btn-primary mt-25">Authorize Entry</button>
            </form>
        </div>
    </div>

    <script>
        function openMenuModal() { document.getElementById('dish-modal').style.display = 'flex'; }
        function closeMenuModal() { document.getElementById('dish-modal').style.display = 'none'; }
    </script>
</body>
</html>