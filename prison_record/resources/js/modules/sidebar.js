// resources/js/modules/sidebar.js
export function initializeSidebar() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.flex-1');
    let isSidebarOpen = true;

    sidebarToggle.addEventListener('click', () => {
        isSidebarOpen = !isSidebarOpen;
        if (isSidebarOpen) {
            sidebar.classList.remove('hidden');
            sidebar.classList.remove('w-0');
            sidebar.classList.add('w-72');
            mainContent.classList.add('ml-0');
        } else {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('w-72');
            sidebar.classList.add('w-0');
            mainContent.classList.remove('ml-72');
        }
    });
}