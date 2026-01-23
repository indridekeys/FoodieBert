<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">


<div class="regfood-footer-wrapper">
    <div class="footer-content">
        <div class="footer-column">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="FoodieBert" class="footer-logo-img">
                <h2 class="curvy-logo-text">
                    <span class="logo-white">Foodie</span><span class="logo-gold">Bert</span>
                </h2>
            </div>
            <p style="color: #bdc3c7; line-height: 1.8;">
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
                    <span>+44 (0) 20 9994 7740</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-paper-plane"></i>
                    <span>support@foodiebert.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-location-dot"></i>
                    <span>Blackwell St, Alaska, USA</span>
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