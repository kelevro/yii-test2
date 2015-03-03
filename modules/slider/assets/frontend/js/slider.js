$('.slider').mobilyslider({
    content: '.sliderContent',
    children: 'div',
    transition: 'horizontal',
    animationSpeed: 500,
    autoplay: true,
    autoplaySpeed: 3000,
    pauseOnHover: true,
    bullets: false,
    arrows: true,
    arrowsHide: true,
    prev: 'prev',
    next: 'next',
    animationStart: function(){},
    animationComplete: function(){}
});