const cursor = document.getElementById('custom-cursor');
let mouseX = 0;
let mouseY = 0;
let currentX = 0;
let currentY = 0;
const speed = 0.15; // Lower = smoother but slower

document.addEventListener('mousemove', e => {
    mouseX = e.clientX;
    mouseY = e.clientY;
});

function animateCursor() {
    currentX += (mouseX - currentX) * speed;
    currentY += (mouseY - currentY) * speed;

    cursor.style.left = `${currentX}px`;
    cursor.style.top = `${currentY}px`;

    requestAnimationFrame(animateCursor);
}

animateCursor();