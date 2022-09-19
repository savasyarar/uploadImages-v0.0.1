<?php
include("../pages/header.php");
$ip = $_SERVER["REMOTE_ADDR"];
?>
  <style>
      #ddArea {
        height: 150px;
        border: 2px dashed #3a5bff;
        border-radius: 1.2em;
        line-height: 150px;
        text-align: center;
        font-size: 1em;
        background: #f3f6ff;
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
        border: 2px solid #3a5bff;
        border-radius: 3px;
        float: left;
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
                <button onclick="history.back()" class="btn btn-danger">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1"></path>
                    </svg>
                    Zurück zum Album
                  </button>
              </div>
              <!-- Page title actions -->
            </div>
          </div>
        </div>
    <div class="page-body">
          <div class="container-xl d-flex flex-column justify-content-center">
          <div class="alert alert-danger" role="alert">
                <h4 class="alert-title">Aufpassen&hellip;</h4>
                <div class="text-muted">Du kannst bis zu 10 Fotos aufeinmal hochladen, bitte beachte das du diese grenze nicht überschreitest.</div>
               </div>
          <div class="col-12">
                <div class="card card-md">
                  <div class="card-stamp card-stamp-lg">
                  </div>
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="loading d-none"><img src="load.gif" alt="" /></div>
                      <div id="ddArea">
                        <form action="anonymUpload.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="datei"><br>
                        <input type="submit" value="Hochladen">
                        </form>
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

<?php
include("../pages/footer.php");
?>