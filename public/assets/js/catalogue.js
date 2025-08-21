// Catalogue Accordion JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Get all catalogue toggles and their corresponding content
    const catalogueToggles = [
        {
            toggle: document.getElementById('catalogueToggle'),
            content: document.getElementById('dropdownCatalogue')
        },
        {
            toggle: document.getElementById('catalogueToggle2'),
            content: document.getElementById('dropdownCatalogue2')
        },
        {
            toggle: document.getElementById('catalogueToggle3'),
            content: document.getElementById('dropdownCatalogue3')
        }
    ];

    // Track which sections are open
    let openSections = [];

    // Add click event listeners to each toggle
    catalogueToggles.forEach((item, index) => {
        if (item.toggle && item.content) {
            item.toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleSection(index);
            });
        }
    });

    // Close sections when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && openSections.length > 0) {
            closeAllSections();
        }
    });

    // Functions
    function toggleSection(index) {
        const item = catalogueToggles[index];
        const isOpen = openSections.includes(index);
        
        if (isOpen) {
            closeSection(index);
        } else {
            openSection(index);
        }
    }

    function openSection(index) {
        const item = catalogueToggles[index];
        
        // Add active class to content
        item.content.classList.add('active');
        
        // Update title text (change + to -)
        const titleText = item.toggle.textContent.replace('+ ', '- ');
        item.toggle.textContent = titleText;
        
        // Change title color
        item.toggle.style.color = '#666';
        
        // Add to open sections
        if (!openSections.includes(index)) {
            openSections.push(index);
        }
        
        // Smooth scroll to the opened section
        setTimeout(() => {
            item.toggle.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    }

    function closeSection(index) {
        const item = catalogueToggles[index];
        
        // Remove active class from content
        item.content.classList.remove('active');
        
        // Update title text (change - to +)
        const titleText = item.toggle.textContent.replace('- ', '+ ');
        item.toggle.textContent = titleText;
        
        // Reset title color
        item.toggle.style.color = '#000';
        
        // Remove from open sections
        const sectionIndex = openSections.indexOf(index);
        if (sectionIndex > -1) {
            openSections.splice(sectionIndex, 1);
        }
    }

    function closeAllSections() {
        openSections.slice().forEach(index => {
            closeSection(index);
        });
    }

    // Handle CTA button clicks
    /* const ctaButtons = document.querySelectorAll('.cta-button');
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const buttonText = this.textContent.trim();
            showNotification(`${buttonText} clicked`); */
            
            // Add your navigation logic here
            // For example:
            // if (buttonText === 'Learn more') {
            //     window.location.href = 'collection-details.php';
            // }
    /*     });
    }); */

    // Notification function
    function showNotification(message) {
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

    // Public functions for external access
    window.catalogueAccordion = {
        openSection: openSection,
        closeSection: closeSection,
        closeAllSections: closeAllSections,
        toggleSection: toggleSection
    };
});
