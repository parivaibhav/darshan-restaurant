const paragraph = document.querySelector('#animated-text');
const words = paragraph.textContent.split(' ');

paragraph.innerHTML = words.map(word => `<span class="word">${word}</span>`).join(' ');



document.addEventListener("DOMContentLoaded", function () {
    gsap.registerPlugin(ScrollTrigger);

    const lines = document.querySelectorAll("#animated-heading .line");

    gsap.from("#animated-heading .line", {
        scrollTrigger: {
            trigger: "#animated-heading",
            start: "top 80%",
            toggleActions: "play none none none"
        },
        x: 100, // Slide in from right
        opacity: 0,
        filter: "blur(6px)",
        skewX: 10,
        duration: 1.2,
        ease: "power4.out",
        stagger: 0.2,
        clearProps: "all" // Optional cleanup
    });
    gsap.from(".hero-img img", {
        scrollTrigger: {
            trigger: ".hero-img",
            start: "top 85%",
            toggleActions: "play none none none"
        },
        scale: 0.8,
        rotateY: 20,
        y: 50,
        opacity: 0,
        filter: "blur(10px)",
        duration: 1.2,
        ease: "power4.out",
        clearProps: "transform,opacity,filter" // optional clean-up
    });

});

gsap.set(".word", { opacity: 0, y: 20 });

gsap.to(".word", {
    opacity: 1,
    y: 0,
    duration: 0.2,
    stagger: 0.02,
    ease: "power3.out"
});
