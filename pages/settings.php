<?php
include("../pages/header.php");
$userDetails = $UserRepository->getUserDetails($_SESSION['userid']);
if(isset($_POST['submit'])){
    $email = htmlentities($_POST['email']);
    $vorname = htmlentities($_POST['vorname']);
    $nachname = htmlentities($_POST['nachname']);
    $aktuellesPassword = htmlspecialchars($_POST['akPasswort']);
    $newPassword = htmlentities($_POST['newPassword']);

    if(!empty($email)){
       echo $UserRepository->setUserDetails("email", $email, $_SESSION['userid']);
    }

        if(strlen($vorname) === 0){
            $errorMsg = "Du darfst dein Vorname nicht leerlassen.";
        } else {
            $UserRepository->setUserDetails("vorname", $vorname, $_SESSION['userid']);
        }

     if(!empty($nachname)){
        echo $UserRepository->setUserDetails("nachname", $nachname, $_SESSION['userid']);
     }


    if(!empty($aktuellesPassword)){
        echo $UserRepository->changeUserPassword($aktuellesPassword, $newPassword, $_SESSION['userid']);
    }

    if(isset($errorCard)){
        return $errorCard;
    }

    if(isset($errorMsg)){
        echo $errorMsg;
    }



}


?>

<div class="page-wrapper">
        <div class="container-xl">
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="page-header mb-3">
              <div class="row align-items-center mw-100">
                <div class="col">
                  <div class="mb-1">
                    <ol class="breadcrumb" aria-label="breadcrumbs">
                      <li class="breadcrumb-item"><a href="#">Konto</a></li>
                      <li class="breadcrumb-item active" aria-current="page"><a href="#">Kontoeinstellungen</a></li>
                    </ol>
                  </div>
                  <h2 class="page-title">
                    <span class="text-truncate">Kontoeinstellungen</span>
                  </h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-md-4 px-4">
                <div class="list-group list-group-transparent mb-3 ml-3">
                  <a class="list-group-item list-group-item-action d-flex align-items-center active" href="#">
                    Account
                  </a>
                </div>
              </div>
              <div class="col-12 col-md-8">
                <div class="row">
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Account</h3>
                      </div>
                      <div class="card-body">
                        <form action="" method="POST">
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">E-Mail</label>
                            <div class="col">
                              <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="<?php echo $userDetails['email']; ?>">
                              <small class="form-hint">Wir werden Ihre E-Mail niemals an Dritte weitergeben.</small>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col">
                            <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Vorname</label>
                            <div class="col">
                              <input type="text" name="vorname" class="form-control"  value="<?php echo $userDetails['vorname']; ?>" required>
                              <small class="form-hint">
                                Pflichtfeld
                              </small>
                            </div>
                          </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col">
                            <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Nachname</label>
                            <div class="col">
                              <input type="text" name="nachname" class="form-control"  value="<?php echo $userDetails['nachname']; ?>">                              
                              <small class="form-hint">
                                Optional
                              </small>
                            </div>
                          </div>
                            </div>
                          </div>

                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Aktuelles Passwort</label>
                            <div class="col">
                              <input type="password" name="akPasswort" class="form-control" placeholder="Aktuelles Passwort">
                            </div>
                          </div>

                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Neues Passwort</label>
                            <div class="col">
                              <input type="password" name="newPassword" class="form-control" placeholder="Neues Passwort">
                              <small class="form-hint">
                                Bitte beachte das dein Passwort mindestens 6 Zeichen haben muss.
                              </small>
                            </div>
                          </div>

                          <div class="form-footer">
                            <button type="submit" name="submit" class="btn btn-dark">Änderungen speichern</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>




<?php
include("../pages/footer.php");
?>
<div class="modal modal-blur fade" id="modal-small" tabindex="-1" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-title">Bist du dir sicher..?</div>
            <div>Du bist gerade dabei dein gesamtes Album zu löschen.</div>
          </div>
          <div class="modal-footer">
            <form action="../pages/dashboard.php?delete=<?php echo $album['id']; ?>" method="POST">
            <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Abbrechen</button>
            <button type="submit" name="deleteSubmit" class="btn btn-danger" data-bs-dismiss="modal">Ja, lösche alle Fotos darin.</button>
            </form>
          </div>
        </div>
      </div>
    </div>