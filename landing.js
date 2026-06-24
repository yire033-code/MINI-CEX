/**
 * MINI-CEX Landing Page — GSAP Animations & Interactions
 * ═══════════════════════════════════════════════════════
 */

(function () {
    'use strict';

    // ─── Register GSAP Plugins ───────────────────────
    gsap.registerPlugin(ScrollTrigger);

    // ─── Particles System ────────────────────────────
    function createParticles() {
        const container = document.getElementById('particles');
        if (!container) return;

        const count = window.innerWidth < 768 ? 20 : 50;

        for (let i = 0; i < count; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            const size = Math.random() * 3 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.opacity = Math.random() * 0.4 + 0.1;
            container.appendChild(particle);

            gsap.to(particle, {
                y: -(Math.random() * 100 + 50),
                x: Math.random() * 60 - 30,
                opacity: 0,
                duration: Math.random() * 6 + 4,
                repeat: -1,
                delay: Math.random() * 5,
                ease: 'none',
                onRepeat: function () {
                    gsap.set(particle, {
                        x: 0,
                        y: 0,
                        opacity: Math.random() * 0.4 + 0.1,
                        left: Math.random() * 100 + '%',
                        top: Math.random() * 100 + '%'
                    });
                }
            });
        }
    }

    // ─── Navbar Scroll Effect ────────────────────────
    function initNavbar() {
        const navbar = document.getElementById('navbar');
        const links = document.querySelectorAll('.nav-link');
        const sections = document.querySelectorAll('section[id]');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Active link highlighting
            let current = '';
            sections.forEach(section => {
                const top = section.offsetTop - 200;
                if (window.scrollY >= top) {
                    current = section.getAttribute('id');
                }
            });

            links.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Smooth scroll for nav links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                    closeMobileMenu();
                }
            });
        });
    }

    // ─── Mobile Menu ─────────────────────────────────
    function initMobileMenu() {
        const hamburger = document.getElementById('navHamburger');
        const mobileMenu = document.getElementById('mobileMenu');

        if (!hamburger || !mobileMenu) return;

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
            document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
        });

        mobileMenu.querySelectorAll('.mobile-link').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    function closeMobileMenu() {
        const hamburger = document.getElementById('navHamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        if (hamburger) hamburger.classList.remove('active');
        if (mobileMenu) mobileMenu.classList.remove('active');
        document.body.style.overflow = '';
    }

    // ─── Hero Entrance Animations ────────────────────
    function animateHero() {
        const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

        tl.to('#heroBadge', {
            opacity: 1,
            y: 0,
            duration: 0.8,
            delay: 0.3
        })
        .to('#heroTitle', {
            opacity: 1,
            y: 0,
            duration: 1
        }, '-=0.4')
        .to('#heroDesc', {
            opacity: 1,
            y: 0,
            duration: 0.8
        }, '-=0.5')
        .to('#heroButtons', {
            opacity: 1,
            y: 0,
            duration: 0.8
        }, '-=0.4')
        .to('#heroStats', {
            opacity: 1,
            y: 0,
            duration: 0.8
        }, '-=0.4')
        .to('#heroVisual', {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: 'power2.out'
        }, '-=0.6');

        // Float cards staggered
        gsap.to('.float-card', {
            opacity: 1,
            duration: 0.8,
            stagger: 0.3,
            delay: 1.8,
            ease: 'back.out(1.5)'
        });

        // Floating animation for cards
        gsap.to('#floatCard1', {
            y: -8,
            duration: 3,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2.5
        });

        gsap.to('#floatCard2', {
            y: 10,
            x: -5,
            duration: 3.5,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2.8
        });

        gsap.to('#floatCard3', {
            y: -6,
            x: 5,
            duration: 2.8,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 3.1
        });

        // Counter animation for hero stats
        document.querySelectorAll('.stat-number').forEach(el => {
            const target = parseInt(el.dataset.count, 10);
            gsap.to(el, {
                textContent: target,
                duration: 2,
                delay: 2,
                snap: { textContent: 1 },
                ease: 'power2.out'
            });
        });
    }

    // ─── Helper: Scroll reveal using fromTo (reliable) ─
    function scrollReveal(targets, fromVars, toVars, triggerEl, startPos) {
        ScrollTrigger.create({
            trigger: triggerEl,
            start: startPos || 'top 85%',
            once: true,
            onEnter: () => {
                gsap.fromTo(targets, fromVars, toVars);
            }
        });
    }

    // ─── Scroll Triggered Animations ─────────────────
    function initScrollAnimations() {
        // Trusted section
        scrollReveal(
            '.trusted-item',
            { opacity: 0, y: 20 },
            { opacity: 1, y: 0, stagger: 0.1, duration: 0.6, ease: 'power2.out' },
            '.trusted'
        );

        // Features section header
        scrollReveal(
            '#features .section-header',
            { opacity: 0, y: 40 },
            { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' },
            '#features',
            'top 85%'
        );

        // Feature cards with stagger
        scrollReveal(
            '.feature-card',
            { opacity: 0, y: 50, scale: 0.95 },
            { opacity: 1, y: 0, scale: 1, stagger: { amount: 0.6, from: 'start' }, duration: 0.7, ease: 'power3.out' },
            '.features-grid',
            'top 90%'
        );

        // Platform section
        document.querySelectorAll('.platform-row').forEach((row) => {
            const info = row.querySelector('.platform-info');
            const visual = row.querySelector('.platform-visual');
            const isReverse = row.classList.contains('platform-row-reverse');

            ScrollTrigger.create({
                trigger: row,
                start: 'top 85%',
                once: true,
                onEnter: () => {
                    gsap.fromTo(info,
                        { opacity: 0, x: isReverse ? 40 : -40 },
                        { opacity: 1, x: 0, duration: 0.9, ease: 'power3.out' }
                    );
                    gsap.fromTo(visual,
                        { opacity: 0, x: isReverse ? -40 : 40 },
                        { opacity: 1, x: 0, duration: 0.9, delay: 0.2, ease: 'power3.out' }
                    );
                }
            });
        });

        // Platform visual elements — parallax on scroll
        gsap.to('.pv-app-showcase', {
            scrollTrigger: {
                trigger: '.pv-app',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            },
            y: -30,
            ease: 'none'
        });

        gsap.to('.pv-browser', {
            scrollTrigger: {
                trigger: '.pv-web',
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1
            },
            y: -20,
            ease: 'none'
        });

        // Statistics counters
        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target, 10);

            ScrollTrigger.create({
                trigger: counter,
                start: 'top 90%',
                once: true,
                onEnter: () => {
                    gsap.to(counter, {
                        textContent: target,
                        duration: 2.5,
                        snap: { textContent: 1 },
                        ease: 'power2.out'
                    });

                    // Also animate the bar
                    const card = counter.closest('.stat-card');
                    if (card) {
                        card.setAttribute('data-stat-visible', '');
                    }
                }
            });
        });

        // Stats cards
        scrollReveal(
            '.stat-card',
            { opacity: 0, y: 40, scale: 0.95 },
            { opacity: 1, y: 0, scale: 1, stagger: 0.12, duration: 0.7, ease: 'power3.out' },
            '.stats-grid',
            'top 90%'
        );

        // How it works — steps
        scrollReveal(
            '.step-card',
            { opacity: 0, y: 50 },
            { opacity: 1, y: 0, stagger: 0.2, duration: 0.8, ease: 'power3.out' },
            '.steps-timeline',
            'top 85%'
        );

        // FAQ items
        scrollReveal(
            '.faq-item',
            { opacity: 0, y: 30 },
            { opacity: 1, y: 0, stagger: 0.1, duration: 0.6, ease: 'power3.out' },
            '.faq-grid',
            'top 90%'
        );

        // CTA section
        scrollReveal(
            '.cta-content',
            { opacity: 0, y: 40, scale: 0.97 },
            { opacity: 1, y: 0, scale: 1, duration: 0.9, ease: 'power3.out' },
            '.cta',
            'top 85%'
        );

        // Browser chart bars animation
        ScrollTrigger.create({
            trigger: '.bc-chart-bars',
            start: 'top 95%',
            once: true,
            onEnter: () => {
                gsap.fromTo('.bc-bar',
                    { scaleY: 0, transformOrigin: 'bottom' },
                    { scaleY: 1, duration: 1.2, stagger: 0.1, ease: 'power3.out' }
                );
            }
        });
    }

    // ─── FAQ Accordion ───────────────────────────────
    function initFAQ() {
        document.querySelectorAll('.faq-question').forEach(btn => {
            const toggleFAQ = (e) => {
                if (e.type === 'touchstart') {
                    e.preventDefault();
                }
                const item = btn.parentElement;
                const wasActive = item.classList.contains('active');

                // Close all
                document.querySelectorAll('.faq-item').forEach(faq => {
                    faq.classList.remove('active');
                });

                // Toggle current
                if (!wasActive) {
                    item.classList.add('active');
                }
            };

            btn.addEventListener('click', toggleFAQ);
            btn.addEventListener('touchstart', toggleFAQ, { passive: false });
        });
    }

    // ─── Tilt/Parallax on Mouse Move (Hero) ──────────
    function initParallax() {
        const hero = document.querySelector('.hero');
        const phone = document.querySelector('.phone-mockup');
        const cards = document.querySelectorAll('.float-card');

        if (!hero || !phone) return;

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            gsap.to(phone, {
                rotateY: x * 8,
                rotateX: -y * 5,
                duration: 0.6,
                ease: 'power2.out',
                transformPerspective: 800
            });

            cards.forEach((card, i) => {
                const factor = (i + 1) * 3;
                gsap.to(card, {
                    x: x * factor * 2,
                    y: y * factor * 2,
                    duration: 0.8,
                    ease: 'power2.out'
                });
            });
        });

        hero.addEventListener('mouseleave', () => {
            gsap.to(phone, {
                rotateY: 0,
                rotateX: 0,
                duration: 0.8,
                ease: 'power2.out'
            });
        });
    }

    // ─── Magnetic Button Effect ──────────────────────
    function initMagneticButtons() {
        const buttons = document.querySelectorAll('.btn-hero-primary, .btn-hero-outline, .btn-cta-primary, .btn-cta-outline');

        buttons.forEach(btn => {
            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;

                gsap.to(btn, {
                    x: x * 0.15,
                    y: y * 0.15,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, {
                    x: 0,
                    y: 0,
                    duration: 0.5,
                    ease: 'elastic.out(1, 0.3)'
                });
            });
        });
    }

    // ─── Scroll Progress Indicator (navbar bottom) ───
    function initScrollProgress() {
        const progressBar = document.createElement('div');
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: linear-gradient(90deg, #3b82f6, #a855f7, #fbbf24);
            z-index: 10001;
            transition: none;
            border-radius: 0 2px 2px 0;
        `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            progressBar.style.width = progress + '%';
        });
    }

    // ─── Phone Screen Shimmer ────────────────────────
    function initPhoneShimmer() {
        const screenCards = document.querySelectorAll('.screen-card');
        screenCards.forEach((card, i) => {
            gsap.fromTo(card,
                { backgroundPosition: '-200% 0' },
                {
                    backgroundPosition: '200% 0',
                    duration: 3,
                    repeat: -1,
                    delay: i * 0.5,
                    ease: 'none'
                }
            );
        });
    }

    // ─── Initialize Everything ───────────────────────
    function init() {
        const isTouchDevice = window.matchMedia('(hover: none)').matches;
        createParticles();
        initNavbar();
        initMobileMenu();
        animateHero();
        initScrollAnimations();
        initFAQ();
        
        if (!isTouchDevice) {
            initParallax();
            initMagneticButtons();
        }
        
        initScrollProgress();
        initPhoneShimmer();
    }

    // Wait for DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
