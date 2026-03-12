<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">

<style>
    /* --- MATCHING LOGO BOX FROM HEADER --- */
    .footer-logo-box {
        display: inline-flex;
        align-items: center;
        background: #0a192f; 
        border: 2px solid #C5A059;
        padding: 5px 12px;
        border-radius: 4px;
        text-decoration: none;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .footer-logo-box:hover {
        background: #112240;
    }

    .footer-logo-box .crazy-icons-static {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-right: 8px;
        font-size: 1.1rem;
    }
    
    /* Standing straight as requested */
    .footer-logo-box .icon-spoon { color: #C5A059; transform: rotate(0deg); }
    .footer-logo-box .icon-fork { color: #FF69B4; transform: rotate(0deg); }

    .footer-logo-box .logo-text {
        font-family: 'Great Vibes', cursive; /* Applied Great Vibes */
        font-size: 1.8rem; /* Increased size because Great Vibes runs small */
        margin: 0;
        line-height: 1;
        white-space: nowrap;
        letter-spacing: 1px;
    }

    /* Standardizing dot color in links */
    .gold-dot {
        color: #C5A059;
        font-size: 8px;
        margin-right: 10px;
    }

    .regfood-footer-wrapper h4 {
        color: #fff;
        margin-bottom: 20px;
        font-size: 1.2rem;
        position: relative;
    }
</style>

<div class="regfood-footer-wrapper">
    <div class="footer-content">
        <div class="footer-column">
            <a href="{{ route('home') }}" class="footer-logo-box">
                <div class="crazy-icons-static">
                    <i class="fas fa-spoon icon-spoon"></i>
                    <i class="fas fa-utensils icon-fork"></i>
                </div>
                <h1 class="logo-text">
                    <span style="color: #fff;">Foodie</span><span style="color: #C5A059;">Bert</span>
                </h1>
            </a>

            <p style="color: #bdc3c7; line-height: 1.8; margin-top: 10px;">
                Taste the excellence of traditional recipes blended with modern culinary arts. Your destination for premium dining and delivery.
            </p>
            <div class="social-row">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-column">
            <h4>Quick Links</h4>
            <ul class="footer-links">
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Home</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> About Us</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Services</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Support</h4>
            <ul class="footer-links">
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Privacy Policy</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Terms of Use</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> Refund Policy</a></li>
                <li><a href="#"><i class="fas fa-square gold-dot"></i> FAQ</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Contact Info</h4>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone-volume"></i>
                    <span>+237 6 83 06 78 44</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>foodiebert@support.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-location-dot"></i>
                    <span>Bertoua, East Region, Cameroon</span>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-line">
        <p>Copyright &copy; <strong>FoodieBert</strong> {{ date('Y') }}. All Rights Reserved</p>
        <div class="scroll-up-btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
</div>