<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FoodieBert | Owner Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
    <style>
        .modal-full-page { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: #fff; z-index: 10000; overflow-y: auto; padding: 40px; }
        .modal-overlay { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center; }
        .profile-img:hover { filter: brightness(0.8); cursor: pointer; }
        
        /* Search Bar Styling */
        .search-container { position: relative; width: 300px; }
        .search-container input { width: 100%; padding: 10px 15px 10px 40px; border-radius: 20px; border: 1px solid #ddd; outline: none; font-family: inherit; }
        .search-container i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; }

        .breadcrumb-nav { display: flex; align-items: center; gap: 10px; margin-bottom: 25px; padding: 10px 0; font-size: 0.9rem; }
        .breadcrumb-item { text-decoration: none; color: #001f3f; transition: color 0.3s; }
        .breadcrumb-item:hover { color: #D4AF37; }
        .breadcrumb-current { color: #D4AF37; font-weight: 600; }

        /* Status Badges */
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .badge-confirmed { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>

<body>

@if(session('success'))
    <div style="position: fixed; top: 20px; right: 20px; background: #001f3f; color: #D4AF37; padding: 15px 25px; border-radius: 8px; z-index: 20000; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-bottom: 3px solid #D4AF37;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div id="modal-menu-management" class="modal-full-page">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #D4AF37; padding-bottom: 15px;">
            <h2 style="font-family: 'Playfair Display'; color: #001f3f; font-size: 2.5rem;"><i class="fas fa-utensils" style="color: #D4AF37;"></i> Menu Management</h2>
            
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="menuSearch" onkeyup="filterTable('menuSearch', 'menuTable')" placeholder="Search menu items...">
            </div>

            <button onclick="toggleModal('modal-menu-management')" style="background:#001f3f; border:none; color: #D4AF37; font-size: 1.5rem; cursor:pointer; padding: 10px 20px; border-radius: 8px;">Close &times;</button>
        </div>

        <form action="{{ route('owner.menu.store') }}" method="POST" enctype="multipart/form-data" style="background: #f9f9f9; padding: 30px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #ddd;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
                <input type="text" name="name" placeholder="Dish Name" required style="padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                <input type="number" name="price" placeholder="Price (CFA)" required style="padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                <select name="restaurant_id" required style="padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                    @foreach($restaurants as $res)
                        <option value="{{ $res->id }}">{{ $res->name }}</option>
                    @endforeach
                </select>
                <input type="file" name="image" accept="image/*" style="padding: 8px;">
            </div>
            <button type="submit" style="margin-top: 20px; width: 100%; background: #001f3f; color: #D4AF37; padding: 15px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                <i class="fas fa-plus-circle"></i> ADD NEW DISH
            </button>
        </form>

        <div class="data-container">
            <table id="menuTable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #001f3f; color: #D4AF37; text-align: left;">
                        <th style="padding: 15px;">Preview</th>
                        <th style="padding: 15px;">Dish Details</th>
                        <th style="padding: 15px;">Restaurant</th>
                        <th style="padding: 15px;">Price</th>
                        <th style="padding: 15px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menuItems as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;"><img src="{{ $item->image ? asset($item->image) : asset('uploads/default-dish.jpg') }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"></td>
                        <td style="padding: 15px;"><strong>{{ $item->name }}</strong></td>
                        <td>{{ $item->restaurant->name }}</td>
                        <td>{{ number_format($item->price) }} CFA</td>
                        <td style="text-align: right; padding: 15px;">
                            <form action="{{ route('owner.menu.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:#ef4444; color: white; border:none; padding: 8px 12px; border-radius: 5px; cursor:pointer;" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modal-profile" class="modal-overlay">
    <div style="background: white; padding: 30px; border-radius: 12px; width: 400px; position: relative;">
        <button onclick="toggleModal('modal-profile')" style="position: absolute; top: 15px; right: 15px; border: none; background: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        <h3>Update Profile Photo</h3>
        <form action="{{ route('owner.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <input type="file" name="profile_photo" required style="width: 100%; margin: 20px 0;">
            <button type="submit" style="width: 100%; background: #001f3f; color: #D4AF37; padding: 12px; border: none; border-radius: 6px; font-weight: bold;">Update Picture</button>
        </form>
    </div>
</div>

<div id="modal-gallery-management" class="modal-full-page">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #D4AF37; padding-bottom: 15px;">
            <h2 style="font-family: 'Playfair Display'; color: #001f3f; font-size: 2.5rem;"><i class="fas fa-images" style="color: #D4AF37;"></i> Visual Feast Management</h2>
            <button onclick="toggleModal('modal-gallery-management')" style="background:#001f3f; border:none; color: #D4AF37; font-size: 1.5rem; cursor:pointer; padding: 10px 20px; border-radius: 8px;">Close &times;</button>
        </div>

        <div style="background: #f9f9f9; padding: 30px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #ddd;">
            <h4 style="margin-bottom: 15px; color: #001f3f;">Add New Visuals</h4>
            <form id="galleryForm" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; align-items: end;">
                    <div>
                        <label class="label-caps" style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Select Restaurant</label>
                        <select name="restaurant_id" id="gallery_res_id" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                            @foreach($restaurants as $res)
                                <option value="{{ $res->id }}">{{ $res->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label-caps" style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Upload Photos</label>
                        <input type="file" name="images[]" multiple accept="image/*" required style="padding: 8px;">
                    </div>
                </div>
                <button type="submit" onclick="updateGalleryAction()" style="margin-top: 20px; width: 100%; background: #001f3f; color: #D4AF37; padding: 15px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    <i class="fas fa-cloud-upload-alt"></i> UPLOAD TO GALLERY
                </button>
            </form>
        </div>

        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @foreach($restaurants as $res)
                @foreach($res->gallery as $photo)
                <div style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid #eee; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    <img src="{{ asset('storage/' . $photo->path) }}" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 10px; display: flex; justify-content: space-between; align-items: center;">
                        <small style="color: #666;">{{ $res->name }}</small>
                        <form action="{{ route('gallery.destroy', $photo->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: #ef4444; color: white; border: none; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;" onclick="return confirm('Remove image?')">
                                <i class="fas fa-trash" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>

<aside class="sidebar">
    <nav style="flex-grow: 1;">
        <a href="{{ route('owner.dashboard') }}" class="nav-item active"><i class="fas fa-chart-pie"></i> Revenue Overview</a>
        <a href="javascript:void(0)" class="nav-item" onclick="toggleModal('modal-menu-management')"><i class="fas fa-utensils"></i> Manage Menus</a>
        <a href="javascript:void(0)" class="nav-item" onclick="toggleModal('modal-gallery-management')"><i class="fas fa-images"></i> Visual Gallery</a>
        <a href="#orders" class="nav-item"><i class="fas fa-moped"></i> Active Orders</a>
    </nav>
</aside>

<main class="main">
    <nav class="breadcrumb-nav">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-home"></i> Home</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Owner Dashboard</span>
    </nav>

    <div class="top-bar">
        <div class="welcome-text">
            <h2>Welcome Back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            <small style="color: #666;">Managing {{ $restaurants->count() }} Establishment(s)</small>
        </div>

        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="globalSearch" onkeyup="globalSearch()" placeholder="Search orders, guests...">
        </div>

        <div class="admin-profile" style="display: flex; align-items: center; gap: 15px;">
            <div style="text-align: right;">
                <span style="font-weight: 600;">{{ Auth::user()->name }}</span><br>
                <small style="color: #D4AF37;">RESTAURANT OWNER</small>
            </div>
            @php
                $photoPath = Auth::user()->profile_photo;
                $showPlaceholder = empty($photoPath) || !file_exists(public_path($photoPath));
            @endphp
            <img src="{{ $showPlaceholder ? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=001f3f&color=D4AF37' : asset($photoPath) }}" 
                 class="profile-img" onclick="toggleModal('modal-profile')" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #D4AF37;">
        </div>
    </div>

    <div class="metrics-grid">
        <div class="metric-card"><small>My Restaurants</small><h3>{{ $restaurants->count() }}</h3></div>
        <div class="metric-card"><small>Active Orders</small><h3>{{ $orders->count() }}</h3></div>
        <div class="metric-card"><small>Total Bookings</small><h3>{{ $bookings->count() }}</h3></div>
        <div class="metric-card"><small>Kitchen Status</small><h3 style="color:#16a34a">Active</h3></div>
    </div>

    <div id="orders" class="section-header" style="margin-top: 40px;">
        <h4><i class="fas fa-shopping-bag" style="color: #D4AF37;"></i> Live Delivery Orders</h4>
    </div>
    <div class="data-container">
        <table id="ordersTable">
            <thead>
                <tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Update Action</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td><span class="badge">{{ strtoupper($order->status) }}</span></td>
                    <td>
                        <form action="{{ route('owner.orders.update-status', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cooking" {{ $order->status == 'cooking' ? 'selected' : '' }}>Cooking</option>
                                <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="bookings" class="section-header" style="margin-top: 40px;">
        <h4><i class="fas fa-calendar-check" style="color: #D4AF37;"></i> Table Reservations</h4>
    </div>
    <div class="data-container">
        <table id="bookingsTable">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Establishment</th>
                    <th>Date & Time</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th>Update Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $book)
                <tr>
                    <td><strong>{{ $book->name }}</strong></td>
                    <td>{{ $book->restaurant->name }}</td>
                    <td>{{ $book->date }} at {{ $book->time }}</td>
                    <td>{{ $book->guests }} Guests</td>
                    <td>
                        <span class="badge {{ 'badge-'.$book->status }}">
                            {{ strtoupper($book->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('owner.bookings.update-status', $book->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px;">
                                <option value="pending" {{ $book->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $book->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                <option value="cancelled" {{ $book->status == 'cancelled' ? 'selected' : '' }}>Decline</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<script>
    function toggleModal(id) {
        const modal = document.getElementById(id);
        modal.style.display = (modal.style.display === 'none' || modal.style.display === '') 
            ? (id === 'modal-menu-management' ? 'block' : 'flex') : 'none';
    }

    function filterTable(inputId, tableId) {
        let input = document.getElementById(inputId);
        let filter = input.value.toLowerCase();
        let table = document.getElementById(tableId);
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let text = tr[i].textContent.toLowerCase();
            tr[i].style.display = text.includes(filter) ? "" : "none";
        }
    }

    function globalSearch() {
        filterTable('globalSearch', 'ordersTable');
        filterTable('globalSearch', 'bookingsTable');
    }

    function updateGalleryAction() {
        const resId = document.getElementById('gallery_res_id').value;
        const form = document.getElementById('galleryForm');
        form.action = `/owner/restaurants/${resId}/gallery`;
    }
</script>

</body>
</html>