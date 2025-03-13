<div class="container">
    <div class="container">
        <div class="mb-3">
            <label for="username" class="form-label"><?php echo $user->username; ?></label>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><?php echo $user->email; ?></label>
        </div>
        <?php if($self == true): ?>
            <a class="btn-default" href="/users/edit"><button>Uredi profil</button></a>
        <?php endif; ?>
        <a class="btn-default" href="/"><button>Nazaj</button></a>
    </form>
</div>