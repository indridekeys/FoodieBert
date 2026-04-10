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
        .modal-full-page { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: #fff; z-index: 10000; overflow-y: auto; padding: 40px; animation: fadeIn 0.3s; }
        .modal-overlay { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center; }
        .profile-img:hover { filter: brightness(0.8); cursor: pointer; transition: 0.3s; }
        
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Search Bar Styling */
        .search-container { position: relative; width: 300px; }
        .search-container input { width: 100%; padding: 10px 15px 10px 40px; border-radius: 20px; border: 1px solid #ddd; outline: none; font-family: inherit; transition: border 0.3s; }
        .search-container input:focus { border-color: #D4AF37; }
        .search-container i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #666; }

        .breadcrumb-nav { display: flex; align-items: center; gap: 10px; margin-bottom: 25px; padding: 10px 0; font-size: 0.9rem; }
        .breadcrumb-item { text-decoration: none; color: #001f3f; transition: color 0.3s; }
        .breadcrumb-item:hover { color: #D4AF37; }
        .breadcrumb-current { color: #D4AF37; font-weight: 600; }

        /* Status Badges */
        .badge { padding: 5px 12px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; display: inline-block; text-transform: uppercase; }
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .badge-confirmed { background: #dcfce7; color: #166534; }
        .badge-ready { background: #e0f2fe; color: #075985; }
        .badge-delivered { background: #f3f4f6; color: #374151; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Action Styles */
        .btn-delete { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; padding: 6px 10px; border-radius: 6px; cursor: pointer; transition: 0.3s; }
        .btn-delete:hover { background: #991b1b; color: #fff; }
        .action-cell { display: flex; align-items: center; gap: 8px; }

        /* Alert Box */
        .alert-error { background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #991b1b; }
    </style>
</head>

<body>

{{-- Success Notification --}}
@if(session('success'))
    <div style="position: fixed; top: 20px; right: 20px; background: #001f3f; color: #D4AF37; padding: 15px 25px; border-radius: 8px; z-index: 20000; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-bottom: 3px solid #D4AF37;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div id="modal-recommendation" class="modal-overlay">
    <div style="background: white; padding: 30px; border-radius: 12px; width: 450px; position: relative; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h3 style="color: #001f3f; font-family: 'Playfair Display'; margin-bottom: 10px;">Decline & Recommend</h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 15px;">Give the guest an alternative (e.g., "Full at 7pm, how about 8:30pm?")</p>
        
        <textarea id="recommendation-text" placeholder="Type your suggestion here..." 
                  style="width: 100%; height: 100px; padding: 10px; border-radius: 8px; border: 1px solid #ddd; font-family: inherit; margin-bottom: 15px; resize: none;"></textarea>
        
        <div style="display: flex; gap: 10px;">
            <button onclick="closeRecommendation()" style="flex: 1; padding: 10px; border: none; border-radius: 6px; cursor: pointer; background: #eee;">Cancel</button>
            <button onclick="submitRecommendation()" style="flex: 2; padding: 10px; border: none; border-radius: 6px; cursor: pointer; background: #001f3f; color: #D4AF37; font-weight: bold;">Send Recommendation</button>
        </div>
    </div>
</div>

{{-- Menu Management Modal --}}
<div id="modal-menu-management" class="modal-full-page">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #D4AF37; padding-bottom: 15px;">
            <h2 style="font-family: 'Playfair Display'; color: #001f3f; font-size: 2.5rem;">
                <i class="fas fa-utensils" style="color: #D4AF37;"></i> Menu Management
            </h2>
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="menuSearch" onkeyup="filterTable('menuSearch', 'menuTable')" placeholder="Search menu items...">
            </div>
            <button onclick="toggleModal('modal-menu-management')" style="background:#001f3f; border:none; color: #D4AF37; font-size: 1.5rem; cursor:pointer; padding: 10px 20px; border-radius: 8px;">Close &times;</button>
        </div>

        {{-- Error Handling for Form --}}
        @if ($errors->any())
            <div style="background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 15px; margin-bottom: 20px; border-radius: 6px;">
                <ul style="margin:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('owner.menu.store') }}" method="POST" enctype="multipart/form-data" style="background: #f9f9f9; padding: 30px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #ddd;">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                {{-- Dish Name --}}
                <div class="form-group">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Dish Name</label>
                    <input type="text" name="name" placeholder="e.g. Ndolé with Meat" value="{{ old('name') }}" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                </div>

                {{-- Price --}}
                <div class="form-group">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Price (CFA)</label>
                    <input type="number" name="price" placeholder="5000" value="{{ old('price') }}" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                </div>

                {{-- Restaurant Selection --}}
                <div class="form-group">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Assign Restaurant</label>
                    <select name="restaurant_id" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="" disabled selected>Select Restaurant</option>
                        @foreach($restaurants as $res)
                            <option value="{{ $res->id }}" {{ old('restaurant_id') == $res->id ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px;">
                {{-- Ingredients/Description (Crucial for the Public Page) --}}
                <div class="form-group">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Ingredients / Description</label>
                    <input type="text" name="ingredients" placeholder="e.g. Bitter leaves, peanuts, spices, served with plantains" value="{{ old('ingredients') }}" style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                </div>

                {{-- Image Upload --}}
                <div class="form-group">
                    <label style="display:block; font-weight:bold; margin-bottom:5px;">Dish Image</label>
                    <input type="file" name="image" accept="image/*" style="width:100%; padding: 8px; background: white; border-radius: 6px; border: 1px solid #ddd;">
                </div>
            </div>

            <button type="submit" style="margin-top: 25px; width: 100%; background: #001f3f; color: #D4AF37; padding: 15px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: 0.3s; font-size: 1.1rem;">
                <i class="fas fa-plus-circle"></i> ADD DISH TO COLLECTION
            </button>
        </form>

        <div class="data-container" style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden;">
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
                    @forelse($menuItems as $item)
                    <tr style="border-bottom: 1px solid #eee; transition: 0.2s; hover: background: #fdfdfd;">
                        {{-- Image Column with fallback logic --}}
                        <td style="padding: 15px;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px; border: 1px solid #eee;">
                            @else
                                <div style="width: 70px; height: 70px; background: #f3f4f6; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.7rem; text-align: center; border: 1px dashed #ccc;">
                                    No Image
                                </div>
                            @endif
                        </td>
                        
                        {{-- Name and Ingredients --}}
                        <td style="padding: 15px;">
                            <strong style="font-size: 1.1rem; color: #001f3f; display: block;">{{ $item->name }}</strong>
                            <small style="color: #666; font-style: italic;">{{ $item->ingredients ?? 'No ingredients listed' }}</small>
                        </td>

                        <td style="padding: 15px; color: #666;">{{ $item->restaurant->name }}</td>
                        
                        <td style="padding: 15px; font-weight: bold; color: #001f3f;">
                            {{ number_format($item->price) }} <span style="font-size: 0.8rem;">CFA</span>
                        </td>

                        <td style="text-align: right; padding: 15px;">
                            <form action="{{ route('owner.menus.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: 0.3s;" onclick="return confirm('Permanently delete {{ $item->name }}?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color: #999;">
                            <i class="fas fa-box-open" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                            Your menu is currently empty.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Profile Modal --}}
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

{{-- Gallery Modal --}}
<div id="modal-gallery-management" class="modal-full-page">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #D4AF37; padding-bottom: 15px;">
            <h2 style="font-family: 'Playfair Display'; color: #001f3f; font-size: 2.5rem;"><i class="fas fa-images" style="color: #D4AF37;"></i> Visual Feast Management</h2>
            <button onclick="toggleModal('modal-gallery-management')" style="background:#001f3f; border:none; color: #D4AF37; font-size: 1.5rem; cursor:pointer; padding: 10px 20px; border-radius: 8px;">Close &times;</button>
        </div>

        <div style="background: #f9f9f9; padding: 30px; border-radius: 12px; margin-bottom: 40px; border: 1px solid #ddd;">
            <h4 style="margin-bottom: 15px; color: #001f3f; font-family: 'Playfair Display';">Add New Visuals</h4>
            
            @if($restaurants->count() > 0)
                <form id="galleryForm" action="{{ route('owner.gallery.store', $restaurants->first()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 15px; align-items: end;">
                        <div>
                            <label style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Item Name</label>
                            <input type="text" name="name" placeholder="e.g. Signature Steak" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        </div>

                        <div>
                            <label style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Price ($)</label>
                            <input type="number" name="price" step="0.01" placeholder="0.00" required style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        </div>

                        <div>
                            <label style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Select Restaurant</label>
                            <select name="restaurant_id" id="gallery_res_id" required onchange="updateGalleryFormAction(this.value)" style="width:100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                                @foreach($restaurants as $res)
                                    <option value="{{ $res->id }}">{{ $res->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label style="display:block; margin-bottom:10px; font-size:0.8rem; font-weight:bold;">Upload Photo</label>
                            <input type="file" name="images[]" multiple accept="image/*" required style="padding: 8px; width:100%;">
                        </div>
                    </div>

                    <button type="submit" style="margin-top: 20px; width: 100%; background: #001f3f; color: #D4AF37; padding: 15px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt"></i> UPLOAD TO GALLERY
                    </button>
                </form>
            @else
                <p style="color: #888;">Please create a restaurant first.</p>
            @endif
        </div>

        <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; padding-bottom: 50px;">
            @foreach($restaurants as $res)
                @if($res->gallery)
                    @foreach($res->gallery as $photo)
                    <div style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid #eee; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                        <img src="{{ asset('storage/' . $photo->path) }}" style="width: 100%; height: 220px; object-fit: cover; display: block;">
                        
                        <div style="padding: 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <h5 style="margin: 0; color: #001f3f; font-family: 'Playfair Display'; font-size: 1.1rem; font-weight: bold;">
                                    {{ $photo->name ?? 'Untitled Item' }}
                                </h5>
                                <span style="color: #D4AF37; font-weight: 800;">
                                    ${{ number_format($photo->price ?? 0, 2) }}
                                </span>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f0f0f0; padding-top: 10px; margin-top: 5px;">
                                <small style="color: #999; text-transform: uppercase; font-size: 0.7rem; font-weight: 600;">
                                    <i class="fas fa-utensils"></i> {{ $res->name }}
                                </small>
                                
                                <form action="{{ route('owner.gallery.destroy', $photo->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" style="background: #fff0f0; color: #dc3545; border: 1px solid #f8d7da; width: 32px; height: 32px; border-radius: 50%; cursor: pointer;" onclick="return confirm('Remove image?')">
                                        <i class="fas fa-trash" style="font-size: 0.8rem;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            @endforeach
        </div>
    </div>
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

    {{-- Orders Table --}}
    <div id="orders" class="section-header" style="margin-top: 40px;">
        <h4><i class="fas fa-shopping-bag" style="color: #D4AF37;"></i> Live Delivery Orders</h4>
    </div>
    <div class="data-container">
        <table id="ordersTable">
            <thead>
                <tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Update Action</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ $order->status }}</span></td>
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
                @empty
                <tr><td colspan="4" style="text-align:center; padding:20px;">No active orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Bookings Table --}}
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
                @forelse($bookings as $book)
                <tr>
                    <td><strong>{{ $book->name }}</strong></td>
                    <td>{{ $book->restaurant->name }}</td>
                    <td>{{ $book->date }} at {{ $book->time }}</td>
                    <td>{{ $book->guests }} Guests</td>
                    <td><span class="badge badge-{{ $book->status }}">{{ $book->status }}</span></td>
                    <td>
                        <div class="action-cell">
                            <form action="{{ route('owner.bookings.update-status', $book->id) }}" method="POST" id="status-form-{{ $book->id }}">
                                @csrf @method('PATCH')
                                <select name="status" onchange="handleBookingStatusChange(this, '{{ $book->id }}')" style="padding: 5px; border-radius: 4px;">
                                    <option value="pending" {{ $book->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $book->status == 'confirmed' ? 'selected' : '' }}>Confirm</option>
                                    <option value="cancelled" {{ $book->status == 'cancelled' ? 'selected' : '' }}>Decline & Recommend</option>
                                </select>
                                <input type="hidden" name="recommendation" id="recommendation-input-{{ $book->id }}">
                            </form>
                            <form action="{{ route('owner.bookings.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this reservation?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center; padding:20px;">No reservations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
    let activeBookingId = null;

    function handleBookingStatusChange(select, bookingId) {
        if (select.value === 'cancelled') {
            activeBookingId = bookingId;
            toggleModal('modal-recommendation');
        } else {
            select.form.submit();
        }
    }

    function submitRecommendation() {
        if (!activeBookingId) return;
        const note = document.getElementById('recommendation-text').value;
        const form = document.getElementById('status-form-' + activeBookingId);
        const input = document.getElementById('recommendation-input-' + activeBookingId);
        input.value = note;
        form.submit();
    }

    function closeRecommendation() {
        toggleModal('modal-recommendation');
        location.reload(); 
    }

    function toggleModal(id) {
        const modal = document.getElementById(id);
        const isCenterModal = id === 'modal-profile' || id === 'modal-recommendation';
        const currentDisplay = window.getComputedStyle(modal).display;
        modal.style.display = (currentDisplay === 'none') ? (isCenterModal ? 'flex' : 'block') : 'none';
    }

    function filterTable(inputId, tableId) {
        let filter = document.getElementById(inputId).value.toLowerCase();
        let rows = document.getElementById(tableId).getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = rows[i].textContent.toLowerCase().includes(filter) ? "" : "none";
        }
    }

    function globalSearch() {
        filterTable('globalSearch', 'ordersTable');
        filterTable('globalSearch', 'bookingsTable');
    }

  
/**
 * Update the Form Action URL dynamically when the restaurant selection changes
 */
function updateGalleryFormAction(restaurantId) {
    const form = document.getElementById('galleryForm');
    let url = "{{ route('owner.gallery.store', ':id') }}";
    form.action = url.replace(':id', restaurantId);
}

</script>

</body>
</html>