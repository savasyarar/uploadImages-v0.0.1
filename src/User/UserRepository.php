<?php
namespace App\User;
use PDO;

class UserRepository {
    private $pdo;
    private $id;
    public $email;
    public $password;
    public $vorname;
    public $nachname;
    public $status;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function createNewUser(string $email, string $vorname,string $password, string $passwordwdh, int $status){

        $this->email = $email;
        $this->password = $password;
        $this->passwordwdh = $passwordwdh;
        $this->status = $status;
        $this->vorname = $vorname;

        $error = false;

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $errorMsg = "Die E-Mail ist ungültig, bitte gib eine gültige E-Mail an!";
        return $errorMsg;
        }
        
        if(strlen($this->password) <= 6){
        $error = true;
        $errorMsg = "Dein Passwort muss eine gültige Länge haben! Min. 6 Zeichen.";
        return $errorMsg;
        }

        if(strlen($this->vorname) == 0){
            $error = true;
            $errorMsg = "Bitte geben Sie Ihren Vornamen ein";
            return $errorMsg;
        }

        if($this->password !== $this->passwordwdh){
            $error = true;
            $errorMsg = "Die Passwörter stimmen nicht überein";
            return $errorMsg;
        }
        
        //Check ob die E-Mail noch existiert
        if(!$error){
            $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->execute([$this->email]);
            $result = $stmt->fetch();
            if($result){
                $error = true;
                $errorMsg = "Die E-Mail existiert bereits.";
                return $errorMsg;
            }
        }

        //Verschlüsselt das Passwort
        if(!$error){
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            
            //Gibt einen Verify Code in der Datenbank, damit User sich verzifiziert.
            $randomVerify = random_int(60000,80000);

            $stmt = $this->pdo->prepare("INSERT INTO users (email, vorname, password, status, verify_code) VALUES (?,?,?,?,?)");
            $result = $stmt->execute([$this->email, $this->vorname, $password_hash, $this->status, $randomVerify]);

            if($result){
                $_SESSION['userid'] = $this->pdo->lastInsertId();

                //Verify E-Mail

                $betreff = "photoly - Verifiziere dich";
                $nachricht = "Herzlich Willkommen bei photoly, <br> um die Seite zu nutzen musst du dich verifizieren. <br>Dein Code lautet: {$randomVerify}";
                $from = "From: info@photoly.de";

                mail($this->email, $betreff, $nachricht, "From: $from <$from>");
                header("Location: ../pages/verify.php");

            } else {
                $errorMsg = "Es ist ein Fehler aufgetreten, bitte versuchen Sie es erneut.";
                return $errorMsg;
            }
        }
    }


    public function getUserDetails(int $uid): ?array{
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$uid]);
        $result = $stmt->fetch();

        if($result['verify'] == 0){
            header("Location: /pages/verify.php");
        }

        if(is_array($result)){
            return $result;
        } else {
            return null;
        }
    }

    public function setUserDetails(string $column, string $newDetail, int $uid){
        $error = false;
        if($column == "email"){
            if(!filter_var($newDetail, FILTER_VALIDATE_EMAIL)){
                $error = true;
                $errorMsg = "Die angegebene E-Mail ist nicht gültig.";
            }

            $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->execute([$newDetail]);
            
            if($result = $stmt->fetch()){
                $error = true;
                $errorMsg = "Die E-Mail existiert bereits schon, bitte verwende eine andere E-Mail.";
            }

        }
        
        if(!$error){
            $stmt = $this->pdo->prepare("UPDATE users SET `$column` = ? WHERE id = ?");
            $result = $stmt->execute([$newDetail, $uid]);

        }

        if(isset($errorMsg)){
            $errorCard = $errorMsg;
            return $errorCard;
        }
    }

    public function changeUserPassword($akPassword, $newPassword, $uid){

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$uid]);
            $result = $stmt->fetch();

            $password_verify = password_verify($akPassword, $result['password']);

            if($password_verify == true){

                if(strlen($newPassword) >= 6){
                    $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
                    $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$newPasswordHashed, $uid]);
                    return "Dein Passwort wurde Erfolgreich geändert!";
                } else {
                    $errorMsg = "Dein Passwort muss mindestens 6 Zeichen haben.";
                    return $errorMsg;
                }

            } else {
                $errorMsg = "Du hast dein aktuelles Passwort falsch eingegeben.";
                return $errorMsg;
            }

    }
    

    public function loginUser(string $email, string $password, $logged){
        $this->email = $email;
        $this->password = $password;
        $this->logged = $logged;

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$this->email]);
        $result = $stmt->fetch();

        if($result !== false && password_verify($this->password, $result['password'])){

            if($logged === "on"){

                $token = bin2hex(random_bytes(16));

                $stmt = $this->pdo->prepare("UPDATE users SET logged = ? WHERE email = ?");
                $stmt->execute([$token, $this->email]);
                setcookie("photoly_login", $token, time() + 3600*24*360);
            }

            $_SESSION['userid'] = $result['id'];
            header("Location: /pages/dashboard.php");

        } else {
            $errorMsg = "Ihre Kontodaten stimmen nicht mit der Datenbank überein.";
            return $errorMsg;
        }
    }

    public function checkUserPassword(string $writePassword, int $uid){
        $this->writePassword = $writePassword;
        $this->uid = $uid;

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$this->uid]);
        $result = $stmt->fetch();

        $password_encrypt = password_verify($this->writePassword, $result['password']);
        
        if($password_encrypt === true){
            $passVerify = true;
            return $passVerify;
        } else {
            $errorMsg = "Dein aktuelles Passwort ist falsch!";
            return $errorMsg;
        }
    }

    public function logoutUser(){
        session_destroy();
        header("Location: /index.php");
    }

    public function userLoginBackend($uid){
        //Wenn der Gast nicht angemeldet ist und versucht ins dashboard zu kommen.
        if($uid == NULL){
            header("Location: /pages/login.php");
        }
    }

    public function userLogged(){
        //Wenn User eingeloggt ist und versucht wieder auf die Registrationsseite zu kommen
        if(isset($_SESSION['userid'])){
            header("Location: /pages/dashboard.php");
        }
    }

    public function userVerifyCode(int $uid, $int){
        $stmt = $this->pdo->prepare("SELECT id, verify_code FROM users WHERE id = ?");
        $stmt->execute([$uid]);
        $result = $stmt->fetch();
        if(($result['verify_code']) == $int){
            $stmt = $this->pdo->prepare("UPDATE users SET verify = ? WHERE id = ?");
            $stmt->execute([1, $uid]);
            header("Location: /pages/dashboard.php");
        } else {
            $errorMsg = "Dein Verzifizierungscode ist falsch!";
            return $errorMsg;
        }
    }

    public function getVendorDetails(string $username){
        $this->username = $username;
        $stmt = $this->pdo->prepare("SELECT * FROM vendor WHERE vendorUsername = ?");
        $stmt->execute([$this->username]);
        $result = $stmt->fetch();

        if(is_array($result)){
            return $result;
        } else {
            return NULL;
        }
    }

    public function getVendorAlbumDetails(string $username, int $gallery): ?array{

        $userid = $this->getVendorDetails($username)['userid'];
        $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ?");
        $stmt->execute([$userid]);
        $result = $stmt->fetch();

        if(is_array($result)){
            return $result;
        } else {
            return null;
        }
    }

    public function getVendorGalleryPicturesById(string $username, int $gallery){

       $userid = $this->getVendorDetails($username)['userid'];
       $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ?");
       $stmt->execute([$userid]);
       $result = $stmt->fetch();
       $status = $result['pictureAlbumStatus'];

       if($status == 1){

        $stmt = $this->pdo->prepare("SELECT * FROM pictures WHERE userid = ? AND pictureAlbumId = ? ORDER BY created_at DESC");
        $stmt->execute([$userid, $gallery]);
        $result = $stmt->fetchAll();
        
        if(is_array($result)){
            return $result;
        } else {
            return NULL;
        }

       } else {
         $errorMsg = "Dieses Album wurde auf Privat gestellt.";
         return $errorMsg;
       }

    }
    

}

?>