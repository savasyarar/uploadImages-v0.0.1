<?php
include("../pages/header.php");
$userPhotoAlbum = count($PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']));
$getAlbum = $PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']);
$countAlbum = count($getAlbum);
$maxPages = $PhotoAlbumRepository->getMaxPagesPhotoAlbum($_SESSION['userid']);
if($userPhotoAlbum == 0){ ?>
  <div class="page-wrapper">
        <div class="container-xl">
        </div>
        <div class="page-body">
          <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
              <div class="empty-img"><img src="./static/illustrations/undraw_sign_in_e6hj.svg" height="128"  alt="">
              </div>
              <p class="empty-title">Du hast leider noch kein Album :/</p>
              <p class="empty-subtitle text-muted">
                Du kannst ganz einfach ein Album erstellen und dort Bilder hochladen, klicke dafür auf den Button.
              </p>
              <div class="empty-action">
                <a href="javascript:void(0)" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modal-report">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                 Erstelle dein erstes Album
                </a>
              </div>
            </div>
          </div>
        </div>
        <?php
        } else { ?>
        <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Meine Alben
                </h2>
              </div>
              <!-- Page title actions -->
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
            <?php foreach($getAlbum as $album){ ////////////////////////////////////////////////////// ALBEN SCHLEIFE
            $date = strtotime($album['created_at']); 
            $dateFormat = date("d.m.Y - h:i", $date);
            ?>
            <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div class="row g-2 align-items-center">
                      <div class="col">
                        <h4 class="card-title m-0">
                        <?php echo $album['pictureAlbumTitle']; ?>
                        </h4>
                        <div class="text-muted">
                        <?php echo $dateFormat; ?>
                        </div>
                        <div class="small mt-1">
                        <?php $status = $album['pictureAlbumStatus']; 
                          if($status == 1){
                              echo '<span class="badge bg-green"></span> Öffentlich';
                          } elseif($status == 2){
                            echo '<span class="badge bg-red"></span> Privat';
                          }
                        ?>
                        </div>
                      </div>
                      <div class="col-auto">
                        <a href="album.php?page=<?php echo $album['id']; ?>&site=1" class="btn">
                          Anzeigen
                        </a>
                      </div>
                      <div class="col-auto">
                        <div class="dropdown">
                          <a href="#" class="btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Download SVG icon from http://tabler-icons.io/i/dots-vertical -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="19" r="1"></circle><circle cx="12" cy="5" r="1"></circle></svg>
                          </a>
                          <div class="dropdown-menu dropdown-menu-end" style="">
                            <a href="../pages/edit.php?page=<?php echo $album['id']; ?>" class="dropdown-item">Bearbeiten</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php }?>
            </div>  
              <br>
            <div class="d-flex">
              <ul class="pagination ms-auto">
                <li class="page-item disabled">
                </li>
                <?php for($pageNumber = 1; $pageNumber <= $maxPages; $pageNumber++):?>
                <li class="page-item"><a class="page-link" href="../pages/dashboard.php?page=<?php echo $pageNumber; ?>"><?php echo $pageNumber; ?></a></li>
                <?php endfor; ?>
                <li class="page-item">
                </li>
              </ul>
            </div>
            </div>
          </div>
        </div>
      <?php
        }
?>

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
