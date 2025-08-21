// Dropdown Menu JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const dropdownMenu = document.getElementById('dropdownMenu');
    
    let isMenuOpen = false;

    // Toggle menu on click
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleMenu();
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!menuToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            closeMenu();
        }
    });

    // Close menu when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && isMenuOpen) {
            closeMenu();
        }
    });

    // Close menu when clicking on menu links
    const menuLinks = dropdownMenu.querySelectorAll('.menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            closeMenu();
            // Opcional: mostrar mensaje antes de navegar
            showNavigationMessage('Navigating to ' + this.textContent);
            // Redirigir después de un pequeño delay para que se vea la animación/mensaje
            setTimeout(() => {
                window.location.href = this.href;
            }, 300);
        });
    });

    // Functions
    function toggleMenu() {
        if (isMenuOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    function openMenu() {
        dropdownMenu.style.display = 'grid';
        // Small delay to ensure display is set before adding active class
        setTimeout(() => {
            dropdownMenu.classList.add('active');
            isMenuOpen = true;
            menuToggle.style.color = '#666';
        }, 10);
    }

    function closeMenu() {
        dropdownMenu.classList.remove('active');
        isMenuOpen = false;
        menuToggle.style.color = '#000';
        
        // Hide after animation completes
        setTimeout(() => {
            if (!isMenuOpen) {
                dropdownMenu.style.display = 'none';
            }
        }, 300);
    }

    function showNavigationMessage(message) {
        // Create a simple notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: #000;
            color: #F2F2F2;
            padding: 15px 20px;
            border: 1px solid #000;
            z-index: 1001;
            font-family: 'Sohne', sans-serif;
            font-size: 14px;
            max-width: 250px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 10);
        
        // Remove notification after 2.5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(20px)';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 2500);
    }

    // Public function to programmatically close menu
    window.closeDropdownMenu = function() {
        closeMenu();
    };

    // Public function to programmatically open menu
    window.openDropdownMenu = function() {
        openMenu();
    };
}); 