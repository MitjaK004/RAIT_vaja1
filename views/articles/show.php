<div class="container">
    <h3>Seznam novic</h3>
    <div class="article">
        <h4><?php echo $article->title;?></h4>
        <p><b>Povzetek:</b> <?php echo $article->abstract;?></p>
        <p><?php echo $article->text; ?></p>
        <p>Objavil: <?php echo $article->user->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        <div class="container">
        <?php
            foreach ($comments as $comment){
                ?>
                <div class="container">
                    <p>Objavil: <?php echo $comment->user->username; ?>, <?php echo date_format(date_create($comment->date), 'd. m. Y \ob H:i:s'); ?></p>
                    <p><?php echo $comment->text;?></p>
                </div>
                <?php
            }
        ?>
        </div>
        <a href="/"><button>Nazaj</button></a>
    </div>
</div>