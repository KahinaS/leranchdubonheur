<?php
class connexionDB {
    private $host    ='localhost';
    private $name    ='formulaire';
    private $user    ='root';
    private $pass   = '';
    private $connexion;

    function __construct($host = null, $name = null, $user = null, $pass = null){
        if($host != null){
            $this->host = $host;
            $this->name = $name;
            $this->user = $user;
            $this->pass = $pass;
        }
        try{
            $this->connexion = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name,
            $this->user, $this->pass); 
        //    , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4', PDO::ATTR_ERRMODE)

        }
        catch (PDOException $e){
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
    }
    public function inscription($pseudo, $mail, $password, $nom, $prenom, $date_naissance, $date_inscription, $ville){
        $date_inscription = date("Y-m-d h:m:s"); $password = crypt($password, '$6$rounds=5000$H4eoaj87enek720ndehbelman82jn83nN310$');
        
       
        $req = $this->connexion->prepare("INSERT INTO utilisateurs (pseudo, mail, password, nom, prenom, date_naissance, date_inscription, ville) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $req->execute(array($pseudo, $mail, $password, $nom, $prenom, $date_naissance, $date_inscription, $ville));
       
    }
    public function isLoginFree($pseudo)
    {
        $req = $this->connexion->prepare("SELECT id
        FROM utilisateurs
        WHERE pseudo = ?");
        $req->execute(array($pseudo));
        $utilisateurs = $req->fetch();

        return !isset($utilisateurs['id']);
    }
    

    public function isMailFree($mail)
    {
        $req = $this->connexion->prepare("SELECT id
        FROM utilisateurs
        WHERE mail = ?");
        $req->execute(array($mail));
        $utilisateurs = $req->fetch();

        return !isset($utilisateurs['id']);
    }
    public function verifMailPw($mail)
    {
        $req = $this->connexion->prepare("SELECT id
        FROM utilisateurs
        WHERE mail = ? AND password = ?");
        $req->execute(array($mail, crypt($password, '$6$rounds=5000$H4eoaj87enek720ndehbelman82jn83nN310$')));
        $utilisateurs = $req->fetch();

        return !isset($utilisateurs['id']);
    }
    public function verifId($pseudo){
        $req = $this->connexion->prepare("SELECT * FROM utilisateurs WHERE id = ?");
        $req->execute(array($pseudo));
        $utilisateurs = $req->fetch();
        $_SESSION['pseudo'] = $utilisateurs['pseudo'];
        return isset($utilisateurs['id']);
    }
public function connexion(){
    return $this->connexion;
}
}
$DB = new connexionDB;
$BDD = $DB->connexion();
?>