<?php
include("../pages/header.php");
$userPhotoAlbum = count($PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']));
$getAlbum = $PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']);
if(isset($_GET['page'])){
    $page = $_GET['page'];
}

$albumDetails = $PhotoAlbumRepository->getAllAlbumDetails($_SESSION['userid'], $page);
if(isset($_POST['submit'])){
  $title = htmlentities($_POST['title']);
  $description = htmlentities($_POST['description']);
  $status = htmlentities($_POST['status']);
  $statusInt = intval($status);

  if($statusInt != 1 AND $statusInt != 2){
    die("So nicht Kollege ;)");
  }

  echo $PhotoAlbumRepository->setAlbumDetals($title, $description, $status, $_SESSION['userid'], $page);
  header("Location: ../pages/edit.php?page={$page}");
}

if(isset($_POST['delete'])){
    $PhotoAlbumRepository->deleteAlbum($_SESSION['userid'], $page);
}
?>


<div class="page-wrapper">
    <div class="container-xl">
    <div class="page-body">
    <div class="container-xl d-flex flex-column justify-content-center">
    <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Mein Album</h3>
                </div>
                <div class="card-body">
                  <form action="../pages/edit.php?page=<?php echo $page; ?>&id=1" method="POST">
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Titel</label>
                      <div class="col">
                        <input type="text" name="title" class="form-control" aria-describedby="emailHelp" value="<?php echo $albumDetails['pictureAlbumTitle']; ?>">
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Beschreibung</label>
                      <div class="col">
                      <div class="mb-3">
                              <textarea class="form-control" name="description" rows="6" placeholder="Beschreibung.."><?php echo $albumDetails['description']; ?></textarea>
                            </div>
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Status</label>
                      <div class="col">
                      <div class="form-floating">
                              <select class="form-select" name="status" id="floatingSelect" aria-label="Floating label select example">
                                <?php
                                if($albumDetails['pictureAlbumStatus'] == 1){ 
                                  ?>
                                      <option selected="1" value="1">??ffentlich</option>
                                      <option value="2">Privat</option>
                                      </select>
                                      <label for="floatingSelect">Bitte w??hle eins aus</label>
                                      </div><?php
                                } else {
                                  ?>
                                  <option selected="2" value="2">Privat</option>
                                  <option value="1">??ffentlich</option>
                                  </select>
                                  <label for="floatingSelect">Bitte w??hle eins aus</label>
                                  </div>

                                <?php }  ?>
                      </div>
                    </div>
                    <div class="form-footer">
                      <button type="submit" name="submit" class="btn btn-dark">Speichern</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>

      <div class="container-xl d-flex flex-column justify-content-center">
    <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Album l??schen</h3>
                </div>
                <div class="card-body">M??chtest du dein Album <b><?php echo $albumDetails['pictureAlbumTitle']; ?></b> wirklich l??schen? Bitte beachte dabei das all deine Fotos mitgel??scht werden, diese kannst du sp??ter nicht mehr zur??ckholen...
                  <form action="" method="POST">
                  <div class="form-footer">
                  <button type="submit" name="delete" class="btn btn-danger">L??schen</button>
                  </div>
                  </form>
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
            <div>Du bist gerade dabei dein gesamtes Album zu l??schen.</div>
          </div>
          <div class="modal-footer">
            <form action="../pages/dashboard.php?delete=<?php echo $album['id']; ?>" method="POST">
            <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Abbrechen</button>
            <button type="submit" name="deleteSubmit" class="btn btn-danger" data-bs-dismiss="modal">Ja, l??sche alle Fotos darin.</button>
            </form>
          </div>
        </div>
      </div>
    </div>