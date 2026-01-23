<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | FoodieBert Bertoua</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>

    @include('components.header')

    <main>
        <section class="testimonial-carousel-wrapper">
    <div class="container">
        <div class="swiper myReviewSwiper">
            <div class="swiper-wrapper">
                
                <div class="swiper-slide">
                    <div class="modern-review-card">
                        <div class="user-avatar">
                            <img src="https://i.pravatar.cc/150?u=1" alt="User">
                        </div>
                        <div class="quote-group">
                            <span class="q-icon">“</span>
                            <div class="user-meta">
                                <h3>Isita Islam</h3>
                                <p>NYC USA</p>
                            </div>
                            <span class="q-icon">”</span>
                        </div>
                        <p class="content">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus praesentium quaerat nihil magnam a porro eaque numquam.
                        </p>
                        <div class="rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="modern-review-card">
                        <div class="user-avatar">
                            <img src="https://i.pravatar.cc/150?u=2" alt="User">
                        </div>
                        <div class="quote-group">
                            <span class="q-icon">“</span>
                            <div class="user-meta">
                                <h3>Isita Islam</h3>
                                <p>NYC USA</p>
                            </div>
                            <span class="q-icon">”</span>
                        </div>
                        <p class="content">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut accusamus praesentium quaerat nihil magnam a porro eaque numquam.
                        </p>
                        <div class="rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                    </div>
                </div>

                </div>

            <div class="carousel-footer">
                <div class="swiper-button-prev-custom"><i class="fas fa-arrow-left"></i></div>
                <div class="swiper-pagination-custom"></div>
                <div class="swiper-button-next-custom"><i class="fas fa-arrow-right"></i></div>
            </div>
        </div>
    </div>
</section>



    </main>

    @include('components.footer')

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/about.js') }}"></script>
</body>
</html>