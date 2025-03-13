<div class="container">
    <div class="container">
        <div class="mb-3">
            <label for="username" class="form-label"><?php echo $user->username; ?></label>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><?php echo $user->email; ?></label>
        </div>
        <div class="mb-3">
            <label class="form-label">Število novic: <?php echo $num_articles; ?>, </label>
            <label class="form-label">Število komentarjev: <?php echo $num_comments; ?></label>
        </div>
        <?php if($self == true): ?>
            <a class="btn-default" href="/users/edit"><button>Uredi profil</button></a>
            <a class="btn-default" href="/users/change_password"><button>Spremeni geslo</button></a>
        <?php endif; ?>
        <a class="btn-default" href="/"><button>Nazaj</button></a>
    </form>
</div>