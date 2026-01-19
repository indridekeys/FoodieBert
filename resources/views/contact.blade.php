<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | L'Éclat Bertoua</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Sidebar Fixes for this page */
        .sidebar { z-index: 9999 !important; }
        .sidebar-overlay { z-index: 9998 !important; }

        /* Contact Page Specific Styles */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .form-group { margin-bottom: 25px; }
        .form-input {
            width: 100%;
            padding: 15px 0;
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(4, 18, 12, 0.2);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem;
            color: #04120c;
            outline: none;
            transition: border-color 0.3s;
        }
        .form-input:focus { border-bottom-color: #d4af37; }
        .info-item { margin-bottom: 40px; }
        
        /* Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 968px) {
            .contact-grid { grid-template-columns: 1fr; gap: 60px; }
        }
    </style>
</head>
<body>

    
    <x-header />

    <main>
        <section class="hero" style="height: 50vh; background: linear-gradient(rgba(4, 18, 12, 0.8), rgba(4, 18, 12, 0.8)), url('https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: white;">
            <div class="hero-content reveal">
                <span class="font-curly" style="font-size: 2.8rem; color: #d4af37;">Inquire with the East</span>
                <h2 class="font-serif" style="font-size: 4rem; margin-top: 10px;">Get in Touch</h2>
            </div>
        </section>

        <section style="padding: 120px 10%; background: #ffffff;">
            <div class="contact-grid">
                
                <div class="reveal">
                    <span class="label" style="color: #d4af37; letter-spacing: 2px; font-weight: 600;">RESERVATIONS & INQUIRIES</span>
                    <h3 class="font-serif" style="font-size: 2.8rem; margin: 20px 0 40px; color: #04120c;">The Gateway to <br>Bertoua Hospitality</h3>
                    
                    <div class="info-item">
                        <h5 class="label" style="font-size: 0.75rem; opacity: 0.6; text-transform: uppercase;">Headquarters</h5>
                        <p class="font-serif" style="font-size: 1.2rem;">Avenue Commerciale, Bertoua<br>East Region, Cameroon</p>
                    </div>

                    <div class="info-item">
                        <h5 class="label" style="font-size: 0.75rem; opacity: 0.6; text-transform: uppercase;">Direct Line</h5>
                        <p class="font-serif" style="font-size: 1.2rem;">(+237) 6XX XXX XXX</p>
                    </div>

                    <div class="info-item">
                        <h5 class="label" style="font-size: 0.75rem; opacity: 0.6; text-transform: uppercase;">Email Dispatch</h5>
                        <p class="font-serif" style="font-size: 1.2rem;">concierge@leclat-bertoua.cm</p>
                    </div>
                </div>

                <div class="reveal" style="background: #fffafa; padding: 60px; border-radius: 4px; border: 1px solid rgba(212, 175, 55, 0.1);">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label class="label" style="font-size: 0.7rem; text-transform: uppercase;">Your Name</label>
                            <input type="text" class="form-input" placeholder="e.g. Jean-Pierre Mokolo" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="label" style="font-size: 0.7rem; text-transform: uppercase;">Email Address</label>
                            <input type="email" class="form-input" placeholder="name@domain.com" required>
                        </div>

                        <div class="form-group">
                            <label class="label" style="font-size: 0.7rem; text-transform: uppercase;">Subject</label>
                            <select class="form-input" style="border-radius: 0; appearance: none;">
                                <option>Private Dining Reservation</option>
                                <option>Catering for Events</option>
                                <option>Local Guide Partnerships</option>
                                <option>Courier Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="label" style="font-size: 0.7rem; text-transform: uppercase;">Message</label>
                            <textarea class="form-input" rows="4" placeholder="How can we assist you?"></textarea>
                        </div>

                        <button type="submit" style="width: 100%; margin-top: 20px; background: #04120c; color: white; border: none; padding: 18px; cursor: pointer; text-transform: uppercase; letter-spacing: 2px; font-weight: 600; transition: 0.3s;">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <x-footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const header = document.getElementById('mainHeader');

            // Handle All Clicks
            document.addEventListener('click', (e) => {
                // Open Sidebar (targets menuBtn or hamburger icon)
                if (e.target.closest('#menuBtn') || e.target.closest('.hamburger')) {
                    e.preventDefault();
                    sidebar?.classList.add('active');
                    overlay?.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }

                // Close Sidebar (targets overlay or close button)
                if (e.target.closest('#sidebarOverlay') || e.target.closest('#closeBtn')) {
                    sidebar?.classList.remove('active');
                    overlay?.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Header Scroll Logic
            window.addEventListener('scroll', () => {
                if (header) {
                    window.scrollY > 50 ? header.classList.add('scrolled') : header.classList.remove('scrolled');
                }
            });

            // Reveal Animation Logic
            const reveal = () => {
                const reveals = document.querySelectorAll(".reveal");
                reveals.forEach(el => {
                    const windowHeight = window.innerHeight;
                    const elementTop = el.getBoundingClientRect().top;
                    if (elementTop < windowHeight - 100) el.classList.add("active");
                });
            };
            window.addEventListener("scroll", reveal);
            reveal(); 
        });
    </script>
</body>
</html>