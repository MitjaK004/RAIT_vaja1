<?php
/*
    Controller za novice. Vključuje naslednje standardne akcije:
        index: izpiše vse novice
        show: izpiše posamezno novico
        
    TODO:
        list: izpiše novice prijavljenega uporabnika
        create: izpiše obrazec za vstavljanje novice
        store: vstavi novico v bazo
        edit: izpiše vmesnik za urejanje novice
        update: posodobi novico v bazi
        delete: izbriše novico iz baze
*/
require_once __DIR__ . '/../models/comments.php';

class articles_controller
{
    public function index()
    {
        //s pomočjo statične metode modela, dobimo seznam vseh novic
        //$ads bo na voljo v pogledu za vse oglase index.php
        $articles = Article::all();
        $writing_comment = -1;

        //pogled bo oblikoval seznam vseh oglasov v html kodo
        require_once('views/articles/index.php');
    }

    public function my_index(){
        $articles = Article::all_for($_SESSION['USER_ID']);

        require_once('views/articles/my_index.php');
    }

    public function show()
    {
        //preverimo, če je uporabnik podal informacijo, o oglasu, ki ga želi pogledati
        if (!isset($_GET['id'])) {
            return call('pages', 'error'); //če ne, kličemo akcijo napaka na kontrolerju stran
            //retun smo nastavil za to, da se izvajanje kode v tej akciji ne nadaljuje
        }
        //drugače najdemo oglas in ga prikažemo
        $article = Article::find($_GET['id']);
        $comments = Comment::get_all_for($_GET['id']);
        $writing_comment = false;
        require_once('views/articles/show.php');
    }

    public function create(){
        $error = "";
        if(isset($_GET["error"])){
            switch($_GET["error"]){
                case 1: $error = "Izpolnite vse podatke"; break;
                default: $error = "Prišlo je do napake med registracijo uporabnika.";
            }
        }
        require_once('views/articles/create.php');
    }

    public function store(){
        if(!isset($_POST["title"]) || !isset($_POST["abstract"]) || !isset($_POST["text"]) || !isset($_SESSION["USER_ID"])){
            header("Location: /articles/create?error=1");
        }
        else{
            $now = new DateTime();
            $article = Article::create($_POST["title"], $_POST["abstract"], $_POST["text"], $now->format('Y-m-d H:i:s'), $_SESSION["USER_ID"]);
        }
        header("Location: /");
    }

    public function store_modified(){
        if(!isset($_GET["id"]) || !isset($_POST["title"]) || !isset($_POST["abstract"]) || !isset($_POST["text"]) || !isset($_SESSION["USER_ID"])){
            header("Location: /articles/create?error=1");
        }
        else{
            $now = new DateTime();
            Article::delete($_GET["id"]);
            $article = Article::create($_POST["title"], $_POST["abstract"], $_POST["text"], $now->format('Y-m-d H:i:s'), $_SESSION["USER_ID"]);
        }
        header("Location: /articles/my_index");
    }

    public function edit(){
        if(!isset($_GET["id"])){
            header("Location: /articles/create?error=1");
        }
        $error = "";
        $id = $_GET['id'];
        $article = Article::find($id);
        $title = $article->title;
        require_once('views/articles/edit.php');
    }

    public function delete(){
        Article::delete($_GET["id"]);

        header("Location: /articles/my_index");
    }
}