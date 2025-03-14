<?php
require_once 'articles_controller.php';
require_once __DIR__ . '/../models/comments.php';

class comments_controller
{
    public function create(){
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
        $article = Article::find($_GET['id']);
        $comments = Comment::get_all_for($_GET['id']);
        $writing_comment = true;
        $error = "";

        require_once('views/articles/show.php');
    }

    public function create_on_index(){
        if (!isset($_GET['id'])) {
            return call('pages', 'error');
        }
        $articles = Article::all();
        $writing_comment = $_GET['id'];
        $error = "";

        require_once('views/articles/index.php');
    }

    public function store(){
        if(!isset($_GET["article_id"]) || !isset($_POST["text"]) || !isset($_SESSION["USER_ID"])){
            header("Location: /articles/create?error=1");
        }
        else{ 
            $now = new DateTime();
            $comment = Comment::create($_SESSION["USER_ID"], $_GET["article_id"], $_POST["text"], $now->format('Y-m-d H:i:s'));
        }
        $article_id = intval($_GET["article_id"]);
        if(isset($_GET['index'])){
            header("Location: /articles/index");
            exit;
        }
        else{
            header("Location: /articles/show?id=$article_id");
            exit;
        }
    }
}