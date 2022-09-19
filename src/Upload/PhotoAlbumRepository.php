<?php
namespace App\Upload;
use PDO;
use Imagick;

class PhotoAlbumRepository {
    
    private $pdo;
    private $id;
    public $pictureAlbumTitle;
    public $pictureAlbumStatus;


    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function createAlbum(int $uid, string $name, string $description, $status){
        $this->pictureAlbumTitle = $name;
        $this->pictureAlbumStatus = $status;
        $this->description = $description;
        $conertToInt = intval($this->pictureAlbumStatus);

        $error = false;

        if(strlen($this->pictureAlbumTitle) == 0){
            $error = true;
            $errorMsg = "Bitte geben Sie ein Titel für Ihren Album ein.";
            return $errorMsg;
        }

        if($conertToInt !== 1 AND $conertToInt !== 2){
            $error = true;
            $errorMsg = "Tue das bitte nicht nocheinmal.";
            return $errorMsg;
        }
        
        if(!$error){
            $stmt = $this->pdo->prepare("INSERT INTO pictureAlbum (userid, pictureAlbumTitle, pictureAlbumStatus, description) VALUES (?,?,?,?)");
            $stmt->execute([$uid, $this->pictureAlbumTitle, $this->pictureAlbumStatus, $this->description]);
            $albumId = $this->pdo->lastInsertId();
            header("Location: /pages/album.php?page={$albumId}&site=1");
        }
    }

    public function checkOwner(int $uid, int $int){
            $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE id = ?");
            $stmt->execute([$int]);
            $result = $stmt->fetch();

            if($result['userid'] !== $uid){
                header("Location: ../pages/dashboard.php");
            }

    }

    public function getAllPhotoAlbum(int $uid): ?array{

        $stmt = $this->pdo->prepare("SELECT count(id) FROM pictureAlbum");
        $stmt->execute([]);
        $maxEntries = (int)$stmt->fetchColumn();

        $page = 1;
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
        }

        $page = max(1, $page);
        $limit = 10;
        $maxPages = (int)ceil($maxEntries / $limit);

        $page = max(1, min($maxPages, $page));
        $offset = ($page-1)*$limit;


        $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ? ORDER BY created_at DESC LIMIT ?, ?");
        $stmt->execute([$uid, $offset, $limit]);
        $result = $stmt->fetchAll();

        if(is_array($result)){
            return $result;
        } else {
            return null;
        }
    }

    public function getMaxPagesPhotoAlbum($uid){
        $stmt = $this->pdo->prepare("SELECT count(id) FROM pictureAlbum WHERE userid = ?");
        $stmt->execute([$uid]);
        $maxEntries = (int)$stmt->fetchColumn();
        $limit = 10;
        $maxPages = (int)ceil($maxEntries / $limit);

        return $maxPages;
    }

    public function getAllAlbumDetails(int $uid, int $int): ?array{
        $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ? AND id = ?");
        $stmt->execute([$uid, $int]);
        $result = $stmt->fetch();


        $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ? AND id = ?");
        $stmt->execute([$uid, $int]);
        $result = $stmt->fetch();

        if(is_array($result)){
            return $result;
        } else {
            return null;
        }

    }


    public function setAlbumDetals(string $title, string $description, $status, int $uid, int $id){

        $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ? AND id = ?");
        $stmt->execute([$uid, $id]);
        $resultDetails = $stmt->fetch();

        if($resultDetails['userid'] == $uid){

            $stmt = $this->pdo->prepare("UPDATE pictureAlbum SET pictureAlbumTitle = ? , description = ? , pictureAlbumStatus = ? WHERE id = ?");
            $result = $stmt->execute([$title, $description, $status, $id]);

            if($result){
                return "Die Bearbeitung war Erfolgreich";
            } else {
                return "Es ist ein Fehler passiert";
            }
        } else {
            return "Es ist was schiefgelaufen! :(";
        }

    }

    public function setImageCompressionQuality($image_path, $quality)
    {
        $imagick = new \Imagick(realpath($image_path));
        $imagick->setImageCompressionQuality($quality);
        header("Content-Type: image/jpeg");
        echo $imagick->getImageBlob();
    }


    public function getPhotoAlbum(int $uid, int $int): ?array{

        $stmt = $this->pdo->prepare("SELECT count(id) FROM pictures WHERE userid = ? AND pictureAlbumId = ?");
        $stmt->execute([$uid, $int]);
        $maxEntries = (int)$stmt->fetchColumn();

        $site = 1;
        if(isset($_GET['site'])){
            $site = (int)$_GET['site'];
        }
        $site = max(1, $site);
        $limit = 9;
        $maxPages = (int)ceil($maxEntries / $limit);

        $site = max(1, min($maxPages, $site));
        $offset = ($site-1)*$limit;


        $stmt = $this->pdo->prepare("SELECT * FROM pictures WHERE userid = ? AND pictureAlbumId	 = ? ORDER BY created_at DESC LIMIT ?, ? ");
        $stmt->execute([$uid, $int, $offset, $limit ]);
        $result = $stmt->fetchAll();

        if(is_array($result)){
            return $result;
        } else {
            return null;
        }
    }


    public function getMaxPagesPhotos(int $uid, int $int){
        $stmt = $this->pdo->prepare("SELECT count(id) FROM pictures WHERE userid = ? AND pictureAlbumId = ?");
        $stmt->execute([$uid, $int]);
        $maxEntries = (int)$stmt->fetchColumn();

        $limit = 9;
        $maxPages = (int)ceil($maxEntries / $limit);

        return $maxPages;
    }

    public function deleteAlbum(int $uid, int $int){
        $error = false;
        $stmt = $this->pdo->prepare("DELETE FROM pictureAlbum WHERE userid = ? AND id = ?");
        $result = $stmt->execute([$uid, $int]);

        $stmt = $this->pdo->prepare("DELETE FROM pictures WHERE pictureAlbumId = ? AND userid = ?");
        $stmt->execute([$int, $uid]);

        if($result){
            header("Location: ../pages/dashboard.php");
        } else {
            $errorMsg = '<div class="alert alert-danger" role="alert">Es ist ein Fehler aufgetreten</div>';
            return $errorMsg;
        }
        
    }

    public function deletePhoto(int $uid, int $int){
        $error = false;
        $stmt = $this->pdo->prepare("DELETE FROM pictures WHERE userid = ? AND id = ?");
        $result = $stmt->execute([$uid, $int]);
        if($result){
            $Msg = "Das Foto wurde erfolgreich gelöscht";
            return $Msg;
        } else {
            $errorMsg = "Es ist ein Fehler aufgetreten";
            return $errorMsg;
        }
        
    }



    public function upload(int $uid, int $int){
            $imageData = '';
            $path = "../images/";

            $stmt = $this->pdo->prepare("SELECT * FROM pictureAlbum WHERE userid = ? AND id = ?");
            $stmt->execute([$uid, $int]);
            $result = $stmt->fetch();

            
            if($result === false){
                $errorMsg = '<div class="alert alert-danger" role="alert">Es ist ein Fehler aufgetreten, bitte kehre zurück auf die Startseite.</div>';
                return $errorMsg;
            }

            if($result['userid'] !== $uid){
                $errorMsg = '<div class="alert alert-danger" role="alert">Es ist ein Fehler aufgetreten, bitte kehre zurück auf die Startseite.</div>';
                return $errorMsg;
            }

            
            if (isset($_FILES['file']['name'][0])) {
    
            foreach ($_FILES['file']['name'] as $keys => $values) {
            $stmt = $this->pdo->prepare("SELECT userid, filesize FROM pictures WHERE userid = ?");
            $stmt->execute([$uid]);
            $result = $stmt->fetchAll();


            if(count($result) !== 0){

                foreach($result as $res){
                    $storage[] = $res['filesize'];
                }


                if(array_sum($storage) > 200000000000){
                    $errorMsg = '<div class="alert alert-danger" role="alert">Du hast leider keinen verfügbaren Speicher mehr.</div>';
                    return $errorMsg;
                }

            }



            $max_size = 5000*1024; //500 KB
            $fileName = pathinfo($_FILES['file']['name'][$keys], PATHINFO_FILENAME);
            $extension = strtolower(pathinfo($_FILES['file']['name'][$keys], PATHINFO_EXTENSION));
            $filesize = $_FILES['file']['size'][$keys];

            //Bildendungen
            $allowed_extensions = array('png', 'jpg', 'jpeg');
            $fileName = uniqid() . '_' . $_FILES['file']['name'][$keys];
            
            
            //Überprüft ob die Datein Bilder sind.
            if(!in_array($extension, $allowed_extensions)){
                die("Bitte lade nur Bilder hoch!");
            }


            if($_FILES['file']['size'][$keys] > $max_size){
                die("Bitte achte auf die Dateigröße");
            }


            if(function_exists('exif_imagetype')){
                $allowed_types = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
                $detected_type = exif_imagetype($_FILES['file']['tmp_name'][$keys]);
                if(!in_array($detected_type, $allowed_types)) {
                die("Nur der Upload von Bilddateien ist gestattet");
                }
            }

            if(exif_imagetype($_FILES['file']['tmp_name'][$keys]) === 3){
                $imageArt = 3; //PNG
            } 

            if(exif_imagetype($_FILES['file']['tmp_name'][$keys]) === 2){
                $imageArt = 2; //JPEG
            }


            if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], '../images/' . $fileName)) {
            

            $stmt = $this->pdo->prepare("INSERT INTO pictures (userid, storage, pictureAlbumId, filesize) VALUES (?,?,?,?)");
            $stmt->execute([$uid, "../images/{$fileName}", $int, $filesize]);


            if($imageArt === 3){
                $img = new Imagick();
                $img->readImage('../images/' . $fileName);
                $img->setImageCompression(Imagick::COMPRESSION_ZIP);
                $img->setImageCompressionQuality(30);
                $img->stripImage();
                $img->writeImage('../images/' . $fileName); 
                $img->clear();
            } 

            if($imageArt === 2){

                $img = new Imagick();
                $img->readImage('../images/' . $fileName);
                $img->setImageCompression(Imagick::COMPRESSION_JPEG);
                $img->setImageCompressionQuality(70);
                $img->stripImage();
                $img->writeImage('../images/' . $fileName); 
                $img->clear();

            }


            $imageData .= '<img src="../images/' . $fileName . '" class="thumbnail" />';
            }
            }
        }
            echo $imageData;
        }





}


?>