<?php include 'main.php';?>

<body data-gr-c-s-loaded="true" class="">

<?php include 'header.php'?>

<?php if ($search != null && $quantity != 0):?>
    <div class="text_search">По <span class="text_found"></span> найдено <?php $quantity?> <span class="number_found"></span></div>
    <script>
        let search_text = '<?php echo htmlspecialchars($search) ?>';
        let search_quantity = <?php echo htmlspecialchars($quantity)?>;
        msgResultSearchText(search_text, search_quantity);
    </script>
<?php elseif ($search != null):?>
    <div class="text_search">По запросу <span class="text_found">"<?php echo htmlspecialchars($search);?>"</span> ничего не найдено :(</div>
<?php endif;?>


<?php include 'booksList.php'?>

<?php include 'footer.php' ?>

<div class="sweet-overlay" tabindex="-1" style="opacity: -0.02; display: none;"></div>
<div class="sweet-alert hideSweetAlert" data-custom-class="" data-has-cancel-button="false" data-has-confirm-button="true" data-allow-outside-click="false" data-has-done-function="false" data-animation="pop" data-timer="null" style="display: none; margin-top: -169px; opacity: -0.03;">
    <div class="sa-icon sa-error" style="display: block;">
            <span class="sa-x-mark">
        <span class="sa-line sa-left"></span>
            <span class="sa-line sa-right"></span>
            </span>
    </div>
    <div class="sa-icon sa-warning" style="display: none;">
        <span class="sa-body"></span>
        <span class="sa-dot"></span>
    </div>
    <div class="sa-icon sa-info" style="display: none;"></div>
    <div class="sa-icon sa-success" style="display: none;">
        <span class="sa-line sa-tip"></span>
        <span class="sa-line sa-long"></span>

        <div class="sa-placeholder"></div>
        <div class="sa-fix"></div>
    </div>
    <div class="sa-icon sa-custom" style="display: none;"></div>
    <h2>Ооопс!</h2>
    <p style="display: block;">Ошибка error</p>
    <fieldset>
        <input type="text" tabindex="3" placeholder="">
        <div class="sa-input-error"></div>
    </fieldset>
    <div class="sa-error-container">
        <div class="icon">!</div>
        <p>Not valid!</p>
    </div>
</div>
</body>

</html>