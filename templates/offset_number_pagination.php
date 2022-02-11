<div class="container">
    <nav aria-label="...">
        <ul class="pagination justify-content-center">
            <li class="page-item <?php if ($offset == 0) echo 'disabled' ?>"><a class="page-link" href="/admin"><<</a></li>
            <li class="page-item <?php if ($offset == 0) echo 'disabled' ?>">
                <button class="page-link" id="previous-button"><</button>
            </li>

            <li class="page-item item-next <?php if ($offset + $limit >= $quantity) echo 'disabled'?>">
                <button class="page-link" id="next-button"">></button>
            </li>
            <li class="page-item <?php if ($offset + $limit >= $quantity) echo 'disabled'?>"><a class="page-link" href="?offset=<?php echo htmlspecialchars($quantity - ($quantity % $limit))?>">>></a></li>
        </ul>
    </nav>
    <script>
        let offsetValue = <?php echo htmlspecialchars($offset)?>;
        let limit = <?php echo htmlspecialchars($limit)?>;
        let quantity = <?php echo htmlspecialchars($quantity)?>;
        let buttonsNum = 7;
    </script>
    <script src="/public/scripts/offset_pagination.js"></script>
    <script src="/public/scripts/offset_number_pagination.js"></script>
</div>