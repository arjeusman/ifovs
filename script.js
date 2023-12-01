ScrollReveal({ reset: true });

ScrollReveal().reveal('#hero > *', {
    delay: 200,
    duration: 200,
    easing: 'ease',
    distance: '20px',
    origin: 'top',
    interval: 200,
    scale: 0.8
});

ScrollReveal().reveal('.content', {
    delay: 200,
    duration: 500,
    easing: 'ease'
});

ScrollReveal().reveal('.content img', {
    delay: 200,
    duration: 500,
    easing: 'ease',
    interval: 200
});