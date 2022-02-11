<section id="main" class="main-wrapper">
    <div class="container">
        <div id="content" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php foreach($books as $book):?>
                <div data-book-id="<?php echo htmlspecialchars($book['id'])?>" class="book_item col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <div class="book">
                        <a href="/book/<?php echo htmlspecialchars($book['id']);?>"><img src="<?php echo htmlspecialchars("/$imgFolder/{$book['img']}")?>" alt="<?php echo htmlspecialchars($book['name'])?>">
                            <div data-title="<?php echo htmlspecialchars($book['id'])?>" class="blockI" style="height: 46px;">
                                <div data-book-title="<?php echo htmlspecialchars($book['name'])?>" class="title size_text"><?php echo htmlspecialchars($book['name']);?></div>
                                <div data-book-author="<?php echo htmlspecialchars($book['author_name'])?>" class="author"><?php echo htmlspecialchars($book['author_name'])?></div>
                            </div>
                        </a>
                        <a href="/book/<?php echo htmlspecialchars($book['id'])?>">
                            <button type="button" class="details btn btn-success">Читать</button>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!--    Pagination botton-->
    <?php include 'offset_base_pagination.php' ?>
</section>