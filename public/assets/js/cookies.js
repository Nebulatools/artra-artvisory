// Cookie Consent Modal JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const cookieModal = document.getElementById('cookieModal');
    const cookieClose = document.getElementById('cookieClose');
    const cookieAccept = document.getElementById('cookieAccept');
    const cookieManage = document.getElementById('cookieManage');

    // Always show modal on page load
    showCookieModal();

    // Event listeners
    cookieClose.addEventListener('click', closeCookieModal);
    cookieAccept.addEventListener('click', acceptAllCookies);
    cookieManage.addEventListener('click', manageCookies);

    // Functions
    function showCookieModal() {
        cookieModal.style.display = 'block';
        // Prevent body scroll when modal is open
        document.body.style.overflow = 'hidden';
    }

    function hideCookieModal() {
        cookieModal.style.display = 'none';
        // Restore body scroll
        document.body.style.overflow = 'auto';
    }

    function closeCookieModal() {
        hideCookieModal();
    }

    function acceptAllCookies() {
        // Hide modal
        hideCookieModal();
        
        // Here you can add any analytics or tracking code
        console.log('All cookies accepted');
        
        // Optional: Show a brief confirmation message
        showConfirmationMessage('Cookies aceptadas. Gracias por tu preferencia.');
    }

    function manageCookies() {
        // Hide modal
        hideCookieModal();
        
        console.log('Cookie preferences managed');
        showConfirmationMessage('Preferencias de cookies guardadas.');
    }

    function showConfirmationMessage(message) {
        // Create a simple notification
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #000;
            color: #F2F2F2;
            padding: 15px 20px;
            border: 1px solid #000;
            z-index: 1001;
            font-family: 'Sohne', sans-serif;
            font-size: 14px;
            max-width: 300px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Remove notification after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 3000);
    }

    // Force show modal function (for testing)
    window.showCookieModal = function() {
        showCookieModal();
    };
}); 