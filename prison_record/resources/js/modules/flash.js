// resources/js/flash.js
window.closeFlash = function() {
    const flash = document.getElementById('flash-message');
    
    // Exit the function silently if the flash-message element is not found
    if (!flash) return;

    // Proceed with hiding the flash message if the element exists
    flash.classList.replace('opacity-100', 'opacity-0');
    setTimeout(() => {
        flash.style.display = 'none';
    }, 300);
};
