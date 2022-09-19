<?php
include("../pages/header.php");
error_reporting(E_ALL);
$page = $_GET['page'];
$PhotoRepository = new App\Upload\PhotoAlbumRepository($pdo);
$PhotoRepository->checkOwner($_SESSION['userid'], $page);
$prevPage = $_SERVER['HTTP_REFERER'];
?>
  <style>
      #ddArea {
        height: 150px;
        border: 1px dashed #1b2535;
        border-radius: 1.2em;
        line-height: 150px;
        text-align: center;
        font-size: 1em;
        background: #f5f7fb;
        margin-bottom: 15px;
      }

      .drag_over {
        color: #000;
        border-color: #000;
      }

      .thumbnail {
          width: 100px;
          height: 100px;
          padding: 2px;
          margin: 2px;
          border: 1px solid #1b2535;
          border-radius: 10px;
          float: left;
          object-fit: cover;
      }

      .d-none {
        display: none;
      }

      .d-block {
        display: block;
      }

      /* Absolute Center Spinner */
      .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
      }

      /* Transparent Overlay */
      .loading:before {
        content: "";
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
      }
    </style>
  <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <a href="<?php echo $prevPage; ?>" class="btn btn-danger">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1"></path>
                    </svg>
                    Zurück zum Album
                  </a>
              </div>
              <!-- Page title actions -->
            </div>
          </div>
        </div>
    <div class="page-body">
          <div class="container-xl d-flex flex-column justify-content-center">
          <div class="alert alert-danger" role="alert">
                <h4 class="alert-title">Aufpassen&hellip;</h4>
                <div class="text-muted">Du kannst bis zu 10 Fotos aufeinmal hochladen, bitte beachte das du diese grenze nicht überschreitest. Die Bilder werden automatisch sofort hochgeladen.</div>
               </div>
          <div class="col-12">
                <div class="card card-md">
                  <div class="card-stamp card-stamp-lg">
                  </div>
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="loading d-none"><img src="load.gif" alt="" /></div>
                      <div id="ddArea">
                        <b>Klicke hier um Fotos hochzuladen</b>
                      </div>
                      <div id="showThumb"></div>
                      <input type="file" class="d-none" id="selectfile" multiple />
                      </div>
                  </div>
                </div>
              </div>
          </div>
        </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
      $(document).ready(function() {
        $("#ddArea").on("dragover", function() {
          $(this).addClass("drag_over");
          return false;
        });

        $("#ddArea").on("dragleave", function() {
          $(this).removeClass("drag_over");
          return false;
        });

        $("#ddArea").on("click", function(e) {
          file_explorer();
        });

        $("#ddArea").on("drop", function(e) {
          e.preventDefault();
          $(this).removeClass("drag_over");
          var formData = new FormData();
          var files = e.originalEvent.dataTransfer.files;
          for (var i = 0; i < files.length; i++) {
            formData.append("file[]", files[i]);
          }
          uploadFormData(formData);
        });

        function file_explorer() {
          document.getElementById("selectfile").click();
          document.getElementById("selectfile").onchange = function() {
            files = document.getElementById("selectfile").files;
            var formData = new FormData();

            for (var i = 0; i < files.length; i++) {
              formData.append("file[]", files[i]);
            }
            uploadFormData(formData);
          };
        }

        function uploadFormData(form_data) {
          $(".loading")
            .removeClass("d-none")
            .addClass("d-block");
          $.ajax({
            url: "upload.php?page=<?php echo $page; ?>",
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
              $(".loading")
                .removeClass("d-block")
                .addClass("d-none");
              $("#showThumb").append(data);
            }
          });
        }
      });
    </script>
<?php
include("../pages/footer.php");
?>