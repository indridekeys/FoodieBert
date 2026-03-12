<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0px; }
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; background-color: #fff; }
        
        /* Theme Elements */
        .sidebar { position: absolute; left: 0; top: 0; bottom: 0; width: 15px; background-color: #D4AF37; }
        .main-container { padding: 60px 80px; }
        
        .header { border-bottom: 4px solid #001f3f; padding-bottom: 20px; margin-bottom: 40px; }
        .city-seal { color: #D4AF37; font-size: 14px; text-transform: uppercase; letter-spacing: 5px; font-weight: bold; margin-bottom: 10px; }
        .title { color: #001f3f; font-size: 36px; margin: 0; font-family: 'Georgia', serif; }
        
        .registry-label { background: #001f3f; color: #D4AF37; display: inline-block; padding: 5px 15px; font-size: 12px; margin-top: 10px; border-radius: 4px; }

        .info-grid { margin-top: 40px; }
        .info-row { margin-bottom: 30px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px; }
        .label { font-weight: bold; color: #001f3f; width: 200px; display: inline-block; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
        .value { font-size: 18px; color: #444; }
        
        .status-open { color: #10b981; font-weight: bold; }
        /* Theme Light Red */
        .status-closed { color: #ff6b6b; font-weight: bold; } 
        
        .footer { position: absolute; bottom: 40px; left: 80px; right: 80px; font-size: 10px; color: #999; text-align: center; border-top: 1px solid #D4AF37; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="sidebar"></div>
    <div class="main-container">
        <div class="header">
            <div class="city-seal">Official City Registry • Bertoua</div>
            <h1 class="title">Establishment Extract</h1>
            <div class="registry-label">CERTIFIED DOCUMENT</div>
        </div>

        <div class="info-grid">
            <div class="info-row">
                <span class="label">Registration ID</span>
                <span class="value" style="font-family: monospace; font-weight: bold;">{{ $restaurant->matricule }}</span>
            </div>
            <div class="info-row">
                <span class="label">Legal Name</span>
                <span class="value">{{ $restaurant->name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Business Category</span>
                <span class="value">{{ $restaurant->category }}</span>
            </div>
            <div class="info-row">
                <span class="label">Designated Owner</span>
                <span class="value">{{ $restaurant->owner_name }}</span>
            </div>
            <div class="info-row">
                <span class="label">Operating Status</span>
                <span class="value {{ $restaurant->status === 'open' ? 'status-open' : 'status-closed' }}">
                    {{ strtoupper($restaurant->status) }}
                </span>
            </div>
        </div>

        <div class="footer">
            Document generated on {{ date('d F Y') }} via FoodieBert Admin Portal.<br>
            Verification Code: {{ strtoupper(substr(md5($restaurant->id . time()), 0, 12)) }}
        </div>
    </div>
</body>
</html>