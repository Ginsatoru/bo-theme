/**
 * Header Scroll Behavior - OVERLAY VERSION (FIXED)
 * Handles transparent overlay header on desktop
 * Adds solid background on scroll
 * Handles admin bar spacing for logged-in users
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        const body = document.body;
        const header = document.querySelector('.site-header');
        const isAdminBar = body.classList.contains('admin-bar');
        
        if (!header) return;
        
        let lastScrollTop = 0;
        let ticking = false;
        
        function updateHeader(scrollTop) {
            const isMobile = window.innerWidth < 992;
            
            // Add scrolled class after 50px
            if (scrollTop > 50) {
                body.classList.add('scrolled');
                if (header) {
                    header.classList.add('is-sticky');
                }
            } else {
                // AT TOP OF PAGE
                body.classList.remove('scrolled');
                if (header) {
                    header.classList.remove('is-sticky');
                }
            }
            
            // Handle admin bar positioning
            if (isAdminBar) {
                if (isMobile) {
                    // Mobile with admin bar
                    header.style.top = '46px';
                } else {
                    // Desktop with admin bar
                    header.style.top = '32px';
                }
            } else {
                // No admin bar - header at top
                header.style.top = '0';
            }
            
            lastScrollTop = scrollTop;
        }
        
        function onScroll() {
            lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateHeader(lastScrollTop);
                    ticking = false;
                });
                
                ticking = true;
            }
        }
        
        function onResize() {
            // Recalculate header position on resize
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    updateHeader(lastScrollTop);
                    ticking = false;
                });
                
                ticking = true;
            }
        }
        
        // Listen to scroll events
        window.addEventListener('scroll', onScroll, { passive: true });
        
        // Listen to resize events (for responsive adjustments)
        window.addEventListener('resize', onResize, { passive: true });
        
        // Check initial state
        updateHeader(window.pageYOffset || document.documentElement.scrollTop);
        
    });
    
})();