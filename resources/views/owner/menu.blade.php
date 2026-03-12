<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Mastery | {{ $restaurant->name }} HQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
    <style>
        /* Navy & Gold Premium Overrides */
        :root {
            --navy: #001f3f;
            --gold: #D4AF37;
            --soft-gold: rgba(212, 175, 55, 0.2);
        }
        .sidebar { background: var(--navy); border-right: 3px solid var(--gold); }
        .nav-item.active { background: var(--gold); color: var(--navy); }
        .btn-primary-small, .btn-primary { 
            background: var(--gold); 
            color: var(--navy); 
            border: none;
            font-weight: bold;
        }
        .price-tag {
            background: var(--navy);
            color: var(--gold);
            border: 1px solid var(--gold);
        }
        .cat-pill.active { background: var(--navy); color: var(--gold); border-color: var(--gold); }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-section"><h1 style="color: var(--gold);">FoodieBert</h1></div>
        <div class="tagline" style="color: white; opacity: 0.7;">Merchant Command</div>
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
                    <h2 class="playfair-title" style="color: var(--navy);">Culinary Catalog: {{ $restaurant->name }}</h2>
                    <p class="muted-small">Manage dishes, prices, and availability for your establishment.</p>
                </div>
                <button class="btn-primary-small" onclick="openMenuModal()"><i class="fas fa-plus"></i> Create New Dish</button>
            </div>

            <div class="category-filter mb-20">
                <button class="cat-pill active">All Items</button>
                @foreach(['Starters', 'Main Course', 'Desserts', 'Beverages'] as $cat)
                    <button class="cat-pill">{{ $cat }}</button>
                @endforeach
            </div>

            <div class="metrics-grid">
                {{-- Loop through the relationship we defined in the Model --}}
                @forelse($restaurant->menus as $item)
                <div class="metric-card dish-card">
                    <div class="dish-img-container">
                        <img src="{{ $item->image_url ?? 'https://via.placeholder.com/300x200?text=FoodieBert+Dish' }}" alt="{{ $item->dish_name }}" class="dish-image">
                        <span class="price-tag">${{ number_format($item->price, 2) }}</span>
                    </div>
                    <div class="dish-details">
                        <h4 class="playfair-title">{{ $item->dish_name }}</h4>
                        <p class="muted-small">{{ Str::limit($item->ingredients, 60) }}</p>
                        
                        <div class="dish-status-row">
                            <span class="status-label">{{ $item->is_available ? 'Available' : 'Sold Out' }}</span>
                            <label class="switch-small">
                                <input type="checkbox" {{ $item->is_available ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn-action view"><i class="fas fa-edit"></i></button>
                        <button class="btn-action disable"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 50px; background: white; border-radius: 20px; border: 2px dashed var(--soft-gold);">
                    <i class="fas fa-utensils" style="font-size: 3rem; color: var(--gold); margin-bottom: 15px;"></i>
                    <h3 class="playfair-title">Your Catalog is Empty</h3>
                    <p class="muted-small">Ready to showcase your culinary skills? Click "Create New Dish" to start.</p>
                </div>
                @endforelse
            </div>
        </div>
    </main>

    <div class="modal-overlay" id="dish-modal">
        <div class="modal-content profile-modal">
            <div class="modal-header">
                <h3 class="playfair-title" style="color: var(--navy);">Authorize New Entry</h3>
                <button onclick="closeMenuModal()" class="close-btn">&times;</button>
            </div>
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                
                <div class="input-group">
                    <label class="label-caps">Dish Name</label>
                    <input name="dish_name" type="text" class="form-control" placeholder="e.g. Empire Steak" required>
                </div>

                <div class="input-group">
                    <label class="label-caps">Ingredients / Description</label>
                    <textarea name="ingredients" class="form-control" rows="2" placeholder="Describe the flavors..."></textarea>
                </div>

                <div class="grid-two-col">
                    <div class="input-group">
                        <label class="label-caps">Category</label>
                        <select name="category" class="form-control">
                            <option value="Main Course">Main Course</option>
                            <option value="Starters">Starters</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label class="label-caps">Price ($)</label>
                        <input name="price" type="number" step="0.01" class="form-control" placeholder="15.00" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary mt-25">Commit to Catalog</button>
            </form>
        </div>
    </div>

    <script>
        function openMenuModal() { document.getElementById('dish-modal').style.display = 'flex'; }
        function closeMenuModal() { document.getElementById('dish-modal').style.display = 'none'; }
    </script>
</body>
</html>