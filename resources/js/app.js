import './bootstrap';

import Alpine from 'alpinejs';
import { gsap } from 'gsap';
import { createIcons, icons } from 'lucide';
import Chart from 'chart.js/auto';

window.Chart = Chart;
window.Alpine = Alpine;
window.gsap = gsap;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });

    gsap.from('.gsap-fade-up', {
        opacity: 0,
        y: 28,
        duration: 0.75,
        stagger: 0.08,
        ease: 'power3.out',
    });

    gsap.from('.gsap-scale', {
        opacity: 0,
        scale: 0.94,
        duration: 0.65,
        stagger: 0.06,
        ease: 'back.out(1.7)',
    });
});