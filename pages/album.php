<?php
include("../pages/header.php");
$page = $_GET['page'];
$site = $_GET['site'];
$checkOwner = $PhotoAlbumRepository->checkOwner($_SESSION['userid'], $page);
$userPhotoAlbum = count($PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']));
$PhotoAlbumRepository = new App\Upload\PhotoAlbumRepository($pdo);
$getOnlyPictures = $PhotoAlbumRepository->getPhotoAlbum($_SESSION['userid'], $page);
$getAlbum = $PhotoAlbumRepository->getAllPhotoAlbum($_SESSION['userid']);
$getAlbumDetails = $PhotoAlbumRepository->getAllAlbumDetails($_SESSION['userid'], $page);
$albumTitle = $getAlbumDetails['pictureAlbumTitle'];
$countAllPhotosByAlbum = count($getOnlyPictures);
$maxPages = $PhotoAlbumRepository->getMaxPagesPhotos($_SESSION['userid'], $page);
$_SERVER['HTTP_REFERER'];
if(isset($_GET['delete'])){
  
  $deletePictureId = $_GET['delete'];
  $PhotoAlbumRepository->deletePhoto($_SESSION['userid'], $deletePictureId);
  header("Location: ../pages/album.php?page={$page}&site={$site}");
  
}




?>

<div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  <?php echo $albumTitle; ?>
                </h2>
                <br>
                <a href="../pages/imageUpload.php?page=<?php echo $page; ?>" class="btn btn-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <line x1="5" y1="12" x2="11" y2="18"></line>
                <line x1="5" y1="12" x2="11" y2="6"></line>
                </svg>
                </a>

                <a href="../pages/imageUpload.php?page=<?php echo $page; ?>" class="btn btn-dark">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-up-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="12" y1="8" x2="8" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="16" y1="12" x2="12" y2="8"></line>
                    </svg>
                    Hochladen
                  </a>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="d-flex">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-cards">
        <?php
        if(isset($_GET['page'])){
        foreach($getOnlyPictures AS $pictures){ 
          $dateFormat = strtotime($pictures['created_at']);
          $date = date("m.d.Y - H:i", $dateFormat);
          ?>
            <div class="col-sm-6 col-lg-4">
                <div class="card card-sm">
                 <a data-fslightbox="gallery" href="<?php echo $pictures['storage']; ?>"><img src="<?php echo $pictures['storage']; ?>" width="250" height="300" class="card-img-top"></a>
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div>
                        <div class="text-muted"><?php echo $date; ?></div>
                        
                      </div>
                      <div class="ms-auto">
                        <a href="../pages/album.php?page=<?php echo $page; ?>&site=<?php echo $site; ?>&delete=<?php echo $pictures['id']; ?>" class="ms-3 text-muted">
                          Löschen
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <?php
        }
    }
    ?>    


            </div>
      <br>
            <div class="d-flex">
              <ul class="pagination ms-auto">
                <li class="page-item disabled">
                </li>
                <?php for($pageNumber = 1; $pageNumber <= $maxPages; $pageNumber++):?>
                <li class="page-item"><a class="page-link" href="../pages/album.php?page=<?php echo $page; ?>&site=<?php echo $pageNumber; ?>"><?php echo $pageNumber; ?></a></li>
                <?php endfor; ?>
                <li class="page-item">
                </li>
              </ul>
            </div>
            </div>
          </div>
         </div>

<?php
include("../pages/footer.php");
?>
