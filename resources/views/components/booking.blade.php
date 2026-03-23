

<div 
    x-data="{ isOpen: false }" 
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
        class="booking-card"
        x-show="isOpen"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="scale-95 translate-y-4"
        x-transition:enter-end="scale-100 translate-y-0"
    >
        <div class="booking-header">
            <h3>Table Reservation</h3>
            <button @click="isOpen = false" class="close-modal-btn">&times;</button>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" class="booking-grid">
            @csrf
            
            <div class="input-group">
                <label>Select Restaurant</label>
                <select name="restaurant_id" required class="form-select">
                    <option value="" disabled selected>Choose a restaurant...</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">
                            {{ $restaurant->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" required>
            </div>

            <div class="input-row">
                <div class="input-group">
                    <label>Date</label>
                    <input type="date" name="date" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="input-group">
                    <label>Time</label>
                    <input type="time" name="time" required>
                </div>
            </div>

            <div class="input-group">
                <label>Number of Guests</label>
                <input type="number" name="guests" min="1" max="15" value="2">
            </div>

            <button type="submit" class="btn-confirm-booking">
                Confirm Reservation
            </button>
        </form>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    .booking-fixed-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .booking-card {
        background: white;
        width: 100%;
        max-width: 450px;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .booking-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .input-group { margin-bottom: 15px; }
    
    .input-group label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: #444;
    }

    .input-group input, 
    .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-family: inherit;
        font-size: 0.95rem;
    }

    .form-select {
        background-color: #f9f9f9;
        cursor: pointer;
    }

    .btn-confirm-booking {
        width: 100%;
        background: #e63946; 
        color: white;
        padding: 15px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.2s;
    }

    .btn-confirm-booking:hover {
        background: #d62839;
    }

    .close-modal-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #999;
    }
</style>