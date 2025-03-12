<div class="container">
    <h3>Seznam novic</h3>
    <div class="article">
        <h4><?php echo $article->title;?></h4>
        <p><b>Povzetek:</b> <?php echo $article->abstract;?></p>
        <p><?php echo $article->text; ?></p>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Komentarji</h5>
            <?php foreach ($comments as $comment): ?>
              <div class="media mb-4">
                <div class="media-body">
                  <h6 class="mt-0"><?php echo $comment->user->username; ?></h6>
                  <p><?php echo $comment->text; ?></p>
                  <p class="text-muted"><?php echo date_format(date_create($comment->date), 'd. m. Y \ob H:i:s'); ?></p>
                </div>
              </div>
              <hr>
            <?php endforeach; ?>
            <?php 
              if($writing_comment == true){ ?>
                <div class="media mb-4">
                  <div class="media-body">
                    <form action="/comments/store?article_id=<?php echo $article->id ?>" method="post">
                      <div class="mb-3">
                        <input type="text" class="form-control" id="text" name="text" value="<?php echo isset($_POST["text"]) ? $_POST["text"]: ""; ?>" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Objavi</button>
                      <label class="text-danger"><?php echo $error; ?></label>
                    </form>
                  </div>
                </div>
              <?php }
            ?>
          </div>
        </div>
        <p>Objavil: <?php echo $article->user->username; ?>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        <?php if($writing_comment == false): ?>
          <a class="btn-default" href="/comments/create?id=<?php echo $article->id;?>"><button>Komentiraj</button></a>
        <?php endif ?>
        <a class="btn-default" href="/"><button>Nazaj</button></a>
    </div>
</div>