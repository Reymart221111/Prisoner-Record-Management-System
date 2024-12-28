// app.js

// Import modules
import './bootstrap';
import { initializeModal } from './modules/modal';
import { initializeDropdown } from './modules/dropdown';
import { initializeSidebar } from './modules/sidebar';
import { imagePreview } from './modules/imagePreview';
import './modules/flash.js';
import { initializePasswordToggle } from './modules/passwordToggle';
import { initializePrisonCharts } from './modules/apexCharts.js';


// Initialize all modules when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initializeModal();
    initializeDropdown();
    initializeSidebar();
    imagePreview();
    closeFlash();
    initializePasswordToggle();

    // Initialize charts if the chart data element exists
    const chartDataElement = document.getElementById('chart-data');
    if (chartDataElement) {
        try {
            const chartData = JSON.parse(chartDataElement.value);
            initializePrisonCharts(chartData);
        } catch (error) {
            console.error('Error parsing chart data:', error);
        }
    }
});

