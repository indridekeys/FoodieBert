<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FoodieBert | Super Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
</head>

<body>

<div id="viewMessageModal" class="modal-overlay" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: #fff; padding: 30px; border-radius: 12px; width: 550px; position: relative; color: #333; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        <i class="fas fa-times" onclick="toggleModal('viewMessageModal')" style="position: absolute; top: 15px; right: 20px; color: #666; cursor: pointer; font-size: 1.2rem;"></i>
        
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
            <i class="fas fa-envelope-open" style="color: #D4AF37;"></i>
            <h3 id="msg-subject" style="color: #001f3f; margin: 0; font-family: 'Playfair Display';"></h3>
        </div>
        
        <p style="font-size: 0.9rem; margin-bottom: 15px;">
            <strong>From:</strong> <span id="msg-sender"></span> 
            <span id="msg-email" style="color: #666; font-style: italic;"></span>
        </p>
        
        <div id="msg-body" style="line-height: 1.6; color: #444; background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #001f3f; margin-bottom: 25px; max-height: 200px; overflow-y: auto; white-space: pre-wrap;"></div>

        <div style="border-top: 2px solid #eee; padding-top: 20px;">
            <h4 style="margin-top: 0; font-size: 0.85rem; color: #001f3f; text-transform: uppercase; letter-spacing: 1px;">
                <i class="fas fa-reply"></i> Official Reply
            </h4>
            <form id="replyForm" action="{{ route('admin.messages.reply') }}" method="POST">
                @csrf
                <input type="hidden" name="recipient_email" id="reply-recipient-email">
                <input type="hidden" name="original_subject" id="reply-original-subject">
                <input type="hidden" name="message_id" id="reply-message-id">
                
                <textarea name="reply_content" required placeholder="Type your response to the citizen here..." 
                    style="width: 100%; height: 120px; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; resize: none; margin-bottom: 15px; outline: none; transition: border 0.3s;"
                    onfocus="this.style.border='1px solid #D4AF37'"></textarea>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn-primary" style="flex: 2; background: #001f3f; border: 1px solid #001f3f; padding: 12px; border-radius: 6px; font-weight: 600;">
                        <i class="fas fa-paper-plane"></i> Dispatch Reply
                    </button>
                    <button type="button" onclick="toggleModal('viewMessageModal')" style="flex: 1; background: #f4f4f4; border: none; padding: 12px; border-radius: 6px; cursor: pointer; color: #666;">
                        Discard
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addUserModal" class="modal-overlay" style="display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
    <div class="modal-content" style="background: #1a1a1a; padding: 30px; border-radius: 8px; width: 450px; border: 1px solid var(--accent-gold); position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
        
        <i class="fas fa-times" onclick="toggleModal('addUserModal')" style="position: absolute; top: 15px; right: 20px; color: #666; cursor: pointer; font-size: 1.2rem; transition: 0.3s;" onmouseover="this.style.color='var(--accent-gold)'" onmouseout="this.style.color='#666'"></i>

        <h3 style="color: var(--accent-gold); margin-top: 0; margin-bottom: 25px;">Add New Citizen</h3>
        
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 15px;">
                <label style="color: #ccc;">Name</label><br>
                <input type="text" name="name" required style="width: 100%; padding: 8px; background: #2a2a2a; border: 1px solid #444; color: white; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #ccc;">Email</label><br>
                <input type="email" name="email" required style="width: 100%; padding: 8px; background: #2a2a2a; border: 1px solid #444; color: white; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="color: #ccc;">Profile Picture</label><br>
                <input type="file" name="profile_picture" accept="image/*" style="color: #ccc; font-size: 0.8rem; margin-top: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="color: #ccc;">Role</label><br>
                <select name="role" style="width: 100%; padding: 8px; background: #2a2a2a; border: 1px solid #444; color: white; border-radius: 4px;">
                    <option value="customer">Custumer</option>
                    <option value="owner">Owner</option>
                    <option value="agent">Agent</option>
                </select>
            </div>

            <div style="text-align: right; border-top: 1px solid #333; padding-top: 20px;">
                <button type="button" onclick="toggleModal('addUserModal')" class="btn-secondary" style="margin-right: 10px;">Cancel</button>
                <button type="submit" class="btn-primary">Save Citizen</button>
            </div>
        </form>
    </div>
</div>
    <div class="modal-overlay" id="modal-restaurant-section" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #fff; z-index: 1000;">
    <div class="modal-content" style="width: 100vw; height: 100vh; max-width: none; border-radius: 0; overflow-y: auto; padding: 40px;">
        
        <div class="search-wrapper" style="max-width: 1200px; margin: 0 auto 30px auto; display: flex; align-items: center; gap: 15px;">
            <div style="position: relative; flex: 1;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                <input type="text" id="restaurantSearch" onkeyup="filterRestaurants()" placeholder="Search by name, matricule, or category..." 
                       style="width: 100%; padding: 15px 15px 15px 45px; border-radius: 12px; border: 1px solid #e0e0e0; font-size: 1rem; outline: none; transition: border 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
            </div>
            <div style="color: #666; font-size: 0.9rem; font-weight: 500;">
                Showing <span id="visibleCount">{{ count($restaurants) }}</span> establishments
            </div>
        </div>
        
        <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f4f4f4; padding-bottom: 20px; margin-bottom: 30px; max-width: 1200px; margin: 0 auto;">
            <h2 style="font-family: 'Playfair Display'; margin: 0; font-size: 2rem; color: #001f3f;">
                <i class="fas fa-building-columns" style="color: #D4AF37;"></i> Restaurant Registry
            </h2>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('admin.restaurants.export.pdf') }}" class="btn-secondary" style="padding: 10px 20px; background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-radius: 8px; text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-file-export"></i> Export All (PDF)
                </a>
                <button class="btn-primary" onclick="prepareAddRestaurant()" style="padding: 10px 25px; background: #001f3f; color: #D4AF37; border: 1px solid #D4AF37; border-radius: 8px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-plus"></i> Add New
                </button>
                <button onclick="closeModal('modal-restaurant-section')" style="background:#f8f9fa; border:1px solid #ddd; padding: 10px 20px; border-radius: 8px; cursor:pointer;">
                    <i class="fas fa-times"></i> Exit
                </button>
            </div>
        </div>

        <div class="data-container" style="max-width: 1200px; margin: 0 auto;">
            <table id="restaurantTable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #eee; color: #666; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                        <th style="padding: 15px;">Visual</th>
                        <th>Matricule</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Status</th> 
                        <th>Owner</th>
                        <th style="text-align: right; padding-right: 15px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $res)
                    <tr style="border-bottom: 1px solid #fafafa; transition: background 0.2s;" onmouseover="this.style.background='#fffcf5'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">
                            <img src="{{ $res->image_url ? asset('storage/' . $res->image_url) : 'https://via.placeholder.com/100' }}" 
                                 style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1px solid #eee;">
                        </td>
                        <td><code style="background: #f0f0f0; padding: 4px 8px; border-radius: 4px; color: #001f3f; font-weight: bold;">{{ $res->matricule ?? 'N/A' }}</code></td>
                        <td><strong>{{ $res->name }}</strong></td>
                        <td>
                            <span class="badge" style="background:#eef2ff; color:#4338ca; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem;">
                                {{ $res->category }}
                            </span>
                        </td>
                        <td>
                            @if($res->status === 'open')
                                <span style="display: flex; align-items: center; gap: 6px; color: #10b981; font-weight: 700; font-size: 0.75rem;">
                                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 5px #10b981;"></span>
                                    ONLINE
                                </span>
                            @else
                                <span style="display: flex; align-items: center; gap: 6px; color: #ef4444; font-weight: 700; font-size: 0.75rem;">
                                    <span style="width: 8px; height: 8px; background: #ef4444; border-radius: 50%; display: inline-block;"></span>
                                    OFFLINE
                                </span>
                            @endif
                        </td>
                        <td><span style="font-size: 0.9rem; color: #555;">{{ $res->owner_name }}</span></td>
                        <td style="text-align: right; padding-right: 15px;">
                            <div style="display: flex; justify-content: flex-end; gap: 15px; align-items: center;">
                                <a href="{{ route('admin.restaurants.pdf', $res->id) }}" title="Download PDF Report" style="color: #dc2626; font-size: 1.1rem; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                    <i class="fas fa-file-pdf"></i>
                                </a>

                                <i class="fas fa-pen-to-square" onclick='editRestaurant(@json($res))' style="color:#001f3f; cursor:pointer; font-size: 1.1rem;" title="Edit Establishment"></i>
                                
                                <form action="{{ route('admin.restaurants.destroy', $res->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="background:none; border:none; color:#94a3b8; cursor:pointer; padding: 0;" onclick="return confirm('Delete this establishment from registry?')">
                                        <i class="fas fa-trash" style="font-size: 1.1rem;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <!-- ======================= RESTAURANT UPDATE START ===================== -->
 <div class="modal-overlay" id="modal-res" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 31, 63, 0.9); z-index: 1100; backdrop-filter: blur(5px);">
    <div class="modal-content" style="width: 100vw; height: 100vh; max-width: none; overflow-y: auto; padding: 60px 40px; background: #fff;">
        <div style="max-width: 900px; margin: 0 auto;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 2px solid #f4f4f4; padding-bottom: 20px;">
                <h3 id="modal-title" style="font-family: 'Playfair Display', serif; margin: 0; font-size: 2rem; color: #004d40;">
                    <i class="fas fa-plus-circle" style="color: #D4AF37;"></i> New Establishment
                </h3>
                <button onclick="closeModal('modal-res')" style="background: none; border: none; font-size: 2rem; cursor: pointer; color: #004d40;">&times;</button>
            </div>

            <form id="restaurantForm" action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">ESTABLISHMENT NAME</label>
                        <input type="text" name="name" id="field-name" class="form-control" required style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">CATEGORY</label>
                        <select name="category" id="field-category" class="form-control" style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background: #fff;">
                            <option value="Fine Dining">Fine Dining</option>
                            <option value="Cafe">Cafe</option>
                            <option value="Casual Eateries">Casual Eateries</option>
                            <option value="Snack Bars">Snack Bars</option>
                            <option value="Fast Food">Fast Food</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">PROPRIETOR NAME</label>
                        <input type="text" name="owner_name" id="field-owner-name" class="form-control" required style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">OWNER EMAIL</label>
                        <input type="email" name="owner_email" id="field-owner-email" class="form-control" required style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">LOCATION ADDRESS (BERTOUA)</label>
                    <input type="text" name="location" id="field-location" class="form-control" required style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">DESCRIPTION</label>
                    <textarea name="description" id="field-description" rows="4" style="width:100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; resize: none;"></textarea>
                </div>

                <div style="margin-bottom: 40px;">
                    <label style="font-size:0.75rem; font-weight:700; color:#004d40; display:block; margin-bottom:10px; letter-spacing: 1px;">UPLOAD IMAGE</label>
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <img id="imagePreview" src="https://via.placeholder.com/100" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover; border: 2px solid #D4AF37;">
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)" style="flex: 1; padding: 15px; border: 2px dashed #ddd; border-radius: 8px;">
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <button type="submit" class="btn-primary" style="flex: 2; padding: 20px; font-weight: 700; border-radius: 10px; font-size: 1rem; background: #004d40; color: #D4AF37; border: 1px solid #D4AF37; cursor: pointer;">Save Establishment Data</button>
                    <button type="button" onclick="closeModal('modal-res')" style="flex: 1; background: #f4f4f4; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; color: #666;">Go Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
   <!-- ======================= RESTAURANT UPDATE END ===================== -->


    <div class="modal-overlay" id="modal-account">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                <h3 style="font-family: 'Playfair Display'; color: var(--primary-blue);">Account Mastery</h3>
                <button onclick="closeModal('modal-account')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="profile-setup-grid">
                    <div style="text-align: center;">
                        <img id="profile-preview" src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-preview-large">
                        <label class="btn-primary" style="font-size: 0.7rem; justify-content: center; cursor: pointer;">
                            Change Photo <input type="file" name="profile_photo" hidden onchange="previewProfileImage(event)">
                        </label>
                    </div>
                    <div>
                        <div style="margin-bottom:15px;"><label style="font-size:0.65rem; font-weight:700; color: var(--text-muted);">NAME</label><input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control"></div>
                        <div style="margin-bottom:15px;"><label style="font-size:0.65rem; font-weight:700; color: var(--text-muted);">EMAIL</label><input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control"></div>
                        <button type="submit" class="btn-primary" style="width:100%; justify-content: center;">Save Identity</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<aside class="sidebar">
        <div class="logo-section">
            <img src="{{ asset('uploads/logo.png') }}" class="logo-icon">
            <h1>FoodieBert</h1>
        </div>
        <div class="tagline">Admin Dashboard</div>
        <nav style="flex-grow: 1;">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Global Metrics
            </a>
            <a href="javascript:void(0)" class="nav-item" onclick="showModal('modal-restaurant-section')">
                <i class="fas fa-building-columns"></i> Restaurant Registry
            </a>
            <a href="#users" class="nav-item"><i class="fas fa-users-viewfinder"></i> User Directory</a>

            <a href="#partners" class="nav-item"><i class="fas fa-handshake"></i> Partner Portals</a>
            <a href="#activity" class="nav-item"><i class="fas fa-bell"></i> Live Activity</a>
            <a href="#messages" class="nav-item" style="position: relative; display: flex; align-items: center; gap: 10px;">
    <i class="fas fa-envelope"></i> 
    <span>Message Center</span>
    
    @php
        $unreadCount = \App\Models\Contact::where('is_read', false)->count();
    @endphp

    @if($unreadCount > 0)
        <span style="
            background: #ef4444; 
            color: white; 
            font-size: 0.65rem; 
            font-weight: bold; 
            padding: 2px 6px; 
            border-radius: 50%; 
            position: absolute; 
            right: 15px; 
            top: 50%; 
            transform: translateY(-50%);
            box-shadow: 0 0 8px rgba(239, 68, 68, 0.5);
            border: 2px solid #1a1a1a;">
            {{ $unreadCount }}
        </span>
    @endif
</a>
            <a href="#settings" class="nav-item"><i class="fas fa-shield-halved"></i> System Core</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf 
            <button type="submit" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid var(--accent-gold); color:var(--accent-gold); padding:12px; border-radius:12px; cursor:pointer;">
                <i class="fas fa-power-off"></i> Secure Logout
            </button>
        </form>
    </aside>

    <main class="main">
        <nav class="breadcrumb-nav">
            <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Super Admin</span>
        </nav>

        <div class="top-bar">
            <div class="welcome-text">
                <h2>Welcome, {{ explode(' ', Auth::user()->name)[0] }}!!!</h2>
            </div>
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="dashboardSearch" class="search-input" onkeyup="globalDashboardSearch()" placeholder="Search anything in the dashboard...">
            </div>
            <div class="admin-profile" onclick="showModal('modal-account')">
                <div style="text-align: right;"><span style="display: block; font-weight: 600;">{{ Auth::user()->name }}</span><small style="color: var(--accent-gold); font-weight: 700; font-size: 0.6rem;">MASTER ADMIN</small></div>
                <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-img">
            </div>
        </div>

        <div class="metrics-grid">
            <div class="metric-card"><small>Total Citizens</small><h3>{{ $users->count() }}</h3></div>
            <div class="metric-card"><small>Establishments</small><h3>{{ $restaurantCount }}</h3></div>
            <div class="metric-card"><small>Daily Bookings</small><h3>{{ $reservations->count() }}</h3></div>
            <div class="metric-card"><small>System Pulse</small><h3 style="color:#16a34a">Optimal</h3></div>
        </div>

        <div id="activity" class="section-header" style="margin-top: 40px;">
            <h4><i class="fas fa-calendar-check" style="color: var(--accent-gold);"></i> Reservation Management</h4>
        </div>
        <div class="data-container">
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <thead>
                    <tr style="background: #001f3f; color: #D4AF37; text-align: left;">
                        <th style="padding: 15px;">Guest</th>
                        <th style="padding: 15px;">Restaurant</th>
                        <th style="padding: 15px;">Date & Time</th>
                        <th style="padding: 15px;">Status</th>
                        <th style="padding: 15px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $res)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">{{ $res->guest_name }}</td>
                        <td style="padding: 15px;">{{ $res->restaurant->name }}</td>
                        <td style="padding: 15px;">{{ \Carbon\Carbon::parse($res->reservation_time)->format('d M, H:i') }}</td>
                        <td style="padding: 15px;">
                            <span style="padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight:700; text-transform:uppercase; 
                                background: {{ $res->status == 'pending' ? '#FFF9E6' : '#E6F4EA' }}; 
                                color: {{ $res->status == 'pending' ? '#D4AF37' : '#1E7E34' }}; 
                                border: 1px solid {{ $res->status == 'pending' ? '#F3E5AB' : '#CEEAD6' }};">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <button onclick="viewReservationDetails({{ json_encode($res) }})" style="background: #001f3f; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px;">
                                <i class="fas fa-eye"></i> Details
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="users" class="section-header" style="margin-top: 40px; display: flex; justify-content: space-between; align-items: center;">
    <h4><i class="fas fa-user-shield" style="color: var(--accent-gold);"></i> Citizen Management</h4>
    <div>
        <a href="{{ route('admin.users.export') }}" class="btn-secondary" style="border: 1px solid #444; padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-csv" style="color: #28a745;"></i> Export CSV
        </a>
        <button class="btn-primary" onclick="toggleModal('addUserModal')" style="margin-left: 10px;">
            <i class="fas fa-plus"></i> Add User
        </button>
    </div>
</div>

<div class="data-container">
    <table id="userTable">
        <thead>
            <tr>
                <th>Profile</th>
                <th>Matricule</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th style="text-align: center;">Registry Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>
                    <div style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--accent-gold); overflow: hidden; background: #2a2a2a; display: flex; align-items: center; justify-content: center;">
                        @if($u->profile_picture)
                            <img src="{{ asset('storage/'.$u->profile_picture) }}" alt="User" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-user-tie" style="color: var(--accent-gold); font-size: 1.2rem;"></i>
                        @endif
                    </div>
                </td>
                <td><code class="matricule">{{ $u->matricule ?? 'FB-USR-'.$u->id }}</code></td>
                <td><strong>{{ $u->name }}</strong></td>
                <td>{{ $u->email }}</td>
                <td><span style="font-size: 0.8rem; opacity: 0.8;">{{ strtoupper($u->role) }}</span></td>
                <td>
                    <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                        <a href="{{ route('admin.restaurants.pdf', $u->id) }}" class="btn-secondary" style="padding: 5px 10px; font-size: 0.75rem; border: 1px solid #dc3545; color: #fff; text-decoration: none; border-radius: 3px;" title="Download ID Card">
                            <i class="fas fa-file-pdf" style="color: #ff4444;"></i> PDF
                        </a>

                        @if($u->role !== 'super_admin')
                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Banish user from registry?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-outline" style="padding: 5px 10px; font-size: 0.75rem;">
                                    <i class="fas fa-user-xmark"></i> Delete
                                </button>
                            </form>
                        @else
                            <span style="color: var(--accent-gold); font-size: 0.7rem; font-weight: 800; border: 1px solid var(--accent-gold); padding: 2px 6px; border-radius: 3px;">
                                <i class="fas fa-crown"></i> IMMUTABLE
                            </span>
                        @endif 
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

       <div id="messages" class="section-header" style="margin-top: 40px;">
            <h4><i class="fas fa-envelope-open-text" style="color: var(--accent-gold);"></i> Inbound Inquiries</h4>
        </div>

        <div class="data-container">
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <thead>
                    <tr style="background: #001f3f; color: #D4AF37; text-align: left;">
                        <th style="padding: 15px;">Sender</th>
                        <th style="padding: 15px;">Subject</th>
                        <th style="padding: 15px;">Status</th>
                        <th style="padding: 15px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- FIXED: Using $contactMessages to match your controller --}}
                    @foreach($contactMessages as $msg)
                    <tr style="border-bottom: 1px solid #eee; {{ $msg->is_read ? '' : 'background: #fdfcf0;' }}">
                        <td style="padding: 15px;">
                            <strong>{{ $msg->name }}</strong><br>
                            <small style="color: #666;">{{ $msg->email }}</small>
                        </td>
                        <td style="padding: 15px;">{{ $msg->subject }}</td>
                        <td style="padding: 15px;">
                            @if($msg->status == 'replied')
                                <span style="background: #e6f4ea; color: #1e7e34; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; border: 1px solid #ceead6;">
                                    <i class="fas fa-check-double"></i> REPLIED
                                </span>
                            @else
                                <span style="background: #fff9e6; color: #d4af37; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; border: 1px solid #f3e5ab;">
                                    <i class="fas fa-clock"></i> PENDING
                                </span>
                            @endif
                        </td>
                        <td style="padding: 15px;">
                            <button onclick='viewMessage(@json($msg))' style="background: #001f3f; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px;">
                                <i class="fas fa-reply"></i> Open & Reply
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </main>

<script>
    
    // --- Modal Control Logic ---
    function showModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'flex';
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none';
    }

    function toggleModal(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'flex' : 'none';
    }

    // --- Restaurant Logic ---
    function prepareAddRestaurant() {
        const form = document.getElementById('restaurantForm');
        const title = document.getElementById('modal-title');
        
        form.reset();
        form.action = "{{ route('admin.restaurants.store') }}";
        document.getElementById('form-method').value = "POST";
        title.innerHTML = '<i class="fas fa-plus-circle" style="color: var(--accent-gold);"></i> New Establishment';
        document.getElementById('imagePreview').src = "https://via.placeholder.com/100";
        
        showModal('modal-res');
    }

   
    
    function editRestaurant(res) {
    const form = document.getElementById('restaurantForm');
    const title = document.getElementById('modal-title');
    const methodInput = document.getElementById('form-method');
    
    // 1. Update the URL to include the ID
    form.action = `/admin/restaurants/${res.id}`;
    
    // 2. Change method to PUT (Fixes the 405 error)
    methodInput.value = "PUT";
    
    // 3. Update Visuals
    title.innerHTML = '<i class="fas fa-edit" style="color: #D4AF37;"></i> Update ' + res.name;
    
    // 4. Populate Fields
    document.getElementById('field-name').value = res.name;
    document.getElementById('field-category').value = res.category;
    document.getElementById('field-owner-name').value = res.owner_name;
    document.getElementById('field-owner-email').value = res.owner_email;
    document.getElementById('field-location').value = res.location;
    document.getElementById('field-description').value = res.description;
    
    // 5. Image Preview Handling
    if(res.image_url) {
        document.getElementById('imagePreview').src = `/storage/${res.image_url}`;
    } else {
        document.getElementById('imagePreview').src = "https://via.placeholder.com/100";
    }
    
    showModal('modal-res');
}

// Ensure you call this function when clicking the "Add New Restaurant" button
function openAddModal() {
    const form = document.getElementById('restaurantForm');
    const title = document.getElementById('modal-title');
    const methodInput = document.getElementById('form-method');

    // Reset to store route and POST method
    form.action = "{{ route('admin.restaurants.store') }}";
    methodInput.value = "POST";
    
    title.innerHTML = '<i class="fas fa-plus-circle" style="color: #D4AF37;"></i> Register New Establishment';
    
    form.reset();
    document.getElementById('imagePreview').src = "https://via.placeholder.com/100";
    showModal('modal-res');
}


// Add this function to your "Add New" button to clear the form properly
function openAddModal() {
    const form = document.getElementById('restaurantForm');
    const title = document.getElementById('modal-title');
    const methodField = document.getElementById('form-method');
    
    // Reset to Store Route and POST method
    form.action = "{{ route('admin.restaurants.store') }}";
    methodField.value = "POST";
    
    // Reset Title
    title.innerHTML = '<i class="fas fa-plus-circle" style="color: #D4AF37;"></i> Register New Establishment';
    
    // Clear the form
    form.reset();
    document.getElementById('imagePreview').src = "https://via.placeholder.com/100";
    
    showModal('modal-res');
}

    // --- Message & Reply Logic ---
    function viewMessage(msg) {
        // Populate the display fields
        document.getElementById('msg-subject').innerText = msg.subject;
        document.getElementById('msg-sender').innerText = msg.name;
        document.getElementById('msg-email').innerText = `(${msg.email})`;
        document.getElementById('msg-body').innerText = msg.message;

        // Populate the hidden form fields for the reply
        document.getElementById('reply-recipient-email').value = msg.email;
        document.getElementById('reply-original-subject').value = msg.subject;
        document.getElementById('reply-message-id').value = msg.id;

        // Clear previous reply text
        const replyTextarea = document.querySelector('#replyForm textarea');
        if (replyTextarea) replyTextarea.value = '';

        showModal('viewMessageModal');
    }

    // --- Image Previews ---
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewProfileImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // --- Search Filters ---
    function filterRestaurants() {
        let input = document.getElementById('restaurantSearch').value.toLowerCase();
        let rows = document.querySelectorAll("#restaurantTable tbody tr");
        let count = 0;
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if(text.includes(input)) {
                row.style.display = "";
                count++;
            } else {
                row.style.display = "none";
            }
        });
        document.getElementById('visibleCount').innerText = count;
    }

    function globalDashboardSearch() {
        let input = document.getElementById('dashboardSearch').value.toLowerCase();
        // This targets all rows in all tables within your data containers
        let rows = document.querySelectorAll(".data-container table tbody tr");
        
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
        });
    }
</script>

</body>
</html>