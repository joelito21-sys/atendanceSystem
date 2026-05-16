<style>
    /* ── Canvas BG ── */
    #canvas-bg {
        position: fixed; inset: 0; z-index: 0;
        pointer-events: none;
    }

    /* ── Animated gradient orbs ── */
    .orb {
        position: fixed; border-radius: 50%;
        filter: blur(120px); opacity: 0.18;
        pointer-events: none; z-index: 0;
        animation: orbFloat 12s ease-in-out infinite;
    }
    .orb-1 { width: 700px; height: 700px; background: var(--clr-accent, #3b82f6); top: -200px; left: -200px; animation-delay: 0s; }
    .orb-2 { width: 600px; height: 600px; background: var(--clr-accent2, #8b5cf6); bottom: -150px; right: -150px; animation-delay: -4s; }
    .orb-3 { width: 400px; height: 400px; background: var(--clr-accent3, #06b6d4); top: 40%; left: 40%; animation-delay: -8s; }

    @keyframes orbFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(40px, -30px) scale(1.05); }
        66% { transform: translate(-20px, 20px) scale(0.97); }
    }
</style>

<!-- Animated Background -->
<canvas id="canvas-bg"></canvas>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<script>
// ── Particle Canvas ──
(function() {
    // Only run once if multiple includes happen
    if(window.particlesInitialized) return;
    window.particlesInitialized = true;

    const canvas = document.getElementById('canvas-bg');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, particles = [];
    const N = 80;

    function resize() {
        W = canvas.width = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    window.addEventListener('resize', resize);
    resize();

    class Particle {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * W;
            this.y = Math.random() * H;
            this.r = Math.random() * 1.5 + 0.3;
            this.vx = (Math.random() - 0.5) * 0.3;
            this.vy = (Math.random() - 0.5) * 0.3;
            this.alpha = Math.random() * 0.4 + 0.1;
            const colors = ['#3b82f6','#8b5cf6','#06b6d4','#60a5fa'];
            this.color = colors[Math.floor(Math.random() * colors.length)];
        }
        update() {
            this.x += this.vx; this.y += this.vy;
            if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
        }
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.alpha;
            ctx.fill();
        }
    }

    for (let i = 0; i < N; i++) particles.push(new Particle());

    function drawLines() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = '#3b82f6';
                    ctx.globalAlpha = (1 - dist / 120) * 0.1;
                    ctx.lineWidth = 0.5;
                    ctx.stroke();
                }
            }
        }
    }

    function loop() {
        ctx.clearRect(0, 0, W, H);
        particles.forEach(p => { p.update(); p.draw(); });
        drawLines();
        requestAnimationFrame(loop);
    }
    loop();

    // ── Parallax orbs on mousemove ──
    document.addEventListener('mousemove', (e) => {
        const x = (e.clientX / window.innerWidth - 0.5) * 30;
        const y = (e.clientY / window.innerHeight - 0.5) * 30;
        const orb1 = document.querySelector('.orb-1');
        const orb2 = document.querySelector('.orb-2');
        const orb3 = document.querySelector('.orb-3');
        if (orb1) orb1.style.transform = `translate(${x}px, ${y}px)`;
        if (orb2) orb2.style.transform = `translate(${-x}px, ${-y}px)`;
        if (orb3) orb3.style.transform = `translate(${x * 0.5}px, ${y * 0.5}px)`;
    });
})();
</script>
