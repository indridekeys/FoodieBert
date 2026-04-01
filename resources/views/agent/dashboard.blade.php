<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | Logistics Hub</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
</head>
<style>
    /* Availability Toggle Switch */
    .switch { position: relative; display: inline-block; width: 60px; height: 34px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px; }
    .slider:before { position: absolute; content: ""; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
    input:checked + .slider { background-color: var(--accent-gold); }
    input:checked + .slider:before { transform: translateX(26px); }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .alert-banner { padding: 15px; margin-bottom: 20px; border-radius: 12px; font-size: 0.85rem; font-weight: 600; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    
    /* Table Styling for History */
    .history-table td { border-bottom: 1px solid rgba(0,0,0,0.03); }
</style>
<body>

    {{-- Account Mastery Modal --}}
    <div class="modal-overlay" id="modal-account">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px;">
                <h3 style="font-family: 'Playfair Display'; color: var(--primary-blue);">Logistics Identity</h3>
                <button onclick="closeModals()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="profile-setup-grid" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px;">
                    <div style="text-align: center;">
                        <img id="profile-preview" src="{{ Auth::user()->profile_photo ? asset('storage/'.Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-img" style="width: 120px; height: 120px; margin-bottom: 10px; border-radius: 50%; object-fit: cover;">
                        <label class="btn-primary-small" style="display: block; cursor: pointer;">
                            New Portrait <input type="file" name="profile_photo" hidden onchange="previewImage(event)">
                        </label>
                    </div>
                    <div>
                        <div style="margin-bottom:15px;">
                            <label style="font-size:0.65rem; font-weight:700; color: var(--text-muted);">FULL NAME</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px;">
                        </div>
                        <div style="margin-bottom:15px;">
                            <label style="font-size:0.65rem; font-weight:700; color: var(--text-muted);">EMAIL ADDRESS</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px;">
                        </div>
                        <button type="submit" class="btn-primary-small" style="width:100%; padding: 12px;">Save Identity</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <aside class="sidebar">
    <div class="logo-section"><h1>FoodieBert</h1></div>
    <div class="tagline">Logistics Hub</div>
    
    <nav style="flex-grow: 1;">
        <a href="{{ route('agent.dashboard') }}" class="nav-item active">
            <i class="fas fa-truck-fast"></i> Active Missions
        </a>

        <a href="{{ route('agent.earnings') }}" class="nav-item">
            <i class="fas fa-coins"></i> Earnings Vault
        </a>
               <div class="notification-bell" style="position: relative; margin-right: 20px; cursor: pointer;">
    <i class="fas fa-bell" style="font-size: 1.2rem; color: var(--text-muted);"></i>
    @if(Auth::user()->unreadNotifications->count() > 0)
        <span style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.6rem;">
            {{ Auth::user()->unreadNotifications->count() }}
        </span>
    @endif
</div>
    </nav>

    <form action="{{ route('logout') }}" method="POST">
        @csrf 
        <button type="submit" class="logout-btn">
            <i class="fas fa-power-off"></i> Offline Mode
        </button>
    </form>
</aside>

    <main class="main">
        <nav class="breadcrumb-nav">
            <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Logistics Agent</span>
        </nav>

        <div class="top-bar">
            <div class="welcome-text">
                <h2 class="playfair-title">Welcome, Agent {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                <p style="font-size: 0.8rem; color: var(--text-muted);">Logistics Status: <span class="{{ Auth::user()->is_available ? 'status-green' : 'status-red' }}">{{ Auth::user()->is_available ? 'ACTIVE & READY' : 'OFFLINE' }}</span></p>
                <!-- <div class="notification-bell" style="position: relative; margin-right: 20px; cursor: pointer;">
    <i class="fas fa-bell" style="font-size: 1.2rem; color: var(--text-muted);"></i>
    @if(Auth::user()->unreadNotifications->count() > 0)
        <span style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.6rem;">
            {{ Auth::user()->unreadNotifications->count() }}
        </span>
    @endif
</div> -->
            </div>

            <div class="admin-profile" onclick="showModal('modal-account')">
                <div style="text-align: right; margin-right: 10px;">
                    <span style="display: block; font-weight: 600;">{{ Auth::user()->name }}</span>
                    <small style="color: var(--accent-gold); font-weight: 700; font-size: 0.6rem;">{{ Auth::user()->matricule ?? 'AGENT-'.Auth::id() }}</small>
                </div>
                <img src="{{ Auth::user()->profile_photo ? asset('storage/'.Auth::user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=0a192f&color=C5A059' }}" class="profile-img" style="border-radius: 50%; object-fit: cover;">
            </div>
        </div>

        {{-- Success/Error Feedback --}}
        @if(session('success')) <div class="alert-banner alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert-banner alert-error">{{ session('error') }}</div> @endif

        <div class="metrics-grid">
            <div class="metric-card">
                <small>Missions Completed</small>
                <h3>{{ $orders->where('status', 'delivered')->count() }}</h3>
            </div>
            <div class="metric-card">
                <small>Reliability Rating</small>
                <h3>5.0 <i class="fas fa-star" style="color: var(--accent-gold); font-size: 0.8rem;"></i></h3>
            </div>
            <div class="metric-card" id="wallet">
                <small>Vault Balance</small>
                <h3>{{ number_format($transactions->sum('amount')) }} FCFA</h3>
            </div>
            <div class="metric-card">
                <small>Logistics Pulse</small>
                <h3 class="status-green">Optimal</h3>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-top: 25px;">
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                {{-- CURRENT MISSION SECTION --}}
                <section class="metric-card" style="padding: 0; overflow: hidden; height: auto;">
                    <div style="padding: 20px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                        <h3 class="playfair-title" style="font-size: 1.2rem; margin: 0;">Current Mission</h3>
                        <span class="status-green" style="font-size: 0.7rem; animation: pulse 2s infinite;">LIVE TRACKING</span>
                    </div>
                    
                    @if($activeOrder = $orders->where('status', 'picked_up')->where('agent_id', auth()->id())->first())
                    <div style="padding: 20px;">
                        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <small style="color: var(--text-muted); font-size: 0.6rem; font-weight: 700;">DESTINATION</small>
                                <p style="font-weight: 600; font-size: 0.9rem;">{{ $activeOrder->delivery_address }}</p>
                            </div>
                            <div style="text-align: right;">
                                <small style="color: var(--text-muted); font-size: 0.6rem; font-weight: 700;">EST. EARNING</small>
                                <p style="color: var(--accent-gold); font-weight: 700;">{{ number_format($activeOrder->delivery_fee) }} FCFA</p>
                            </div>
                        </div>
                        <div id="map" style="width: 100%; height: 250px; background: #eee; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                            <p style="color: var(--text-muted);"><i class="fas fa-map-location-dot"></i> GPS Initialized for {{ $activeOrder->delivery_address }}</p>
                        </div>

                        {{-- Mark as Delivered Form --}}
                        <form action="{{ route('agent.orders.complete', $activeOrder->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary-small" style="width: 100%; margin-top: 15px; padding: 15px; background: #2ecc71; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> Mark as Delivered
                            </button>
                        </form>
                    </div>
                    @else
                    <div style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                        <i class="fas fa-route" style="font-size: 2rem; margin-bottom: 10px; opacity: 0.5;"></i>
                        <p>No active mission. Check the queue below.</p>
                    </div>
                    @endif
                </section>

                {{-- INCOMING MISSIONS QUEUE --}}
                <section class="metric-card" style="padding: 20px;">
                    <h3 class="playfair-title" style="font-size: 1.2rem; margin-bottom: 20px;">Incoming Missions</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 1px solid var(--border-color);">
                                    <th style="padding: 10px; color: var(--text-muted);">ID</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Pickup Point</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Earning</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders->where('status', 'pending_pickup') as $order)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.05);">
                                    <td style="padding: 12px; font-weight: 600;">#{{ $order->id }}</td>
                                    <td style="padding: 12px;">{{ $order->restaurant->name ?? 'Bertoua Kitchen' }}</td>
                                    <td style="padding: 12px; color: var(--accent-gold); font-weight: 700;">{{ number_format($order->delivery_fee) }} FCFA</td>
                                    <td style="padding: 12px;">
                                        <form action="{{ route('agent.orders.accept', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background: var(--primary-blue); color: white; border: none; padding: 5px 12px; border-radius: 6px; cursor: pointer;">Accept</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">Scanning for nearby missions...</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- NEW: MISSION HISTORY SECTION --}}
                <section class="metric-card" id="history" style="padding: 20px;">
                    <h3 class="playfair-title" style="font-size: 1.2rem; margin-bottom: 20px;">Mission History</h3>
                    <div style="overflow-x: auto;">
                        <table class="history-table" style="width: 100%; border-collapse: collapse; font-size: 0.8rem;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 1px solid var(--border-color);">
                                    <th style="padding: 10px; color: var(--text-muted);">Date</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Destination</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Payout</th>
                                    <th style="padding: 10px; color: var(--text-muted);">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders->where('status', 'delivered')->sortByDesc('updated_at')->take(10) as $history)
                                <tr>
                                    <td style="padding: 12px;">{{ $history->updated_at->format('d M, H:i') }}</td>
                                    <td style="padding: 12px;">{{ Str::limit($history->delivery_address, 25) }}</td>
                                    <td style="padding: 12px; font-weight: 700;">{{ number_format($history->delivery_fee) }} FCFA</td>
                                    <td style="padding: 12px;"><span style="color: #2ecc71;"><i class="fas fa-check-double"></i> Done</span></td>
                                </tr>
                                @empty
                                <tr><td colspan="4" style="text-align: center; padding: 20px; color: var(--text-muted);">No completed missions found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>

            <div style="display: flex; flex-direction: column; gap: 25px;">
                <div class="metric-card" style="text-align: center; background: var(--cream);">
                    <small style="color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 10px;">AVAILABILITY STATUS</small>
                    <label class="switch">
                        <input type="checkbox" {{ Auth::user()->is_available ? 'checked' : '' }} onchange="toggleAvailability(this)">
                        <span class="slider round"></span>
                    </label>
                    <p id="status-text" style="margin-top: 10px; font-weight: 600; font-size: 0.8rem; color: {{ Auth::user()->is_available ? '#2ecc71' : '#e74c3c' }}">
                        {{ Auth::user()->is_available ? 'ONLINE' : 'OFFLINE' }}
                    </p>
                </div>

                <div class="metric-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <small style="font-weight: 700; color: var(--text-muted);">TODAY'S BOUNTY</small>
                        <i class="fas fa-calendar-day" style="color: var(--accent-gold);"></i>
                    </div>
                    @php 
                        $todaySum = $transactions->where('created_at', '>=', today())->sum('amount');
                        $goal = 5000;
                        $progress = ($goal > 0) ? min(($todaySum / $goal) * 100, 100) : 0;
                    @endphp
                    <h2 style="margin: 0; color: var(--primary-blue);">{{ number_format($todaySum) }} <span style="font-size: 0.8rem;">FCFA</span></h2>
                    <div style="margin-top: 15px; height: 4px; background: #eee; border-radius: 2px;">
                        <div style="width: {{ $progress }}%; height: 100%; background: var(--accent-gold); border-radius: 2px; transition: width 0.5s ease;"></div>
                    </div>
                    <p style="font-size: 0.7rem; margin-top: 8px; color: var(--text-muted);">{{ round($progress) }}% of daily goal ({{ number_format($goal) }} FCFA) reached</p>
                </div>
            </div>
        </div>
    </main>

<script>
    // --- Modal Management ---
    function showModal(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'flex'; 
    }

    function closeModals() { 
        document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); 
    }

    window.onclick = function(e) { 
        if(e.target.classList.contains('modal-overlay')) closeModals(); 
    }

    // --- Profile Image Preview ---
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() { 
            const preview = document.getElementById('profile-preview');
            if (preview) preview.src = reader.result; 
        }
        if(event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    /**
     * Toggles Agent Availability
     * Fixed URL path and added detailed error logging
     */
    async function toggleAvailability(checkbox) {
        const statusText = document.getElementById('status-text');
        const topBarStatus = document.querySelector('.welcome-text span');
        const originalState = !checkbox.checked; 
        
        // UI Update Function
        const updateUI = (isAvailable) => {
            const label = isAvailable ? 'ONLINE' : 'OFFLINE';
            const badge = isAvailable ? 'ACTIVE & READY' : 'OFFLINE';
            const color = isAvailable ? '#2ecc71' : '#e74c3c';
            const badgeClass = isAvailable ? 'status-green' : 'status-red';

            if (statusText) {
                statusText.innerText = label;
                statusText.style.color = color;
            }

            if (topBarStatus) {
                topBarStatus.innerText = badge;
                topBarStatus.className = badgeClass;
            }
        };

        // Optimistic update
        updateUI(checkbox.checked);
        
        try {
            // Using Blade's route helper is the safest way to get the URL
            const targetUrl = "{{ route('agent.toggle-status') }}";
            
            const response = await fetch(targetUrl, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ is_available: checkbox.checked })
            });

            if (!response.ok) {
                // If the response is not 200-299, catch it here
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `Server responded with ${response.status}`);
            }
            
            const data = await response.json();
            console.log("Logistics Sync Successful:", data.message);

        } catch (error) {
            // Detailed logging for debugging
            console.error("Critical Logistics Sync Failure:", error);
            
            // Revert UI
            checkbox.checked = originalState;
            updateUI(originalState);
            
            alert("Connection error: " + error.message);
        }
    }
</script>
</body>
</html>