const swiper = new Swiper('.myReviewSwiper', {
    slidesPerView: 1,
    spaceBetween: 50,
    loop: true,
    centeredSlides: true,
    pagination: {
        el: '.swiper-pagination-custom',
        clickable: true,
        renderBullet: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        },
    },
    navigation: {
        nextEl: '.swiper-button-next-custom',
        prevEl: '.swiper-button-prev-custom',
    },
    breakpoints: {
        1024: {
            slidesPerView: 2,
            centeredSlides: false,
        }
    }
});