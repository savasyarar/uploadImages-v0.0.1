<?php
include("../pages/header.php");
$userDetails = $UserRepository->getUserDetails($_SESSION['userid']);

?>


<div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <h2 class="page-title">
                  {RECHNUNG / ANGEBOT ERSTELLEN}
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <button type="submit" name="submit" class="btn btn-primary">
                  ERSTELLEN
                </button>
                <button type="button" class="btn btn-primary" onclick="javascript:window.print();">
                  <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><rect x="7" y="13" width="10" height="8" rx="2"></rect></svg>
                  HERUNTERLADEN
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="card card-lg">
              <div class="card-body">
                <div class="row">
                  <div class="col-6">
                    <p class="h3">{IMG UNTERNEHMENSLOGO}</p>
                    <address>
                      {Unternehmensname}<br>
                      {Straße}<br>
                      {Stadt, PLZ}<br>
                      {E-Mail}
                    </address>
                  </div>
                  <div class="col-6 text-end">
                    <p class="h3">Kunde</p>
                    <address>
                      {Vorname, Nachname}<br>
                      {Straße}<br>
                      {Stadt, PLZ}<br>
                      {E-Mail}
                    </address>
                  </div>
                  <div class="col-12 my-5">
                    <h1>{RECHNUNG / ANGEBOT NR}</h1>
                    <p>{EINLEIITUNGSTEXT}</p>
                  </div>
                </div>
                <table class="table table-transparent table-responsive">
                  <thead>
                    <tr>
                      <th class="text-center" style="width: 1%"></th>
                      <th>Produkt</th>
                      <th class="text-center" style="width: 1%">{MENGE}</th>
                      <th class="text-end" style="width: 1%">{PREIS}</th>
                      <th class="text-end" style="width: 1%">{GESAMT}</th>
                    </tr>
                  </thead>
                  <tbody><tr>
                    <td class="text-center">{POS+}</td>
                    <td>
                      <p class="strong mb-1">{PRODUKTTITLE}</p>
                      <div class="text-muted">{PRODUKTBESCHREIBUNG}</div>
                    </td>
                    <td class="text-center">
                      1
                    </td>
                    <td class="text-end">{EINZELPREIS}</td>
                    <td class="text-end">{EINxMENGE}</td>
                  </tr>
                  <tr>
                    <td colspan="4" class="strong text-end">{Zwischensumme netto}</td>
                    <td class="text-end">$25.000,00</td>
                  </tr>
                  <tr>
                    <td colspan="4" class="strong text-end">MwSt</td>
                    <td class="text-end">{MwSt}</td>
                  </tr>
                  <tr>
                    <td colspan="4" class="font-weight-bold text-end">{Gesamtbetrag}</td>
                    <td class="font-weight-bold text-end">{Gesamtbetrag}</td>
                  </tr>
                </tbody></table>
                <p class="text-muted text-center mt-5">{FUßBEREICH}</p>
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