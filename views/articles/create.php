<div class="container mt-5">
        <h3 class="mb-4">Objavi novico</h3>
        <form action="/articles/store" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Naslov novice:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_POST["title"]) ? $_POST["title"]: ""; ?>" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Povzetek novice:</label>
                <textarea class="form-control" id="abstract" name="abstract" rows="5" value="<?php echo isset($_POST["abstract"]) ? $_POST["abstract"]: ""; ?>" required></textarea>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Vsebina novice:</label>
                <textarea class="form-control" id="text" name="text" rows="5" value="<?php echo isset($_POST["text"]) ? $_POST["text"]: ""; ?>" required></textarea>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Datum objave:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo isset($_POST["date"]) ? $_POST["date"]: ""; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Objavi</button>
            <label class="text-danger"><?php echo $error; ?></label>
        </form>
    </div>