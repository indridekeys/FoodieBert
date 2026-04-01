<div 
    x-data="{ 
        isOpen: {{ session('success') ? 'true' : 'false' }}, 
        isSubmitting: false,
        showSuccess: true
    }" 
    x-init="$watch('isOpen', value => {
        if (value) document.body.style.overflow = 'hidden';
        else document.body.style.overflow = 'auto';
    })"
    @open-booking-modal.window="isOpen = true"
    @keydown.escape.window="isOpen = false"
    x-show="isOpen"
    x-transition:enter="transition opacity-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-cloak
    class="booking-fixed-overlay"
>
    <div 
        @click.away="isOpen = false"
        class="booking-modal-content"
        x-show="isOpen"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="scale-95 translate-y-8 opacity-0"
        x-transition:enter-end="scale-100 translate-y-0 opacity-100"
    >
        <div class="modal-header-premium sticky-header">
            <div class="header-text">
                <h3><i class="fas fa-concierge-bell"></i> Reserve Your Table</h3>
                <p>Experience the best of Bertoua dining</p>
            </div>
            <button @click="isOpen = false" class="close-modal-btn">&times;</button>
        </div>

        <div class="modal-scroll-body">
            @if(session('success'))
                <div x-show="showSuccess" class="success-banner">
                    <div class="banner-icon"><i class="fas fa-paper-plane"></i></div>
                    <div class="banner-text">
                        <strong>Success!</strong> Your booking is pending. Please <b>check your Gmail</b> for updates.
                    </div>
                    <button @click="showSuccess = false" class="banner-close">&times;</button>
                </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST" class="modal-form-grid" @submit="isSubmitting = true">
                @csrf
                
                <div class="input-box full-width">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label>Restaurant</label>
                        <span style="font-size: 0.7rem; color: var(--accent-gold); font-weight: bold;">
                            <i class="fas fa-map-marked-alt"></i> Select to view location
                        </span>
                    </div>
                    <div class="input-wrapper">
                        <i class="fas fa-utensils"></i>
                        <select name="restaurant_id" required>
                            <option value="" disabled selected>Select a restaurant...</option>
                            @foreach($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">
                                    {{ $restaurant->name }} — ({{ $restaurant->location ?? 'Bertoua' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-box">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" placeholder="John Doe" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" placeholder="john@example.com" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Date</label>
                    <div class="input-wrapper">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" name="date" required min="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="input-box mini-split">
                    <div class="sub-box">
                        <label>Time</label>
                        <input type="time" name="time" required>
                    </div>
                    <div class="sub-box">
                        <label>Guests</label>
                        <input type="number" name="guests" min="1" max="20" value="2">
                    </div>
                </div>

                <div class="form-actions full-width">
                    <button type="submit" class="btn-primary-gold" :disabled="isSubmitting">
                        <span x-show="!isSubmitting">Confirm Reservation</span>
                        <span x-show="isSubmitting"><i class="fas fa-circle-notch fa-spin"></i> Processing...</span>
                    </button>
                </div>
            </form>
        </div>

        @auth
        <div class="modal-footer-link sticky-footer">
            <a href="{{ route('dashboard') }}"><i class="fas fa-history"></i> Manage my reservations</a>
        </div>
        @endauth
    </div>
</div>

<style>
:root {
    --primary-blue: #0a192f;
    --accent-gold: #C5A059;
    --light-yellow: #fdf5e6;
    --light-red: #e74c3c;
    --dark-red: #b03a2e;
}

.booking-fixed-overlay {
    position: fixed;
    inset: 0;
    z-index: 10000;
    background: rgba(10, 25, 47, 0.9);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
}

.booking-modal-content {
    background: #fff;
    width: 100%;
    max-width: 800px;
    max-height: 90vh; /* Set height for mobile scroll */
    border-radius: 20px;
    box-shadow: 0 40px 100px rgba(0,0,0,0.6);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
    border: 1px solid rgba(197, 160, 89, 0.3);
}

.sticky-header { flex-shrink: 0; }
.sticky-footer { flex-shrink: 0; }

.modal-scroll-body {
    overflow-y: auto;
    flex-grow: 1;
    -webkit-overflow-scrolling: touch;
}

.modal-header-premium {
    background: var(--primary-blue);
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 4px solid var(--accent-gold);
}

.header-text h3 {
    color: var(--accent-gold);
    margin: 0;
    font-size: 1.4rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.header-text p {
    color: #a8b2d1;
    margin: 3px 0 0;
    font-size: 0.85rem;
}

.close-modal-btn {
    background: none;
    border: none;
    color: #fff;
    font-size: 2.2rem;
    cursor: pointer;
}

.modal-form-grid {
    padding: 30px 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 30px;
}

.full-width { grid-column: span 2; }

.input-box label {
    display: block;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 6px;
    font-size: 0.8rem;
    text-transform: uppercase;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-wrapper i {
    position: absolute;
    left: 15px;
    color: var(--accent-gold);
}

.input-wrapper input, .input-wrapper select {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    background: #f8fafc;
}

.mini-split {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.btn-primary-gold {
    width: 100%;
    background: var(--primary-blue);
    color: var(--accent-gold);
    border: 2px solid var(--accent-gold);
    padding: 16px;
    font-size: 1rem;
    font-weight: 800;
    border-radius: 12px;
    cursor: pointer;
    text-transform: uppercase;
    transition: all 0.3s ease;
}

.success-banner {
    background: #f0fdf4;
    border-bottom: 1px solid #bbf7d0;
    padding: 12px 40px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.banner-icon { color: #22c55e; }
.banner-text { color: #166534; font-size: 0.85rem; flex-grow: 1; }
.banner-close { background: none; border: none; font-size: 1.2rem; cursor: pointer; }

@media (max-width: 768px) {
    .modal-form-grid {
        grid-template-columns: 1fr;
        padding: 20px;
        gap: 15px;
    }
    .full-width { grid-column: span 1; }
    .modal-header-premium { padding: 15px 20px; }
    .header-text h3 { font-size: 1.1rem; }
    .booking-modal-content { width: 92%; }
}

.modal-footer-link {
    text-align: center;
    padding: 12px;
    background: var(--light-yellow);
    border-top: 1px solid rgba(197, 160, 89, 0.2);
}

.modal-footer-link a {
    color: var(--primary-blue);
    font-weight: 600;
    text-decoration: none;
    font-size: 0.8rem;
}
</style>