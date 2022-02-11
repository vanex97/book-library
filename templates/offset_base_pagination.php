<div class="container">
    <nav aria-label="...">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($offset == 0) echo htmlspecialchars('disabled') ?>">
                <button class="page-link" id="previous-button">Previous</button>
            </li>
            <li class="page-item <?php if ($offset + $limit >= $quantity) echo htmlspecialchars('disabled') ?>">
                <button class="page-link" id="next-button"">Next</button>
            </li>
        </ul>
    </nav>
    <script>
        let offsetValue = <?php echo htmlspecialchars($offset)?>;
        let limit = <?php echo htmlspecialchars($limit)?>;
        let quantity = <?php echo htmlspecialchars($quantity)?>;
    </script>
    <script src="/public/scripts/offset_pagination.js"></script>
</div>