<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .id-card {
            width: 350px;
            height: 200px;
            padding: 20px;
            border: 2px solid #d4af37; /* Gold Border */
            background: #fff;
            border-radius: 10px;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #d4af37;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .header h2 { margin: 0; font-size: 16px; color: #1a1a1a; letter-spacing: 2px; }
        .photo-box {
            float: left;
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            margin-right: 15px;
        }
        .photo-box img { width: 100%; height: 100%; object-fit: cover; }
        .details { float: left; width: 200px; }
        .details p { margin: 2px 0; font-size: 12px; }
        .label { font-weight: bold; font-size: 10px; color: #888; text-transform: uppercase; }
        .footer {
            position: absolute;
            bottom: 10px;
            right: 20px;
            font-size: 9px;
            color: #d4af37;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <h2>CITIZEN REGISTRY</h2>
        </div>

        <div class="photo-box">
            @if($user->profile_picture)
                <img src="{{ public_path('storage/' . $user->profile_picture) }}">
            @else
                <div style="text-align:center; padding-top:25px; color:#ccc;">NO PHOTO</div>
            @endif
        </div>

        <div class="details">
            <p class="label">Name</p>
            <p style="font-weight: bold; font-size: 14px;">{{ $user->name }}</p>
            
            <p class="label">Email</p>
            <p>{{ $user->email }}</p>
            
            <p class="label">Access Level</p>
            <p>{{ strtoupper($user->role) }}</p>
            
            <p class="label">Matricule</p>
            <p style="font-family: monospace; background: #eee; padding: 2px;">{{ $user->matricule ?? 'FB-USR-'.$user->id }}</p>
        </div>

        <div class="footer">
            THE FOODIEBERT TEAM
        </div>
    </div>
</body>
</html>