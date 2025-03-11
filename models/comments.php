<?php

require_once 'users.php';
require_once 'articles.php';

class Comment{
    public $id;
    public $user_id;
    public $article_id;
    public $text;
    public $date;
    public $user;
    
    public function __construct($id, $user_id, $article_id, $text, $date){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->text = $text;
        $this->date = $date;
        $this->user = User::find($user_id);
    }

    public static function create($user_id, $article_id, $text, $date){
        $db = Db::getInstance();
        $text = mysqli_real_escape_string($db, $text);
        $date = mysqli_real_escape_string($db, $date);
        $query = "INSERT INTO comments (user_id, article_id, text, date) VALUES ('$user_id', '$article_id', '$text', '$date');";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        } 
    }

    public static function get_all_for($article_id){
        $db = Db::getInstance();
        $query = "SELECT * FROM comments WHERE article_id = '$article_id';";
        $res = $db->query($query);
        $comments = array();
        while ($comment = $res->fetch_object()) {
            array_push($comments, new Comment($comment->id, $comment->user_id, $comment->article_id, $comment->text, $comment->date));
        }
        return $comments;
    }
}