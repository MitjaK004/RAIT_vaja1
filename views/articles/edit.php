<div class="container mt-5">
    <h3 class="mb-4">Objavi novico</h3>
    <form action="/articles/store_modified?id=<?php echo $id; ?>" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Naslov novice:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Povzetek novice:</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="5" value="sdfsdufhsduihfsduhf <?php echo $article->abstract; ?>" required></textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Vsebina novice:</label>
            <textarea class="form-control" id="text" name="text" rows="5" value="<?php echo $article->text; ?>" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Objavi</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
</div>