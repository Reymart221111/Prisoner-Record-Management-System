export function imagePreview() {
    const profileImageInput = document.getElementById('profile_image');
    const previewImage = document.getElementById('preview');

    // Exit the function if either element is missing
    if (!profileImageInput || !previewImage) {
        return;
    }

    // Add event listener if elements are found
    profileImageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
}
