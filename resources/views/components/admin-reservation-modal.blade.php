<div id="adminResModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px);">
    <div style="position: relative; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 500px; background: white; padding: 30px; border-top: 8px solid #D4AF37;">
        <h2 style="font-family: 'Playfair Display'; color: #001f3f;">Reservation Details</h2>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        
        <div id="resDetailContent" style="line-height: 1.6; color: #444;">
            </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <form id="confirmForm" method="POST" style="flex: 1;">
                @csrf @method('PATCH')
                <button type="submit" style="width: 100%; background: #10b981; color: white; border: none; padding: 12px; font-weight: bold; cursor: pointer;">CONFIRM BOOKING</button>
            </form>
            <button onclick="closeAdminResModal()" style="flex: 1; background: #eee; border: none; padding: 12px; cursor: pointer;">CLOSE</button>
        </div>
    </div>
</div>



<script>
function viewReservationDetails(res) {
    const content = document.getElementById('resDetailContent');
    content.innerHTML = `
        <p><strong>Guest Name:</strong> ${res.guest_name}</p>
        <p><strong>Establishment:</strong> ${res.restaurant.name}</p>
        <p><strong>Party Size:</strong> ${res.party_size} People</p>
        <p><strong>Time:</strong> ${res.reservation_time}</p>
        <div style="background: #f9f9f9; padding: 15px; margin-top: 15px;">
            <strong>Special Requests:</strong><br>
            ${res.special_requests || 'No special requests provided.'}
        </div>
    `;
    
    // Update the form action dynamically
    document.getElementById('confirmForm').action = `/admin/reservations/${res.id}/confirm`;
    document.getElementById('adminResModal').style.display = 'block';
}

function closeAdminResModal() {
    document.getElementById('adminResModal').style.display = 'none';
}
</script>