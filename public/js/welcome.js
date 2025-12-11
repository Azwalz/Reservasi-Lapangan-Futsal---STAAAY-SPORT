$(document).ready(function() {
    // Hide overflow on body initially for the welcome screen
    $('body').addClass('overflow-hidden');

    $('#welcome-btn').click(function() {
        // Fade out welcome screen
        $('#welcome').fadeOut(500, function() {
            // After fade out, show main content
            $('.parent-container').show();
            // Remove overflow hidden from body
            $('body').removeClass('overflow-hidden');

            // Initialize Bootstrap ScrollSpy after content is visible
            setTimeout(() => {
                const scrollSpy = new bootstrap.ScrollSpy(document.body, {
                    target: '#navbar'
                });
            }, 100);

            // Initialize AOS (Animate On Scroll)
            AOS.init({
                once: true,
                duration: 600,
            });

            // Trigger SVG animation and navbar shadow check on load after welcome screen
            handleSVG();
            navbarShadow();
        });
    });

    // Function to add/remove shadow from navbar based on scroll position
    function navbarShadow() {
        if ($(window).scrollTop() === 0) {
            $('#navbar').removeClass('shadow');
        } else {
            $('#navbar').addClass('shadow');
        }
    }

    // Bind navbarShadow to scroll and load events
    $(window).scroll(function() {
        navbarShadow();
    });

    // Check on page load (after welcome screen if it's still visible)
    $(window).on('load', function() {
        if ($('#welcome').is(':hidden')) {
            navbarShadow();
        }
    });

    // Helper function to check if an element is in the viewport
    $.fn.is_on_screen = function() {
        var win = $(window);
        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };

    // Function to handle SVG line drawing animation
    function handleSVG() {
        const svgParent = $('#svg-parent');
        // Check if SVG parent is in viewport and SVG lines are not already active
        if (svgParent.length && svgParent.is_on_screen() && !$('.svg-container svg').hasClass('active')) {
            $('.svg-container svg').addClass('active');
        }
    }

    // Bind handleSVG to scroll and load events
    $(window).scroll(function() {
        // Only trigger if the parent container is visible (i.e., welcome screen is gone)
        if ($('.parent-container').is(':visible')) {
            handleSVG();
        }
    });

    // Initial check on load (after welcome screen if it's still visible)
    $(window).on('load', function() {
        if ($('.parent-container').is(':visible')) {
            handleSVG();
        }
    });
});