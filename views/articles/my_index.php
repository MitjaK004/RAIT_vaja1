<div class="container">
    <h3>Moje novice</h3>
    <?php
    foreach ($articles as $article){
        ?>
        <div class="article">
            <h4><?php echo $article->title;?></h4>
            <p><?php echo $article->abstract;?></p>
            <p>Objavil: <a href="/users/profile?id=<?php echo $article->user->id; ?>"><?php echo $article->user->username; ?></a>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
            <a href="/articles/show?id=<?php echo $article->id;?>"><button>Preberi več</button></a>
            <a href="/articles/delete?id=<?php echo $article->id;?>"><button>Izbriši</button></a>
            <a href="/articles/edit?id=<?php echo $article->id;?>"><button>Uredi</button></a>
        </div>
        <?php
    }
    ?>
</div>