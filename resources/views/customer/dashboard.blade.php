<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cravings | FoodieBert</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* GRAND OVERLAY */
        .modal-full-page { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.95); z-index: 9999; overflow-y: auto; padding: 60px; animation: slideIn 0.5s ease-out; }
        @keyframes slideIn { from { transform: translateY(100%); } to { transform: translateY(0); } }
        
        .details-card { background: #fff; border-radius: 30px; padding: 60px; border-left: 10px solid #D4AF37; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
        .label-caps { color: #D4AF37; text-transform: uppercase; letter-spacing: 2px; font-weight: bold; font-size: 0.8rem; display:block; margin-bottom: 10px; }
        
        /* TABS & NAVIGATION */
        .nav-item { cursor: pointer; transition: 0.3s; padding: 15px 20px; display: flex; align-items: center; gap: 12px; color: rgba(255,255,255,0.7); text-decoration: none; border-radius: 10px; margin-bottom: 5px; }
        .nav-item:hover, .nav-item.active { background: rgba(212, 175, 55, 0.1); color: #D4AF37; }
        
        /* REWARDS BAR */
        .progress-container { background: rgba(0,0,0,0.05); height: 10px; border-radius: 10px; margin: 15px 0; overflow: hidden; }
        .progress-fill { background: linear-gradient(90deg, #001f3f, #D4AF37); height: 100%; transition: 1s ease-in-out; }

        .favorite-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        .fav-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #eee; transition: 0.3s; }
        .fav-card:hover { transform: translateY(-10px); border-color: #D4AF37; }

        .status-badge { padding: 6px 16px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
        .bg-pending { background: #fff3cd; color: #856404; }
        .bg-confirmed { background: #d4edda; color: #155724; }
        .bg-cancelled { background: #f8d7da; color: #721c24; }
        .bg-completed { background: #e2e8f0; color: #475569; }
    </style>
</head>
<body x-data="{ 
    activeTab: 'reservations', 
    showDetails: false, 
    selectedBooking: {} 
}">

    <template x-if="showDetails">
        <div class="modal-full-page" x-transition>
            <button @click="showDetails = false" style="position:fixed; top:40px; right:50px; background:#D4AF37; border:none; padding:15px 30px; border-radius:50px; font-weight:bold; cursor:pointer; z-index:10001;">
                <i class="fas fa-arrow-left"></i> Return to Dashboard
            </button>

            <div style="max-width: 1000px; margin: 0 auto;">
                <h1 class="playfair-display" style="color: white; font-size: 3rem; margin-bottom: 30px;">Reservation Confirmation</h1>
                
                <div class="details-card">
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 60px;">
                        <div>
                            <span class="label-caps">Restaurant</span>
                            <h2 style="font-size: 2.5rem; color: #001f3f;" x-text="selectedBooking.restaurant_name"></h2>
                            
                            <div style="margin-top: 40px; display: grid; grid-template-columns: 1fr 1fr;">
                                <div>
                                    <span class="label-caps">Date</span>
                                    <p style="font-size: 1.3rem;" x-text="selectedBooking.date"></p>
                                </div>
                                <div>
                                    <span class="label-caps">Arrival Time</span>
                                    <p style="font-size: 1.3rem;" x-text="selectedBooking.time"></p>
                                </div>
                            </div>
                        </div>
                        <div style="background: #fcfcfc; padding: 30px; border-radius: 20px;">
                            <span class="label-caps">Guest Count</span>
                            <p style="font-size: 2rem; font-weight: 600;"><i class="fas fa-users" style="color:#D4AF37;"></i> <span x-text="selectedBooking.guests"></span></p>
                            
                            <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
                            
                            <span class="label-caps">Booking Status</span>
                            <span :class="'status-badge bg-' + selectedBooking.status" x-text="selectedBooking.status"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <nav class="flex-grow" style="margin-top: 30px;">
            <a href="#" @click.prevent="activeTab = 'reservations'" :class="activeTab === 'reservations' ? 'nav-item active' : 'nav-item'"><i class="fas fa-calendar-alt"></i> My Reservations</a>
            <a href="#" @click.prevent="activeTab = 'history'" :class="activeTab === 'history' ? 'nav-item active' : 'nav-item'"><i class="fas fa-utensils"></i> Dining History</a>
            <a href="#" @click.prevent="activeTab = 'favorites'" :class="activeTab === 'favorites' ? 'nav-item active' : 'nav-item'"><i class="fas fa-heart"></i> My Favorites</a>
            <a href="#" @click.prevent="activeTab = 'rewards'" :class="activeTab === 'rewards' ? 'nav-item active' : 'nav-item'"><i class="fas fa-crown"></i> Gourmet Rewards</a>
        </nav>
        <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit" class="nav-item logout-button"><i class="fas fa-power-off"></i> Sign Out</button></form>
    </aside>

    <main class="main">
        <div class="top-bar">
            <div class="welcome-text">
                <h2>Bon Appétit, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                <small class="muted-small">Track your reservations and loyalty status.</small>
            </div>
            <div class="admin-profile"><img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=001f3f&color=D4AF37" class="profile-img"></div>
        </div>

        <div class="metrics-grid mt-20">
            <div class="metric-card" style="grid-column: span 2;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <small class="label-caps">Gourmet Loyalty Tier</small>
                        <h3>Gold Member <span style="color: #D4AF37;">(1,240 pts)</span></h3>
                    </div>
                    <i class="fas fa-award" style="font-size: 2rem; color: #D4AF37;"></i>
                </div>
                <div class="progress-container"><div class="progress-fill" style="width: 75%;"></div></div>
                <small style="opacity: 0.6;">Only 260 points until your next free dessert!</small>
            </div>
            <div class="metric-card">
                <small class="label-caps">Total Visits</small>
                <h3>{{ \App\Models\Booking::where('user_id', Auth::id())->where('status', 'confirmed')->count() }}</h3>
            </div>
        </div>

        <section x-show="activeTab === 'reservations'" class="mt-20">
            <h3 class="playfair-title">Upcoming Reservations</h3>
            @php $bookings = \App\Models\Booking::where('user_id', Auth::id())->whereIn('status', ['pending', 'confirmed'])->latest()->get(); @endphp
            <div class="table-container" style="background: white; border-radius: 20px; padding: 30px; margin-top: 15px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead><tr style="text-align: left; color: #999; font-size: 0.75rem; border-bottom: 2px solid #f8f9fa;"><th style="padding-bottom: 15px;">ESTABLISHMENT</th><th>DATE & TIME</th><th>STATUS</th><th style="text-align: right;">ACTION</th></tr></thead>
                    <tbody>
                        @foreach($bookings as $b)
                        <tr style="border-bottom: 1px solid #fafafa;">
                            <td style="padding: 20px 0;"><strong>{{ $b->restaurant->name }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($b->date)->format('D, M d') }} @ {{ \Carbon\Carbon::parse($b->time)->format('g:i A') }}</td>
                            <td><span class="status-badge {{ 'bg-'.$b->status }}">{{ $b->status }}</span></td>
                            <td style="text-align: right;">
                                <button @click="selectedBooking = {id:'{{$b->id}}', restaurant_name:'{{$b->restaurant->name}}', date:'{{$b->date}}', time:'{{$b->time}}', guests:'{{$b->guests}}', status:'{{$b->status}}'}; showDetails = true" 
                                    style="background:#001f3f; color:white; border:none; padding: 8px 18px; border-radius: 8px; cursor:pointer; font-weight: 600;">View Detail</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section x-show="activeTab === 'history'" x-cloak class="mt-20">
            <h3 class="playfair-title">Past Flavors</h3>
            <div class="table-container" style="background: white; border-radius: 20px; padding: 30px;">
                @foreach(\App\Models\Booking::where('user_id', Auth::id())->where('status', 'cancelled')->latest()->limit(5)->get() as $h)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid #f9f9f9;">
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <div style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-check" style="color: #475569;"></i></div>
                        <div>
                            <span style="display:block; font-weight: 600; font-size: 1.1rem;">{{ $h->restaurant->name }}</span>
                            <small style="color: #999;">Visit completed on {{ \Carbon\Carbon::parse($h->date)->format('F d, Y') }}</small>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" style="color: #D4AF37; text-decoration: none; font-weight: 600; font-size: 0.85rem;">Review & Earn Points</a>
                </div>
                @endforeach
            </div>
        </section>

        <section x-show="activeTab === 'favorites'" x-cloak class="mt-20">
            <h3 class="playfair-title">Your Culinary Favorites</h3>
            <div class="favorite-grid mt-20">
                @foreach(\App\Models\Restaurant::limit(4)->get() as $fav)
                <div class="fav-card">
                    <div style="height: 160px; background-image: url('{{ asset('storage/'.$fav->image) }}'); background-size: cover; background-position: center;"></div>
                    <div style="padding: 20px;">
                        <h4 style="color: #001f3f;">{{ $fav->name }}</h4>
                        <p style="font-size: 0.8rem; color: #888; margin: 5px 0;">{{ $fav->address ?? 'Downtown Bertoua' }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                            <span style="color: #D4AF37; font-weight: bold;"><i class="fas fa-star"></i> 4.9</span>
                            <a href="{{ url('/') }}" style="background: #001f3f; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 0.75rem;">Book Again</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

    </main>
</body>
</html>