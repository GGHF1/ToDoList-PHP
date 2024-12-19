function toggleInfo(itemId) {
    const modal = document.getElementById(`info-modal-${itemId}`);
    const isOpen = modal.style.display === 'block';
    // Close all modals
    document.querySelectorAll('.info-modal').forEach(modal => modal.style.display = 'none');
    if (!isOpen) {
        // Open the selected modal
        modal.style.display = 'block';

        // Add event listener to close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeInfoModal(itemId);
            }
        });
    }
}

function closeInfoModal(itemId) {
    const modal = document.getElementById(`info-modal-${itemId}`);
    modal.style.display = 'none';
}