// Admin Panel JavaScript enhancements
document.addEventListener('DOMContentLoaded', function () {
    // Add confirmation dialogs for delete actions
    const deleteButtons = document.querySelectorAll('form[action*="destroy"] button[type="submit"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // Add loading states to action buttons
    const actionForms = document.querySelectorAll('form[method="POST"]');
    actionForms.forEach(form => {
        form.addEventListener('submit', function () {
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }
        });
    });

    // Enhance filter functionality
    const filterForm = document.querySelector('.filter-section form');
    if (filterForm) {
        const inputs = filterForm.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', function () {
                // Auto-submit on filter change (optional)
                // filterForm.submit();
            });
        });
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function (e) {
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.focus();
            }
        }
    });

    // Responsive table enhancement
    function enhanceTableResponsiveness() {
        const tables = document.querySelectorAll('.enhanced-table');
        tables.forEach(table => {
            // Add horizontal scroll indicator on mobile
            if (window.innerWidth <= 768) {
                table.parentElement.style.position = 'relative';
                table.parentElement.style.overflowX = 'auto';
            }
        });
    }

    // Call on load and resize
    enhanceTableResponsiveness();
    window.addEventListener('resize', enhanceTableResponsiveness);

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert, .flash-message');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});
