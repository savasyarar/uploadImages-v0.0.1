
<?php
include("../pages/header.php");
$userDetails = $UserRepository->getUserDetails($_SESSION['userid']);
if(isset($_GET['page'])){
    $page = $_GET['page'];
}

if($page == "invoice"){
    $pageTitle = "Rechnung erstellen";
} elseif($page == "offer"){
    $pageTitle = "Angebot erstellen";
}
?>

<div class="page-wrapper">
    <div class="container-xl">
                      <!-- Page title -->
                <div class="page-header d-print-none">
                    <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                        <?php echo $pageTitle;?>
                        </h2>
                    </div>
                    </div>
                </div>
                </div>


                <div class="page-body">
                    <div class="container-xl">
                        <div class="row row-cards">
                                <div class="row">
                                    <div class="col">
                                            <div class="mb-3">
                                            <label class="form-label">Kundenname</label>
                                            <input type="text" class="form-control" name="example-text-input" name="kundenname" placeholder="Kundenname">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Straße</label>
                                            <input type="text" class="form-control" name="example-text-input" name="strasse" placeholder="Straße">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">PLZ</label>
                                            <input type="text" class="form-control" name="example-text-input" name="plz" placeholder="PLZ">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Ort</label>
                                            <input type="text" class="form-control" name="example-text-input" name="ort" placeholder="Ort">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Datum</label>
                                            <select class="form-select">
                                                <option value="deutschland">Deutschland</option>
                                            </select>
                                            </div>
                                    </div>
                                    <div class="col">

                                    <div class="mb-3">
                                        <label class="form-label">Rechnungsnummer</label>
                                        <input type="text" class="form-control" name="example-disabled-input" placeholder="Disabled..." value="Well, she turned me into a newt." disabled="">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kundennummer</label>
                                        <input type="text" class="form-control" name="example-disabled-input" placeholder="Disabled..." value="Well, she turned me into a newt." disabled="">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Datum</label>
                                        <input class="form-control mb-2" placeholder="Select a date" id="datepicker-default" value="2020-06-20">
                                    </div>


                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="container-xl">
                        <div class="row row-cards">
                                            <div class="mb-3">
                                            <label class="form-label">Belegtitel</label>
                                            <input type="text" class="form-control" name="example-text-input" name="kundenname" placeholder="Kundenname">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Einleitungstext</label>
                                            <input type="text" class="form-control" name="example-text-input" name="kundenname" placeholder="Kundenname">
                                            </div>
                    </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="container-xl">
                        <div class="row row-cards">
                        <div class="col-12">
                <div class="card">
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table" id="lineitems">
                      <thead>
                        <tr>
                          <th>Pos.</th>
                          <th>Produkt / Service</th>
                          <th>Menge</th>
                          <th>Einheit</th>
                          <th>Preis (€)</th>
                          <th>Gesamt</th>
                          <th class="w-1"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="75"><input type="text" class="form-control" id="position" name="position[]" value="1"></td>
                          <td class="text-muted">
                          <input type="text" class="form-control" id="service" name="service[]" placeholder="Produkt oder Service eingeben">
                          <br><textarea class="form-control" name="description[]" rows="1" placeholder="Beschreibung"></textarea>
                          <td class="text-muted" width="75"><input type="text" id="menge"  class="form-control" name="menge[]" value="1"></td>
                          <td class="text-muted" width="100">
                          <input type="text"  class="form-control" id="einheit" name="einheit[]" placeholder="Einheit">
                          </td>
                          <td class="text-muted" width="100">
                          <input type="text" class="form-control" id="preis" name="preis[]" placeholder="0,00">
                          </td>
                          <td class="text-muted" id="gesamt">
                            0
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <br>
                <button type="button" onclick="addRow(1)" class="btn btn-secondary">
                          Secondary
                </button>
              </div>
                    </div>
                    </div>
                </div>


                <div class="page-body">
                    <div class="container-xl">
                        <div class="row row-cards">
                                            <div class="mb-3">
                                            <label class="form-label">Zahlungsbedingungen</label>
                                            <input type="text" class="form-control" name="example-text-input" value="Zahlungsziel in 5 Tagen ohne Abzug.">
                                            </div>

                                            <div class="mb-3">
                                            <label class="form-label">Nachbemerkung</label>
                                            <input type="text" class="form-control" name="example-text-input" value="Vielen Dank für die gute Zusammenarbeit.">
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
<script>
    function addRow(add){
        var table = document.getElementById("lineitems");
        var row = table.insertRow();
        var gesamt = 0.00;
        var cell = row.insertCell();


        cell.innerHTML = '<input type="text" class="form-control" id="position[]"  name="position[]" value="1">';
        cell = row.insertCell();
        cell.innerHTML = '<input type="text" class="form-control" id="service"  name="service[]" placeholder="Produkt oder Service eingeben"><br><textarea class="form-control" name="description[]" rows="1" placeholder="Beschreibung"></textarea>';
        cell = row.insertCell();
        cell.innerHTML = '<input type="text" id="menge"  class="form-control"  name="menge[]" value="1">';
        cell = row.insertCell();
        cell.innerHTML = '<input type="text" class="form-control" id="position"  name="einheit[]" placeholder="Einheit">';;
        cell = row.insertCell();
        cell.innerHTML = '<input type="text" class="form-control" id="preis" name="example-text-input" name="preis[]" placeholder="0,00">';
        cell = row.insertCell();
        cell.innerHTML = gesamt;   
    }
</script>

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