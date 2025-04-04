<?php
/*
    Controller za uporabnike. Vključuje naslednje standardne akcije:
        create: izpiše obrazec za registracijo
        store: obdela podatke iz obrazca za registracijo in ustvari uporabnika v bazi
        edit: izpiše obrazec za urejanje profila
        update: obdela podatke iz obrazca za urejanje profila in jih shrani v bazo
*/

class users_controller
{
    function create(){
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Gesli se ne ujemata."; break;
                case 3: $error = "Uporabniško ime je že zasedeno."; break;
                default: $error = "Prišlo je do napake med registracijo uporabnika.";
            }
        }
        require_once('views/users/create.php');
    }
    
    function store(){
        //Preveri če so vsi podatki izpolnjeni
        if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"])){
            header("Location: /users/create?error=1"); 
        }
        //Preveri če se gesli ujemata
        else if($_POST["password"] != $_POST["repeat_password"]){
            header("Location: /users/create?error=2"); 
        }
        //Preveri ali uporabniško ime obstaja
        else if(User::is_available($_POST["username"])){
            header("Location: /users/create?error=3"); 
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if(User::create($_POST["username"], $_POST["email"], $_POST["password"])){
            header("Location: /auth/login");
        }
        //Prišlo je do napake pri registraciji
        else{
            header("Location: /users/create?error=4"); 
        }
        die();
    }

    function edit(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                case 2: $error = "Uporabniško ime je že zasedeno."; break;
                default: $error = "Prišlo je do napake med urejanjem uporabnika.";
            }
        }
        require_once('views/users/edit.php');
    }

    function update(){
        if(!isset($_SESSION["USER_ID"])){
            header("Location: /pages/error");
            die();
        }
        $user = User::find($_SESSION["USER_ID"]);
        //Preveri če so vsi podatki izpolnjeni
        if(empty($_POST["username"]) || empty($_POST["email"])){
            header("Location: /users/edit?error=1"); 
        }
        //Preveri ali uporabniško ime obstaja
        else if($user->username != $_POST["username"] && User::is_available($_POST["username"])){
            header("Location: /users/edit?error=2"); 
        }
        //Podatki so pravilno izpolnjeni, registriraj uporabnika
        else if($user->update($_POST["username"], $_POST["email"])){
            header("Location: /");
        }
        //Prišlo je do napake pri registraciji
        else{
            header("Location: /users/edit?error=3"); 
        }
        die();
    }

    function profile(){
        if(!isset($_GET['id'])){
            header("Location: /pages/error");
        }
        else if($_GET['id'] == "self" && isset($_SESSION["USER_ID"])){
            $self = true;
            $user = User::find($_SESSION["USER_ID"]);
        }
        else{
            $self = false;
            $user = User::find($_GET['id']);
            if($user == null){
                header("Location: /pages/error");
            }
            else if(isset($_SESSION['USER_ID']) && $_SESSION['USER_ID'] == $user->id){
                $self = true;
            }
        }

        $num_comments = User::getnum_comments($user->id);
        $num_articles = User::getnum_articles($user->id);

        require_once('views/users/profile.php');
    }

    function change_password(){
        if(!isset($_SESSION['USER_ID'])){
            header("Location: /pages/error");
        }

        $error = "";
        if(isset($_GET['error']) && $_GET['error'] == "trueA"){
            $error = "Prišlo je do napake pri spremembi gesla, prosimo prepričajte se, da sta napisani gesli enaki.";
            $auth = true;
        }
        else if(isset($_GET['error']) && $_GET['error'] == "trueB"){
            $error = "Prišlo je do napake pri prijavi.";
            $auth = false;
        }

        if($error == "" && isset($_SESSION['auth']) && $_SESSION['auth'] == true && isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
            unset($_SESSION['auth']);
            $user = User::find($_SESSION['USER_ID']);
            $user->change_password($_POST['password']);
            header("Location: /users/profile?id=self");
        }
        else if($error == "" && !isset($_SESSION['auth'])){
            $auth = false;
            $user = User::find($_SESSION['USER_ID']);
            if(isset($_POST['password'])){
                if(($user_id = User::authenticate($user->username, $_POST["password"])) >= 0 ){
                    $auth = true;
                    $_SESSION['auth'] = true;
                } else{
                    header("Location: /users/change_password?error=trueB");
                }
            }
        }
        else{
            if($error == ""){
                header("Location: /users/change_password?error=trueA");
            }
        }
        
        require_once('views/users/change_password.php');
    }
}