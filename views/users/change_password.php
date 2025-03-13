<div class="container">
    <h3 class="mb-3">Spremeni geslo</h3>
    <?php if(!isset($auth) || $auth != true): ?>
    <form action="/users/change_password" method="POST">
        <div class="mb-3">
            <label for="password" class="form-label">Trenutno Geslo</label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Prijava</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
    <?php endif; ?>
    <?php if($auth == true): ?>
        <form action="/users/change_password" method="POST">
        <div class="mb-3">
            <label for="password" class="form-label">Novo Geslo</label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">Ponovite Novo Geslo</label>
            <input type="password" class="form-control" id="password2" name="password2" value="">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Spremeni geslo</button>
        <label class="text-danger"><?php echo $error; ?></label>
    </form>
    <?php endif; ?>
</div>