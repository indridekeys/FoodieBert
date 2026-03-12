<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | FoodieBert Premium</title>
    <style>
        :root {
            --navy: #001f3f;
            --gold: #D4AF37;
            --cream: #fcfaf2;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', serif;
            background-color: var(--cream);
            color: var(--navy);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 31, 63, 0.8), rgba(0, 31, 63, 0.8)), 
                        url('{{ $restaurant->cover_image ?? "https://via.placeholder.com/1200x400" }}');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            border-bottom: 5px solid var(--gold);
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin: 0;
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .cuisine-tag {
            background: var(--gold);
            color: var(--navy);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        /* Section Styling */
        .container {
            max-width: 1100px;
            margin: -50px auto 50px;
            padding: 0 20px;
        }

        .white-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        h2 {
            color: var(--navy);
            border-left: 5px solid var(--gold);
            padding-left: 15px;
            margin-bottom: 20px;
        }

        .btn-gold {
            display: inline-block;
            background: var(--gold);
            color: var(--navy);
            padding: 15px 30px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 50px;
            transition: 0.3s;
            border: 2px solid var(--gold);
        }

        .btn-gold:hover {
            background: transparent;
            color: var(--gold);
        }

        @media (max-width: 768px) {
            .grid { grid-template-columns: 1fr; }
            .hero-content h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <section class="hero">
        <div class="hero-content">
            <span class="cuisine-tag">{{ $restaurant->cuisine_type }}</span>
            <h1>{{ $restaurant->name }}</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Exquisite Dining in {{ $restaurant->location ?? 'Bertoua' }}</p>
        </div>
    </section>

    <div class="container">
        <div class="grid">
            <div class="white-card">
                <h2>About the Restaurant</h2>
                <p>{{ $restaurant->description ?? 'Experience the finest culinary delights at ' . $restaurant->name . '. We pride ourselves on using fresh, local ingredients to create unforgettable flavors.' }}</p>
                
                <h2 style="margin-top: 40px;">Specialties</h2>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <span style="border: 1px solid var(--gold); padding: 5px 15px; border-radius: 15px;">Fine Dining</span>
                    <span style="border: 1px solid var(--gold); padding: 5px 15px; border-radius: 15px;">Local Flavors</span>
                    <span style="border: 1px solid var(--gold); padding: 5px 15px; border-radius: 15px;">Premium Service</span>
                </div>
            </div>

            <div class="white-card" style="text-align: center; border-top: 5px solid var(--navy);">
                <img src="{{ $restaurant->logo_url ?? 'https://via.placeholder.com/100' }}" style="width: 100px; border-radius: 50%; margin-bottom: 20px; border: 3px solid var(--gold);">
                <h3>Reserve a Table</h3>
                <p>Join us for an exceptional experience.</p>
                <a href="#" class="btn-gold">Book Now</a>
                <hr style="margin: 20px 0; opacity: 0.2;">
                <p><strong>Opening Hours:</strong><br>Mon - Sun: 09:00 - 22:00</p>
            </div>
        </div>
    </div>

</body>
</html>