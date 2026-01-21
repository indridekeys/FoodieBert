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

    <div class="modal-overlay" id="modal-res">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h3 style="font-family: 'Playfair Display';"><i class="fas fa-plus-circle" style="color: var(--accent-gold);"></i> New Establishment</h3>
                <button onclick="closeModals()" style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>
            <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div style="margin-bottom:15px;"><label style="font-size:0.7rem; font-weight:700;">NAME</label><input type="text" name="name" class="form-control" required></div>
                    <div style="margin-bottom:15px;"><label style="font-size:0.7rem; font-weight:700;">CATEGORY</label>
                        <select name="category" class="form-control">
                            <option value="Fine Dining">Fine Dining</option>
                            <option value="Cafe">Cafe</option>
                            <option value="Bistro">Bistro</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:15px;"><label style="font-size:0.7rem; font-weight:700;">PROPRIETOR NAME</label><input type="text" name="owner_name" class="form-control" required></div>
                <div style="margin-bottom:15px;"><label style="font-size:0.7rem; font-weight:700;">LOCATION</label><input type="text" name="location" class="form-control" required></div>
                <div style="margin-bottom:25px;">
                    <label style="font-size:0.7rem; font-weight:700;">ESTABLISHMENT IMAGE</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn-primary" style="width:100%; justify-content: center; padding: 15px;">Register Establishment</button>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modal-account">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                <h3 style="font-family: 'Playfair Display'; color: var(--primary-blue);">Account Mastery</h3>
                <button onclick="closeModals()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="profile-setup-grid">
                    <div style="text-align: center;">
                        <img id="profile-preview" src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-preview-large">
                        <label class="btn-primary" style="font-size: 0.7rem; justify-content: center; cursor: pointer;">
                            Change Photo <input type="file" name="profile_photo" hidden onchange="previewImage(event)">
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
        <div class="logo-section"><img src="{{ asset('uploads/logo.png') }}" class="logo-icon"><h1>FoodieBert</h1></div>
        <div class="tagline">Empire Command</div>
        <nav style="flex-grow: 1;">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fas fa-chart-line"></i> Global Metrics</a>
            <a href="#restaurants" class="nav-item"><i class="fas fa-hotel"></i> Restaurant Registry</a>
            <a href="#users" class="nav-item"><i class="fas fa-users-viewfinder"></i> User Directory</a>
            <a href="#partners" class="nav-item"><i class="fas fa-handshake"></i> Partner Portals</a>
            <a href="#activity" class="nav-item"><i class="fas fa-bell"></i> Live Activity</a>
            <a href="#settings" class="nav-item"><i class="fas fa-shield-halved"></i> System Core</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit" style="width:100%; background:rgba(255,255,255,0.05); border:1px solid var(--accent-gold); color:var(--accent-gold); padding:12px; border-radius:12px; cursor:pointer;"><i class="fas fa-power-off"></i> Secure Logout</button></form>
    </aside>

    <main class="main">
        <nav class="breadcrumb-nav">
    <a href="{{ url('/') }}" class="breadcrumb-item">
        <i class="fas fa-home"></i> Home
    </a>
    <span class="breadcrumb-separator">/</span>
    <span class="breadcrumb-current">Super Admin</span>
</nav>
        <div class="top-bar">
            <div class="welcome-text">
                <h2>Welcome, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            </div>
            
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" id="dashboardSearch" class="search-input" placeholder="Search anything in the dashboard...">
            </div>

            <div class="admin-profile" onclick="showModal('modal-account')">
                <div style="text-align: right;"><span style="display: block; font-weight: 600;">{{ Auth::user()->name }}</span><small style="color: var(--accent-gold); font-weight: 700; font-size: 0.6rem;">MASTER ADMIN</small></div>
                <img src="{{ Auth::user()->profile_photo ? asset(Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-img">
            </div>
        </div>

        <div class="metrics-grid">
            <div class="metric-card"><small>Total Citizens</small><h3>{{ $users->count() }}</h3></div>
            <div class="metric-card"><small>Establishments</small><h3>{{ $restaurantCount }}</h3></div>
            <div class="metric-card"><small>Daily Bookings</small><h3>24</h3></div>
            <div class="metric-card"><small>System Pulse</small><h3 style="color:#16a34a">Optimal</h3></div>
        </div>

        <div id="restaurants" class="section-header">
            <h4><i class="fas fa-building-columns" style="color: var(--accent-gold);"></i> Restaurant Registry</h4>
            <button class="btn-primary" onclick="showModal('modal-res')"><i class="fas fa-plus"></i> Add Establishment</button>
        </div>
        <div class="data-container">
            <table>
                <thead><tr><th>Visual</th><th>Matricule</th><th>Name</th><th>Category</th><th>Owner</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($restaurants as $res)
                    <tr>
                        <td><code class="matricule">{{ $res->matricule ?? 'FB-RES-'.$res->id }}</code></td>
                        <td><img src="{{ $res->image_url ? asset($res->image_url) : 'https://via.placeholder.com/100' }}" class="res-img-preview"></td>
                        <td><strong>{{ $res->name }}</strong></td>
                        <td><span class="badge" style="background:#eef2ff; color:#4338ca;">{{ $res->category }}</span></td>
                        <td>{{ $res->owner_name }}</td>
                        <td><i class="fas fa-pen-to-square" style="color:var(--primary-blue); cursor:pointer;"></i></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="users" class="section-header"><h4><i class="fas fa-user-shield" style="color: var(--accent-gold);"></i> Citizen Management</h4></div>
        <div class="data-container">
            <table>
                <thead><tr><th>Matricule</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td><code class="matricule">{{ $u->matricule ?? 'FB-USR-'.$u->id }}</code></td>
                        <td><strong>{{ $u->name }}</strong></td>
                        <td>{{ $u->email }}</td>
                        <td><span style="font-size: 0.75rem; color: var(--text-muted);">{{ strtoupper($u->role) }}</span></td>
                        <td>
                            @if($u->role !== 'super_admin')
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Banish user?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger-outline"><i class="fas fa-user-xmark"></i> Delete</button>
                                </form>
                            @else
                                <span style="font-size: 0.65rem; color: var(--accent-gold); font-weight: 800;"><i class="fas fa-crown"></i> IMMUTABLE</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="partners" class="section-header"><h4><i class="fas fa-handshake" style="color: var(--accent-gold);"></i> Partner Portals</h4></div>
        <div class="data-container">
            <table>
                <thead><tr><th>Node Name</th><th>Role</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($users->whereIn('role', ['restaurant_owner', 'delivery_agent']) as $partner)
                    <tr><td>{{ $partner->name }}</td><td>{{ strtoupper($partner->role) }}</td><td><span class="badge" style="background:#dcfce7; color:#166534;">Verified</span></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="activity" class="section-header"><h4><i class="fas fa-microchip" style="color: var(--accent-gold);"></i> System Pulse</h4></div>
        <div class="data-container" style="padding: 15px; background: #0a192f; color: #22c55e; font-family: monospace; font-size: 0.8rem;">
            <p>> [{{ now()->format('H:i:s') }}] MONITORING_ACTIVE: All systems green.</p>
            <p style="color: var(--accent-gold);">> [LIVE] Admin session authenticated.</p>
        </div>

        <div id="settings" class="section-header"><h4><i class="fas fa-gears" style="color: var(--accent-gold);"></i> System Core</h4></div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0 60px 0;">
            <div class="metric-card"><h5>Empire Branding</h5><input type="text" class="form-control" placeholder="FoodieBert Global HQ"><button class="btn-primary" style="margin-top:10px; width:100%; justify-content: center;">Apply</button></div>
            <div class="metric-card" style="border-bottom-color: #dc2626;"><h5>Security Protocol</h5><button class="btn-danger-outline" style="width:100%; padding:12px; justify-content: center; margin-top: 10px;"><i class="fas fa-lock"></i> Activate Maintenance</button></div>
        </div>
    </main>

    <script>
        // Modal Logic
        function showModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModals() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
        window.onclick = function(e) { if(e.target.classList.contains('modal-overlay')) closeModals(); }

        // Real-time Search Logic
        document.getElementById('dashboardSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            
            // Search in Tables
            document.querySelectorAll('table tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });

            // Search in Metric Cards
            document.querySelectorAll('.metric-card').forEach(card => {
                card.style.display = card.textContent.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

        // Image Preview Logic
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() { document.getElementById('profile-preview').src = reader.result; }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>