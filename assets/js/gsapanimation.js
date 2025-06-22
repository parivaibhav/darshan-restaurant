const paragraph = document.querySelector('#animated-text');
const words = paragraph.textContent.split(' ');

paragraph.innerHTML = words.map(word => `<span class="word">${word}</span>`).join(' ');



document.addEventListener("DOMContentLoaded", function () {
    gsap.registerPlugin(ScrollTrigger);


});
gsap.to(".heading-left", {
    x: 0,
    y: 0,
    opacity: 1,
    duration: 1.3,
    ease: "power3.out",
    scrollTrigger: {
        trigger: "#animated-heading",
        start: "top 80%",
        end: "top 30%",
        scrub: true
    }
});

gsap.to(".heading-right", {
    x: 0,
    y: 0,
    opacity: 1,
    duration: 1.3,
    ease: "power3.out",
    scrollTrigger: {
        trigger: "#animated-heading",
        start: "top 80%",
        end: "top 30%",
        scrub: true
    }
});
gsap.set(".word", { opacity: 0, y: 20 });

gsap.to(".word", {
    opacity: 1,
    y: 0,
    duration: 0.2,
    stagger: 0.02,
    ease: "power3.out"
});
