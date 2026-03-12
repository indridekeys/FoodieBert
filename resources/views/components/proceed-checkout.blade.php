<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | FoodieBert</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <style>
        body { background-color: #f8f9fa; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .checkout-wrapper { max-width: 1100px; margin: 120px auto 50px; padding: 20px; }
        .grid-container { display: grid; grid-template-columns: 1fr 400px; gap: 30px; }
        
        .card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #0a192f; }
        input, select, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
        
        .summary-card { background: #0a192f; color: white; border-radius: 12px; padding: 25px; position: sticky; top: 100px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 8px; }
        .total-price { font-size: 1.5rem; color: #FF69B4; font-weight: bold; }
        
        .btn-confirm { width: 100%; background: #C5A059; color: #0a192f; border: none; padding: 18px; border-radius: 8px; font-size: 1.1rem; font-weight: 800; cursor: pointer; transition: 0.3s; margin-top: 20px; }
        .btn-confirm:hover { background: #FF69B4; color: white; }

        @media (max-width: 850px) { .grid-container { grid-template-columns: 1fr; } .summary-card { position: static; } }
    </style>
</head>
<body>

    {{-- Include your existing header component --}}
    @include('components.header')

    <div class="checkout-wrapper">
        <div class="grid-container">
            
            <div class="card">
                <h2 style="color: #C5A059; margin-top: 0;"><i class="fas fa-map-marker-alt"></i> Delivery Information</h2>
                <form id="orderForm">
                    <div class="form-group">
                        <label>Delivery Address in Bertoua</label>
                        <textarea placeholder="Neighborhood, Street description, or Landmark..." rows="3" required></textarea>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" placeholder="670 00 00 00" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select>
                                <option>Cash on Delivery</option>
                                <option>Mobile Money (MTN/Orange)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="summary-card">
                <h3 style="margin-top:0; border-bottom: 1px solid #C5A059; padding-bottom: 10px;">Order Summary</h3>
                <div id="checkout-list">
                    </div>
                <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 1.2rem;">Total Amount:</span>
                    <span id="final-total" class="total-price">0 FCFA</span>
                </div>
                <button type="button" class="btn-confirm" onclick="submitFinalOrder()">CONFIRM ORDER</button>
                <a href="{{ route('home') }}" style="display:block; text-align:center; color:#ccc; margin-top:15px; text-decoration:none; font-size:0.9rem;">Back to Menu</a>
            </div>

        </div>
    </div>

    <script>
        // Load the cart from storage
        document.addEventListener('DOMContentLoaded', () => {
            const savedCart = JSON.parse(localStorage.getItem('foodieCart')) || [];
            const listContainer = document.getElementById('checkout-list');
            const totalDisplay = document.getElementById('final-total');

            if (savedCart.length === 0) {
                alert("Your cart is empty!");
                window.location.href = "{{ route('home') }}";
                return;
            }

            let total = 0;
            listContainer.innerHTML = savedCart.map(item => {
                total += item.price;
                return `
                    <div class="summary-item">
                        <span>${item.name}</span>
                        <span>${item.price.toLocaleString()} FCFA</span>
                    </div>
                `;
            }).join('');

            totalDisplay.innerText = total.toLocaleString() + ' FCFA';
        });

        function submitFinalOrder() {
            alert("Order Successful! We are preparing your food.");
            localStorage.removeItem('foodieCart'); // Clear cart after success
            window.location.href = "{{ route('home') }}";
        }
    </script>

</body>
</html>