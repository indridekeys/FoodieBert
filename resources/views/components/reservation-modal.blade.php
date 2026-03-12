<div id="reservationModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 31, 63, 0.85); backdrop-filter: blur(10px); transition: all 0.3s ease-in-out;">
    
    <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%; max-width: 550px; background: #fff; border-radius: 2px; overflow: hidden; box-shadow: 0 50px 100px rgba(0,0,0,0.5);">
        
        <div style="height: 6px; background: #D4AF37; width: 100%;"></div>

        <div style="padding: 40px 40px 20px 40px; text-align: center;">
            <h2 id="modalRestName" style="font-family: 'Playfair Display', serif; font-size: 2rem; color: #001f3f; margin: 0;">Secure Your Table</h2>
            <p style="font-family: 'Inter', sans-serif; color: #888; font-size: 0.85rem; margin-top: 10px; text-transform: uppercase; letter-spacing: 2px;">Bertoua's Finest Dining Experience</p>
        </div>

        <form action="{{ route('reservations.store') }}" method="POST" style="padding: 0 40px 40px 40px;">
            @csrf
            <input type="hidden" name="restaurant_id" id="modal_restaurant_id">

            <div style="display: grid; gap: 20px;">
                
                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 800; color: #001f3f; letter-spacing: 1px; margin-bottom: 8px;">FULL NAME</label>
                    <input type="text" name="guest_name" required placeholder="John Doe" 
                           style="width: 100%; padding: 12px; border: 1px solid #eee; background: #fbfbfb; font-family: 'Inter'; outline: none; transition: 0.3s;"
                           onfocus="this.style.borderColor='#D4AF37'">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 800; color: #001f3f; letter-spacing: 1px; margin-bottom: 8px;">PARTY SIZE</label>
                        <select name="party_size" style="width: 100%; padding: 12px; border: 1px solid #eee; background: #fbfbfb; outline: none;">
                            <option value="1">1 Person</option>
                            <option value="2" selected>2 People</option>
                            <option value="4">4 People</option>
                            <option value="6">6+ People</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 800; color: #001f3f; letter-spacing: 1px; margin-bottom: 8px;">DATE & TIME</label>
                        <input type="datetime-local" name="reservation_time" required 
                               style="width: 100%; padding: 12px; border: 1px solid #eee; background: #fbfbfb; font-family: 'Inter'; outline: none;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.7rem; font-weight: 800; color: #001f3f; letter-spacing: 1px; margin-bottom: 8px;">SPECIAL REQUESTS (Optional)</label>
                    <textarea name="special_requests" rows="2" placeholder="Anniversary, dietary restrictions, etc..." 
                              style="width: 100%; padding: 12px; border: 1px solid #eee; background: #fbfbfb; font-family: 'Inter'; outline: none; resize: none;"></textarea>
                </div>

                <button type="submit" style="background: #001f3f; color: #D4AF37; border: none; padding: 18px; font-weight: 700; letter-spacing: 2px; cursor: pointer; transition: 0.3s; margin-top: 10px;">
                    CONFIRM RESERVATION
                </button>

                <button type="button" onclick="closeReservationModal()" style="background: transparent; border: none; color: #aaa; cursor: pointer; font-size: 0.8rem; text-decoration: underline;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReservationModal(id, name) {
        document.getElementById('modal_restaurant_id').value = id;
        document.getElementById('modalRestName').innerText = "Table at " + name;
        document.getElementById('reservationModal').style.display = 'block';
        document.body.style.overflow = 'hidden'; // Stop scrolling
    }

    function closeReservationModal() {
        document.getElementById('reservationModal').style.display = 'none';
        document.body.style.overflow = 'auto'; // Enable scrolling
    }

    // Close on outside click
    window.onclick = function(event) {
        let modal = document.getElementById('reservationModal');
        if (event.target == modal) {
            closeReservationModal();
        }
    }
</script>