// resources/js/modules/modal.js
export function initializeModal() {
    window.openModal = function() {
        document.getElementById("logoutModal").classList.remove("hidden");
    }

    window.closeModal = function() {
        document.getElementById("logoutModal").classList.add("hidden");
    }

    window.logout = function() {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log(response); // Log the entire response
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
            closeModal();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    
}
