function toggleAccountInfo() {
    const modal = document.getElementById('account-modal');
    const isOpen = modal.style.display === 'block';

    // Close all other modals (if needed)
    document.querySelectorAll('.modal').forEach(modal => modal.style.display = 'none');

    if (!isOpen) {
        // Open the account modal
        modal.style.display = 'block';

        // Add event listener to close modal when clicking outside of it
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeAccountModal();
            }
        });
    }
}

function closeAccountModal() {
    const modal = document.getElementById('account-modal');
    modal.style.display = 'none';
}
