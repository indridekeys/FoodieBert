<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logistics Core | FoodieBert</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
</head>
<body>

    <div id="success-toast" class="toast-notification">
        <div class="toast-icon"><i class="fas fa-check"></i></div>
        <div class="toast-text">
            <strong class="toast-title">Empire Notification</strong>
            <span id="toast-message"></span>
        </div>
    </div>

    <div class="modal-overlay" id="modal-account">
        <div class="modal-content profile-modal">
            <div class="modal-header">
                <h3 class="playfair-title">Account Mastery</h3>
                <button onclick="closeModal()" class="close-btn">&times;</button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="avatar-upload-wrapper">
                    <div class="avatar-relative">
                        <img id="profile-preview" src="{{ Auth::user()->picture ? asset('storage/'.Auth::user()->picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" class="avatar-main">
                        <label for="file-upload" class="avatar-edit-icon"><i class="fas fa-camera"></i></label>
                        <input id="file-upload" type="file" name="picture" hidden onchange="previewImage(event)">
                    </div>
                </div>
                <div class="input-group">
                    <label class="label-caps">COURIER NAME</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>
                </div>
                <div class="security-section">
                    <p class="section-subtitle">Security Protocol</p>
                    <div class="grid-two-col">
                        <div class="relative">
                            <label class="label-caps">NEW KEY</label>
                            <input type="password" name="password" id="pass_1" class="form-control pad-right" placeholder="••••••••">
                            <i class="fas fa-eye eye-toggle" onclick="togglePass('pass_1')"></i>
                        </div>
                        <div class="relative">
                            <label class="label-caps">CONFIRM</label>
                            <input type="password" name="password_confirmation" id="pass_2" class="form-control pad-right" placeholder="••••••••">
                            <i class="fas fa-eye eye-toggle" onclick="togglePass('pass_2')"></i>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-primary mt-25">Update Identity</button>
            </form>
        </div>
    </div>

    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <div class="tagline">Logistics Core</div>
        <nav class="flex-grow">
            <a href="javascript:void(0)" onclick="switchTab('stats')" class="nav-item active" id="nav-stats"><i class="fas fa-motorcycle"></i> Dashboard</a>
            <a href="javascript:void(0)" onclick="switchTab('map')" class="nav-item" id="nav-map"><i class="fas fa-route"></i> Map View</a>
            <a href="#" class="nav-item"><i class="fas fa-wallet"></i> Earnings</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">
            @csrf 
            <button type="submit" class="nav-item logout-button"><i class="fas fa-power-off"></i> Logout</button>
        </form>
    </aside>

    <main class="main">
        <nav class="breadcrumb-nav">
            <a href="{{ url('/') }}" class="breadcrumb-item">
                <i class="fas fa-house-chimney"></i> Home
            </a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-current" id="breadcrumb-active">Logistics Dashboard</span>
        </nav>

        <div class="top-bar">
            <div class="welcome-text">
                <h2>Welcome, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                <div class="status-toggle-wrapper">
                    <span class="status-label">Duty Status:</span>
                    <label class="switch">
                        <input type="checkbox" checked onchange="toggleDuty(this)">
                        <span class="slider round"></span>
                    </label>
                    <span id="duty-text" class="status-green">Online</span>
                </div>
            </div>
            <div class="admin-profile" onclick="showModal()">
                <div class="text-right">
                    <span class="font-bold">{{ Auth::user()->name }}</span><br>
                    <small class="matricule-text">{{ Auth::user()->matricule }}</small>
                </div>
                <img src="{{ Auth::user()->picture ? asset('storage/'.Auth::user()->picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" class="profile-img">
            </div>
        </div>

        <div id="tab-stats">
            <div class="metrics-grid">
                <div class="metric-card"><small>Trips Today</small><h3>0</h3></div>
                <div class="metric-card"><small>Revenue</small><h3>$0.00</h3></div>
                <div class="metric-card"><small>Rating</small><h3>5.0 ★</h3></div>
            </div>
            <div class="metric-card mt-20">
                <h4 class="playfair-title mb-20">Active Shipments</h4>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <p>Scanning for nearby orders...</p>
                </div>
            </div>
        </div>

        <div id="tab-map" class="hidden">
            <div class="metric-card map-container-wrapper">
                <div class="map-header">
                    <h4 class="playfair-title">Delivery Navigator</h4>
                    <div class="map-controls">
                        <div class="search-box">
                            <input type="text" id="map-search" placeholder="Search address...">
                            <button onclick="searchLocation()"><i class="fas fa-search"></i></button>
                        </div>
                        <button onclick="getLocation()" class="btn-gps"><i class="fas fa-location-arrow"></i></button>
                    </div>
                </div>
                <div id="delivery-map" style="height: 500px; width: 100%; border-radius: 12px; z-index: 1;"></div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map, userMarker;

        function showModal() { document.getElementById('modal-account').style.display = 'flex'; }
        function closeModal() { document.getElementById('modal-account').style.display = 'none'; }

        function switchTab(tabName) {
            // Update Tab Visibility
            document.getElementById('tab-stats').classList.toggle('hidden', tabName !== 'stats');
            document.getElementById('tab-map').classList.toggle('hidden', tabName !== 'map');
            
            // Update Nav Active State
            document.getElementById('nav-stats').classList.toggle('active', tabName === 'stats');
            document.getElementById('nav-map').classList.toggle('active', tabName === 'map');

            // Dynamic Breadcrumb Text
            const breadcrumb = document.getElementById('breadcrumb-active');
            breadcrumb.innerText = tabName === 'map' ? "Delivery Navigator" : "Logistics Dashboard";

            if(tabName === 'map') { 
                initMap(); 
                getLocation(); 
            }
        }

        function initMap() {
            if (!map) {
                map = L.map('delivery-map').setView([0, 0], 2); 
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            }
            setTimeout(() => { map.invalidateSize(); }, 200);
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    if (userMarker) { userMarker.setLatLng([lat, lng]); } 
                    else { userMarker = L.marker([lat, lng]).addTo(map).bindPopup('You').openPopup(); }
                    map.flyTo([lat, lng], 15);
                });
            }
        }

        async function searchLocation() {
            const query = document.getElementById('map-search').value;
            if(!query) return;
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`);
                const data = await response.json();
                if(data.length > 0) {
                    const { lat, lon } = data[0];
                    map.flyTo([lat, lon], 16);
                    L.marker([lat, lon]).addTo(map).bindPopup(query).openPopup();
                } else {
                    alert("Location not found.");
                }
            } catch (e) {
                console.error("Search failed", e);
            }
        }

        function toggleDuty(checkbox) {
            const text = document.getElementById('duty-text');
            text.innerText = checkbox.checked ? "Online" : "Offline";
            text.className = checkbox.checked ? "status-green" : "status-red";
        }

        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
            event.target.classList.toggle('fa-eye-slash');
        }
    </script>
</body>
</html>