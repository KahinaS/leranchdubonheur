<?php
session_start();
$_SESSION = array();
include_once("../db/connexiondb.php");
include_once("Constante.php");
if(!empty($_POST)){
    extract($_POST);
     $valid = (boolean) true;
     if(isset($_POST['inscription'])){
         $pseudo = (String) trim($pseudo);
         $mail = (String) trim($mail);
         $nom = (String) trim($nom);
         $prenom = (String) trim($prenom);
         $password = (String) trim($password);
         $jour = (int) $jour;
         $mois = (int) $mois;
         $annee = (int) $_POST['annee'];
         $date_naissance = (String) null;
         $ville = (int) $ville;
    
         if(empty($pseudo)){
             $valid = false;
             $err_pseudo = "Veuillez renseigner ce champs !";
         }else{
             if(!$DB->isLoginFree($pseudo)){
                 $valid = false;
                $_SESSION["err_pseudo"] = Constant::$usernameTaken;
             }     
         }
         
         if(empty($mail)){
            $valid = false;
            $err_mail = "Veuillez renseigner ce champs !";
        }else{
            if(!$DB->isLoginFree($mail)){
                $valid = false;
               $_SESSION["err_mail"] = Constant::$emailTaken;
            }      
            
        }
        function passwordValid($password){
            if(preg_match(" ([A-Za-z0-9]) ", $password)) {
                return true;
                
             }else{
                 return false;
             }
        }
        if (!passwordValid($password)){
            $valid = false;
            $_SESSION['err_password'] = Constant::$passwordsNotAlphanumerique;
         }
         
        
          function isValidEmail($mail)
          {
             if(preg_match(" /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ", $mail)) {
                 return true;
             } else {
                 return false;
             }
         }
         if (!isValidEmail($mail)){
            $valid = false;
            $_SESSION['err_mail'] = Constant::$emailInvalid;
         }
        
       
        if(empty($nom)){
            $valid = false;
            $err_nom = Constant::$invalid;
        }
        
        if(empty($prenom)){
            $valid = false;
            $err_prenom = "Veuillez renseigner ce champs !";
        }
        
        if(empty($password)){
            $valid = false;
            $err_password = "Veuillez renseigner ce champs !";
        }
       
        if($jour < 1 || $jour > 31) {
            $valid = false;
            $err_jour = "Veuillez renseigner ce champs !";
        }
      
        if($mois < 1 || $mois > 12) {
            $valid = false;
            $err_mois = "Veuillez renseigner ce champs !";
        }
      
        if($annee < 1930 || $annee > 2002) {
            $valid = false;
            $err_annee = "Veuillez renseigner ce champs !";
        }
      
        $verif_ville = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17);
       
        
        if(!in_array($ville, $verif_ville)){
            $valid = false;
            $err_ville = "Veuillez renseigner ce champs !";
        
         }
         else{
             $ville_array = array("Montpellier", "Béziers", "Sète", "Agde", "Lunel", "Frontignan", "Castelnau-le-Lez", "Mauguio", "Lattes", "Mèze", "Juvignac", "Le Crès", "Grabels", "Pérols", "Lavérune", "Saint-Jean-de-Védas", "Jacou");
             $tmp = $ville_array[$ville -1];
            
             $ville = $tmp;
         }
       
        if(false){
            //?correction !checkdate
            $valid = false;
            $err_date = "Veuillez renseigner une date correct !";
        }
        else{
            $date_naissance = $annee . '-' . $mois . '-' . $jour;
        }
       
        if($valid){
            $DB->inscription($pseudo, $mail, $password, $nom, $prenom, $date_naissance, $date_inscription, $ville);
            
            header("Location: ../index.php");
            exit;  
        }else{
            $_SESSION["pseudo"] = $pseudo;
            $_SESSION["nom"] = $nom;
            $_SESSION["prenom"] = $prenom;
            $_SESSION["mail"] = $mail;
            $_SESSION["password"] = $password;
            header("Location: ../view/inscription.php");
         }
     }
     
     
}

 ?>