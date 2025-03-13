<?php

/*
    Model za uporabnika. Vsebuje lastnosti, ki definirajo strukturo uporabnika in sovpadajo s stolpci v bazi.
    Nekatere metode so statične, ker niso vezane na posameznega uporabnika (find, authenticate, ...). Ob klicu teh ne potrebujemo instance objekta: User::find(...)
    Druge so nestatične, ker so vezane na posameznega uporabnika (update, ...). Ob klicu teh potrebujemo instanco objekta: $user->update(...)
*/

class User
{
    public $id;
    public $username;
    public $email;
    public $password;

    // Konstruktor
    public function __construct($id, $username, $email, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    // Metoda, ki vrne uporabnika z določenim ID-jem iz baze
    public static function find($id)
    {
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT * FROM users WHERE id = '$id';";
        $res = $db->query($query);
        if ($user = $res->fetch_object()) {
            return new User($user->id, $user->username, $user->email, $user->password);
        }
        return null;
    }

    public static function getnum_articles($id){
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT COUNT(*) FROM articles WHERE user_id = '$id';";
        $res = $db->query($query);
        if (!$res) {
            die("Povpraševanjr ni uspelo: " . $db->error);
        }
        if ($num_articles = $res->fetch_assoc()){
            return (int)$num_articles['COUNT(*)'];
        }
        return 0;
    }

    public static function getnum_comments($id){
        $db = Db::getInstance();
        $id = mysqli_real_escape_string($db, $id);
        $query = "SELECT COUNT(*) FROM comments WHERE user_id = '$id';";
        $res = $db->query($query);
        if (!$res) {
            die("Povpraševanje ni uspelo: " . $db->error);
        }
        if($num_comments = $res->fetch_assoc()){
            return (int)$num_comments['COUNT(*)'];
        }
        return 0;
    }

    // Metoda, ki preveri ustreznost podanega uporabniškega imena in gesla
    public static function authenticate($username, $password){
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $query = "SELECT * FROM users WHERE username='$username'";
        $res = $db->query($query);
        $user_obj = $res->fetch_object();
        if($user_obj && password_verify($password, $user_obj->password)){
            return $user_obj->id;
        }
            return -1;
    }

    // Metoda, ki vstavi uporabnika v bazo v tabelo users
    public static function create($username, $email, $password){
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $email = mysqli_real_escape_string($db, $email);
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$pass');";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        } 
    }

    // Metoda, ki preveri razpoložljivost uporabniškega imena
    public static function is_available($username){
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $query = "SELECT * FROM users WHERE username='$username'";
        $res = $db->query($query);
        return mysqli_num_rows($res) > 0;
    }

    // Metoda, ki posodobi uporabniko ime in e-mail od trenutnega uporabnika v bazi
    public function update($username, $email){
        $db = Db::getInstance();
        $username = mysqli_real_escape_string($db, $username);
        $email = mysqli_real_escape_string($db, $email);
        $id = $this->id;
        $query = "UPDATE users SET username='$username', email='$email' WHERE id=$id LIMIT 1;";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        } 
    }

    public function change_password($new_pass){
        $db = Db::getInstance();
        $n_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        $id = $this->id;
        $query = "UPDATE users SET password='$n_pass' WHERE id=$id LIMIT 1;";
        if($db->query($query)){
            return true;
        }
        else{
            return false;
        } 
    }
}
