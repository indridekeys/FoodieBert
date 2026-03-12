@php
    // Ensure the collection is ready for the JS component
    $restaurants = $restaurants ?? collect();
@endphp

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
    /* 1. RESET & UTILITIES */
    [x-cloak] { display: none !important; }
    
    /* 2. OVERLAY (Blurred background) */
    .fb-picker-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 5, 15, 0.85);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100000;
        font-family: 'Playfair Display', 'Segoe UI', serif;
    }

    /* 3. MODAL CONTAINER */
    .fb-modal {
        background: #ffffff;
        width: 95%;
        max-width: 480px;
        max-height: 85vh;
        border-radius: 30px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(212, 175, 55, 0.3);
    }

    /* 4. HEADER (Navy Blue & Gold) */
    .fb-header {
        background-color: #001f3f; 
        padding: 30px 25px;
        color: #ffffff;
        border-bottom: 4px solid #D4AF37; 
        text-align: center;
    }

    .fb-header h3 {
        margin: 0 0 15px 0;
        font-size: 1.6rem;
        font-weight: 700;
        color: #D4AF37; 
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* 5. SEARCH INPUT */
    .fb-search-input {
        width: 100%;
        padding: 14px 20px;
        border-radius: 50px;
        border: 2px solid #D4AF37;
        outline: none;
        font-size: 1rem;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .fb-search-input::placeholder {
        color: rgba(212, 175, 55, 0.6);
    }

    .fb-search-input:focus {
        background: #ffffff;
        color: #001f3f;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
    }

    /* 6. LIST AREA */
    .fb-list {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background-color: #fcfaf2; 
    }

    /* 7. RESTAURANT ITEM */
    .fb-item {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 12px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .fb-item:hover {
        border-color: #D4AF37;
        background: #fffdf5;
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .fb-item-img {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        object-fit: cover;
        margin-right: 15px;
        border: 2px solid #D4AF37;
    }

    .fb-item-info {
        flex: 1;
    }

    .fb-item-name {
        display: block;
        font-weight: 800;
        color: #001f3f;
        font-size: 1.15rem;
    }

    .fb-item-type {
        font-size: 0.85rem;
        color: #b4941f; 
        font-weight: 600;
        text-transform: uppercase;
    }

    /* 8. FOOTER */
    .fb-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        background: white;
    }

    .fb-close-btn {
        background: transparent;
        border: 2px solid #001f3f;
        padding: 12px;
        border-radius: 50px;
        font-weight: 700;
        color: #001f3f;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s;
    }

    .fb-close-btn:hover {
        background: #001f3f;
        color: #D4AF37;
    }

    .no-results {
        text-align: center;
        padding: 50px 20px;
        color: #001f3f;
        opacity: 0.5;
    }
</style>

<div 
    x-data="{ 
        isOpen: false, 
        search: '',
        restaurants: {{ $restaurants->toJson() }},
        get filtered() {
            if (!this.search) return this.restaurants;
            return this.restaurants.filter(r => 
                r.name.toLowerCase().includes(this.search.toLowerCase()) ||
                (r.cuisine_type && r.cuisine_type.toLowerCase().includes(this.search.toLowerCase()))
            );
        }
    }" 
    @open-restaurant-picker.window="isOpen = true; $nextTick(() => $refs.pickerInput.focus())"
    @keydown.escape.window="isOpen = false"
    x-show="isOpen" 
    x-cloak
    class="fb-picker-overlay"
>
    <div class="fb-modal" @click.away="isOpen = false">
        
        <div class="fb-header">
            <h3>Select a Destination</h3>
            <div class="fb-search-container">
                <input 
                    x-ref="pickerInput"
                    type="text" 
                    x-model="search" 
                    placeholder="Search by name or cuisine..." 
                    class="fb-search-input"
                >
            </div>
        </div>

        <div class="fb-list">
            <template x-for="restaurant in filtered" :key="restaurant.id">
                <a :href="'/restaurants/' + (restaurant.slug || restaurant.id)" 
                   class="fb-item">
                    <img :src="restaurant.logo_url || 'https://ui-avatars.com/api/?background=001f3f&color=D4AF37&name=' + restaurant.name" class="fb-item-img">
                    <div class="fb-item-info">
                        <span class="fb-item-name" x-text="restaurant.name"></span>
                        <span class="fb-item-type" x-text="restaurant.cuisine_type || 'Exquisite Dining'"></span>
                    </div>
                    <div style="color: #D4AF37; font-size: 1.5rem; font-weight: bold;">›</div>
                </a>
            </template>

            <div x-show="filtered.length === 0" class="no-results">
                <p>No matches found for "<span x-text="search" style="font-weight: bold;"></span>"</p>
            </div>
        </div>

        <div class="fb-footer">
            <button @click="isOpen = false" class="fb-close-btn">Return to Home</button>
        </div>
    </div>
</div>