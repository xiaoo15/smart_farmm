<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Custom JavaScript for interactive elements -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update cart count dynamically
    function updateCartCount(count) {
        const cartBadge = document.querySelector('.cart-badge');
        if (cartBadge) {
            cartBadge.textContent = count;
            if (count > 0) {
                cartBadge.style.display = 'inline-block';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }
    
    // Example of adding to cart (you would implement this based on your actual functionality)
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
            // Here you would typically make an AJAX call to add to cart
            console.log('Adding product to cart:', productId);
            
            // Simulate adding to cart
            const currentCount = parseInt(document.querySelector('.cart-badge')?.textContent || '0');
            updateCartCount(currentCount + 1);
        });
    });
});
</script>