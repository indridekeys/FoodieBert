<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieBert Admin | Payout Terminal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboards.css') }}">
    <style>
        .payout-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .status-pending { background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; }
        .status-completed { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; }
        .momo-badge { background: #004a99; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; margin-right: 5px; }
    </style>
</head>
<body>
    <main class="main" style="margin-left: 0; padding: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2 class="playfair-title">Withdrawal Requests</h2>
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: var(--primary-blue); font-weight: 600;">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <div class="payout-card">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f4f4f4; color: var(--text-muted);">
                        <th style="padding: 15px;">Agent</th>
                        <th style="padding: 15px;">Amount</th>
                        <th style="padding: 15px;">Payment Details</th>
                        <th style="padding: 15px;">Requested On</th>
                        <th style="padding: 15px;">Status</th>
                        <th style="padding: 15px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                    <tr style="border-bottom: 1px solid #f9f9f9;">
                        <td style="padding: 15px;">
                            <strong>{{ $req->user->name }}</strong><br>
                            <small>{{ $req->user->matricule }}</small>
                        </td>
                        <td style="padding: 15px; font-weight: 700; color: #e74c3c;">
                            {{ number_format(abs($req->amount)) }} FCFA
                        </td>
                        <td style="padding: 15px;">
                            <span class="momo-badge">{{ $req->meta['method'] ?? 'MOMO' }}</span>
                            <code>{{ $req->meta['phone'] ?? 'N/A' }}</code>
                        </td>
                        <td style="padding: 15px; font-size: 0.8rem;">
                            {{ $req->created_at->format('M d, Y H:i') }}
                        </td>
                        <td style="padding: 15px;">
                            <span class="status-{{ $req->status }}">{{ strtoupper($req->status) }}</span>
                        </td>
                        <td style="padding: 15px;">
                            @if($req->status == 'pending')
                            <form action="{{ route('admin.payouts.approve', $req->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary-small" style="background: #2ecc71; border: none; cursor: pointer;">
                                    Confirm Payment
                                </button>
                            </form>
                            @else
                            <i class="fas fa-check-double" style="color: #2ecc71;"></i> Processed
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>