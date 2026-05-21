<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content modal-content-custom">
      <div class="modal-header modal-header-custom">
        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body modal-body-custom">
        <h1 id="approvalModalLabel">Kelulusan Dokumen</h1>

        <form id="approvalConfirmForm" method="POST" action="#">
          @csrf

          <div class="mb-4 text-center">
            <span class="label-text">No. Inden:</span>
            <p id="approvalOrderNo" class="text-white fs-5 fw-bold mb-0"></p>
          </div>

          <div class="radio-group">
            <label class="radio-option">
              <input type="radio" name="approval" value="sahkan" required>
              <span>Disahkan</span>
            </label>
            <label class="radio-option">
              <input type="radio" name="approval" value="tidak_disahkan">
              <span>Tidak Disahkan</span>
            </label>
          </div>

          <div class="input-section">
            <span class="label-text">Ulasan:</span>
            <textarea name="ulasan" placeholder="Sila masukkan ulasan anda..."></textarea>
          </div>

          <div class="checkbox-section">
            <input type="checkbox" id="approvalConfirmCheck" required>
            <label for="approvalConfirmCheck">
              Saya dengan ini mengesahkan bahawa dokumen ini telah diluluskan secara digital oleh saya pada tarikh dan masa yang tertera.
              <span class="translation">
                I hereby confirm that this document has been digitally approved by me on the date and time indicated.
              </span>
            </label>
          </div>

          <div class="text-center pt-2">
            <button type="button" class="btn-cancel-custom" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn-submit-custom">Hantar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
