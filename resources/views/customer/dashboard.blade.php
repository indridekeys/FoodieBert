<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | My Culinary Journey</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
    <style>
        :root {
            --emerald: #0a192f;
            --gold: #D4AF37;
            --soft-gold: rgba(212, 175, 55, 0.2);
            --light-red: #e74c3c;
        }

        .modal-overlay { display:none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.8); z-index: 9999; justify-content: center; align-items: center; backdrop-filter: blur(5px); }
        .profile-img:hover { filter: brightness(0.8); cursor: pointer; border-color: var(--gold); }
        
        /* Reward Card */
        .reward-card {
            background: linear-gradient(135deg, var(--emerald) 0%, #004d40 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            border-bottom: 4px solid var(--gold);
            position: relative;
            overflow: hidden;
        }
        .reward-card::after {
            content: '\f0d0';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 8rem;
            opacity: 0.1;
            color: var(--gold);
        }

        /* Loyalty Points */
        .points-badge {
            background: var(--gold);
            color: var(--emerald);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 800;
            font-size: 1.2rem;
        }

        /* Status Badges */
        .badge { padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-preparing { background: #d1ecf1; color: #0c5460; }
        .badge-delivering { background: #cfe2ff; color: #084298; }
        .badge-confirmed { background: #d4edda; color: #155724; }
        .badge-completed { background: #e0f2fe; color: #075985; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
        .badge-rejected { background: #f8d7da; color: #721c24; }

        .btn-review { background: var(--emerald); color: var(--gold); border: 1px solid var(--gold); padding: 8px 15px; border-radius: 8px; cursor: pointer; transition: 0.3s; font-weight: 600; }
        .btn-review:hover { background: var(--gold); color: var(--emerald); }

        /* Recommendation Alert */
        .rec-alert { background: #fff9db; border-left: 5px solid var(--gold); padding: 15px; margin-bottom: 20px; border-radius: 8px; display: flex; align-items: center; gap: 15px; }
    </style>
</head>

<body>

@if(session('success'))
    <div style="position: fixed; top: 20px; right: 20px; background: var(--emerald); color: var(--gold); padding: 15px 25px; border-radius: 8px; z-index: 20000; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border-left: 5px solid var(--gold);">
        <i class="fas fa-magic"></i> {{ session('success') }}
    </div>
@endif

<div id="modal-profile" class="modal-overlay">
    <div style="background: white; padding: 40px; border-radius: 15px; width: 400px; position: relative; text-align: center;">
        <button onclick="toggleModal('modal-profile')" style="position: absolute; top: 15px; right: 15px; border: none; background: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        <h3 style="font-family: 'Playfair Display'; color: var(--emerald);">Update Profile</h3>
        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div style="margin: 20px 0;">
                <input type="file" name="profile_photo" id="photoInput" hidden>
                <label for="photoInput" style="cursor: pointer; display: block;">
                    <div style="width: 100px; height: 100px; border: 2px dashed var(--gold); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-camera fa-2x" style="color: var(--gold);"></i>
                    </div>
                    <small style="color: #666; display:block; margin-top: 10px;">Click to select photo</small>
                </label>
            </div>
            <button type="submit" style="width: 100%; background: var(--emerald); color: var(--gold); padding: 12px; border: none; border-radius: 8px; font-weight: bold; letter-spacing: 1px;">SAVE CHANGES</button>
        </form>
    </div>
</div>

<aside class="sidebar" style="background: var(--emerald);">
    <div style="padding: 30px; text-align: center; border-bottom: 1px solid rgba(212,175,55,0.2);">
        <h1 style="font-family: 'Great Vibes'; color: var(--gold); font-size: 2.5rem; margin: 0;">FoodieBert</h1>
    </div>
    <nav style="flex-grow: 1; margin-top: 20px;">
        <a href="{{ route('customer.dashboard') }}" class="nav-item active"><i class="fas fa-heart"></i> My Dashboard</a>
        <a href="{{ route('restaurants.index') }}" class="nav-item"><i class="fas fa-search"></i> Discover Eateries</a>
        <a href="#active-bookings" class="nav-item"><i class="fas fa-calendar-alt"></i> My Reservations</a>
        <a href="#active-orders" class="nav-item"><i class="fas fa-motorcycle"></i> My Orders</a>
        <a href="#order-history" class="nav-item"><i class="fas fa-history"></i> History</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-item" style="width:100%; background:none; border:none; text-align:left; cursor:pointer; color: #fff;"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </nav>
</aside>

<main class="main">
    <nav class="breadcrumb-nav">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="fas fa-home"></i> Home</a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Customer Dashboard</span>
    </nav>
    <div class="top-bar">
        <div class="welcome-text">
            <h2 style="font-family: 'Playfair Display';">Welcome Back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
            <p style="color: #666; margin: 0;">Ready for your next gourmet experience in Bertoua?</p>
        </div>

        <div class="admin-profile" style="display: flex; align-items: center; gap: 15px;">
            <div style="text-align: right;">
                <span style="font-weight: 600; color: var(--emerald);">{{ Auth::user()->name }}</span><br>
                <small style="color: var(--gold); font-weight: bold;">PREMIUM GUEST</small>
            </div>
            @php
                $photoPath = Auth::user()->profile_photo;
                $photoUrl = $photoPath ? asset($photoPath) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=002b24&color=D4AF37';
            @endphp
            <img src="{{ $photoUrl }}" class="profile-img" onclick="toggleModal('modal-profile')" 
                 style="width: 55px; height: 55px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); padding: 2px;">
        </div>
    </div>

    @foreach($activeBookings as $booking)
        @if($booking->status == 'cancelled' && $booking->recommendation)
        <div class="rec-alert">
            <i class="fas fa-lightbulb fa-2x" style="color: var(--gold);"></i>
            <div>
                <strong>Message from {{ $booking->restaurant->name }}:</strong><br>
                "{{ $booking->recommendation }}"
                <a href="{{ route('restaurants.show', $booking->restaurant_id) }}" style="color: var(--emerald); font-weight: bold; margin-left: 10px;">Book Again <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        @endif
    @endforeach

    <div class="metrics-grid">
        <div class="reward-card">
            <small style="text-transform: uppercase; letter-spacing: 2px;">Loyalty Status</small>
            <div style="display: flex; align-items: center; gap: 15px; margin-top: 10px;">
                <span class="points-badge">{{ number_format($points) }}</span>
                <span style="font-size: 0.9rem;">Bertoua Points Available</span>
            </div>
        </div>
        <div class="metric-card"><small>Total Visits</small><h3>{{ $totalVisits }}</h3></div>
        <div class="metric-card"><small>Active Reservations</small><h3>{{ $activeBookings->where('status', 'confirmed')->count() }}</h3></div>
        <div class="metric-card"><small>Fav. Restaurant</small><h3 style="font-size: 1.2rem; color: var(--emerald);">{{ $favRestaurant ?? 'Explore Now' }}</h3></div>
    </div>

    <div id="active-orders" class="section-header" style="margin-top: 40px;">
        <h4 style="font-family: 'Playfair Display'; color: var(--emerald);">
            <i class="fas fa-motorcycle" style="color: #e74c3c;"></i> Track Your Meals
        </h4>
    </div>
    <div class="data-container">
        <table>
            <thead>
                <tr style="background: var(--emerald); color: var(--gold);">
                    <th>Order Info</th>
                    <th>Destination</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Tracker</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <strong>{{ $order->food_name }}</strong><br>
                        <small style="color:#666;">From {{ $order->restaurant->name }}</small>
                    </td>
                    <td><small>{{ $order->delivery_address }}</small></td>
                    <td>{{ number_format($order->total_price) }} FCFA</td>
                    <td><span class="badge badge-{{ $order->status }}">{{ $order->status }}</span></td>
                    <td>
                        @if($order->status == 'pending')
                            <i class="fas fa-clock" title="Awaiting restaurant"></i>
                        @elseif($order->status == 'preparing')
                            <i class="fas fa-fire-alt" style="color: orange;" title="Chef is cooking"></i>
                        @elseif($order->status == 'delivering')
                            <i class="fas fa-shipping-fast" style="color: #007bff;" title="On the way!"></i>
                        @else
                            <i class="fas fa-check-double" style="color: green;"></i>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:30px;">No active food orders. <a href="{{ route('restaurants.index') }}" style="color: var(--gold);">Order a meal now!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="active-bookings" class="section-header" style="margin-top: 40px;">
        <h4 style="font-family: 'Playfair Display'; color: var(--emerald);">
            <i class="fas fa-calendar-check" style="color: var(--gold);"></i> Upcoming Tables
        </h4>
    </div>
    <div class="data-container">
        <table>
            <thead>
                <tr style="background: var(--emerald); color: var(--gold);">
                    <th>Restaurant</th>
                    <th>Date & Time</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeBookings as $book)
                <tr>
                    <td><strong>{{ $book->restaurant->name }}</strong></td>
                    <td>{{ $book->date->format('M d, Y') }} at {{ $book->time }}</td>
                    <td>{{ $book->guests }} Seats</td>
                    <td><span class="badge badge-{{ $book->status }}">{{ $book->status }}</span></td>
                    <td>
                        @if($book->status == 'pending' || $book->status == 'confirmed')
                        <form action="{{ route('customer.bookings.cancel', $book->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" style="color: #991b1b; background: none; border: none; cursor: pointer; font-size: 0.8rem;" onclick="return confirm('Cancel this booking?')">
                                <i class="fas fa-times-circle"></i> Cancel
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; padding:30px;">No upcoming reservations. <a href="{{ route('restaurants.index') }}" style="color: var(--gold);">Find a table now!</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="order-history" class="section-header" style="margin-top: 40px;">
        <h4 style="font-family: 'Playfair Display'; color: var(--emerald);">
            <i class="fas fa-history" style="color: var(--gold);"></i> Past Experiences
        </h4>
    </div>
    <div class="data-container">
        <table>
            <thead>
                <tr>
                    <th>Establishment</th>
                    <th>Visit Date</th>
                    <th>Status</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $past)
                <tr>
                    <td>{{ $past->restaurant->name }}</td>
                    <td>{{ $past->date->format('d/m/Y') }}</td>
                    <td><span class="badge badge-{{ $past->status }}">{{ $past->status }}</span></td>
                    <td>
                        @if($past->status == 'completed' && !$past->review)
                            <button class="btn-review" onclick="openReviewModal('{{ $past->id }}', '{{ $past->restaurant->name }}')">
                                <i class="fas fa-star"></i> Leave Review
                            </button>
                        @elseif($past->review)
                            <span style="color: var(--gold);">
                                @for($i=0; $i<$past->review->rating; $i++) <i class="fas fa-star"></i> @endfor
                            </span>
                        @else
                            <small style="color: #ccc;">No action</small>
                        @endif
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
        modal.style.display = (modal.style.display === 'none' || modal.style.display === '') ? 'flex' : 'none';
    }

    function openReviewModal(bookingId, name) {
        alert("Preparing review form for " + name + ". (You can create another modal for this!)");
    }
</script>

</body>
</html>