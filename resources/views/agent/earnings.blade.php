<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieBert | Earnings Vault</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
    <style>
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000; }
        .modal-content { background: white; padding: 30px; border-radius: 15px; width: 400px; max-width: 90%; }
        .withdraw-btn { background: #2ecc71; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; transition: 0.3s; }
        .withdraw-btn:hover { background: #27ae60; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); margin-bottom: 5px; }
        .form-control { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; }
    </style>
</head>
<body>

    {{-- Withdrawal Modal --}}
    <div class="modal-overlay" id="withdrawModal">
        <div class="modal-content">
            <h3 class="playfair-title" style="margin-bottom: 20px;">Withdraw Funds</h3>
            <form action="{{ route('agent.withdraw') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>AMOUNT (FCFA)</label>
                    <input type="number" name="amount" class="form-control" placeholder="Min 500" required>
                </div>
                <div class="form-group">
                    <label>PAYMENT METHOD</label>
                    <select name="payment_method" class="form-control">
                        <option value="MTN Mobile Money">MTN Mobile Money</option>
                        <option value="Orange Money">Orange Money</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>PHONE NUMBER</label>
                    <input type="text" name="phone_number" class="form-control" placeholder="6xx xxx xxx" required>
                </div>
                <button type="submit" class="withdraw-btn" style="width: 100%; padding: 15px;">Submit Request</button>
                <button type="button" onclick="toggleModal(false)" style="width: 100%; background: none; border: none; color: var(--text-muted); margin-top: 10px; cursor: pointer;">Cancel</button>
            </form>
        </div>
    </div>

    <aside class="sidebar">
        <div class="logo-section"><h1>FoodieBert</h1></div>
        <nav style="flex-grow: 1;">
            <a href="{{ route('agent.dashboard') }}" class="nav-item"><i class="fas fa-truck-fast"></i> Active Missions</a>
            <a href="#" class="nav-item active"><i class="fas fa-coins"></i> Earnings Vault</a>
        </nav>
    </aside>

    <main class="main">
        @if(session('success')) <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">{{ session('success') }}</div> @endif
        @if(session('error')) <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px;">{{ session('error') }}</div> @endif

        <div class="top-bar">
            <h2 class="playfair-title">Earnings Vault</h2>
            <button class="withdraw-btn" onclick="toggleModal(true)">
                <i class="fas fa-hand-holding-dollar"></i> Withdraw Funds
            </button>
        </div>

        <div class="metrics-grid">
            <div class="metric-card" style="background: var(--primary-blue); color: white;">
                <small style="color: rgba(255,255,255,0.7);">AVAILABLE BALANCE</small>
                <h3>{{ number_format($totalEarned) }} FCFA</h3>
            </div>
            {{-- Other metrics... --}}
        </div>

        {{-- Table and JS from previous step... --}}
    </main>

    <script>
        function toggleModal(show) {
            document.getElementById('withdrawModal').style.display = show ? 'flex' : 'none';
        }
    </script>
</body>
</html>