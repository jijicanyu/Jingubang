<?php foreach($news as $news_item): ?>
    标题: <h3><?php echo $news_item['title']; ?></h3>
    <div class="main">
        内容: <?php echo $news_item['text'];?>
    </div>
    <p><a href="<?php echo site_url('../?/news/'.$news_item['slug']); ?>">View article</a></p>
<?php endforeach;?>