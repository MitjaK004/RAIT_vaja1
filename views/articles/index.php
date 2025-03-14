<div class="container">
    <h3>Seznam novic</h3>
    <?php
    foreach ($articles as $article){
        ?>
        <div class="article">
            <h4><?php echo $article->title;?></h4>
            <p><?php echo $article->abstract;?></p>
            <div class="card mb-2">
              <div class="card-body">
                <h5 class="card-title">Komentarji</h5>
                <?php $comments = Comment::get_all_for($article->id); ?>
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
                  if($writing_comment == $article->id){ ?>
                    <div class="media mb-4">
                      <div class="media-body">
                        <form action="/comments/store?article_id=<?php echo $article->id; ?>&index=true" method="post">
                          <div class="mb-3">
                            <input type="text" class="form-control" id="text" name="text" value="<?php echo isset($_POST["text"]) ? $_POST["text"]: ""; ?>" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Objavi</button>
                          <button type="button" class="btn btn-secondary" onclick="window.location.href='/'">Nazaj</button>
                          <label class="text-danger"><?php echo $error; ?></label>
                        </form>
                      </div>
                    </div>
                  <?php }
                ?>
                <?php if($writing_comment == -1 && isset($_SESSION['USER_ID'])): ?>
                    <a class="btn-default" href="/comments/create_on_index?id=<?php echo $article->id; ?>"><button>Komentiraj</button></a>
                <?php endif ?>
              </div>
            </div>
            <a class="mt-2" href="/articles/show?id=<?php echo $article->id;?>"><button>Preberi več</button></a>
            <p>Objavil: <a href="/users/profile?id=<?php echo $article->user->id; ?>"><?php echo $article->user->username; ?></a>, <?php echo date_format(date_create($article->date), 'd. m. Y \ob H:i:s'); ?></p>
        </div>
        <?php
    }
    ?>
</div>