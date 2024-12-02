<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger" id="ModalDeleteLabel">Product Name: <span id="modalProductName"></span></h5>
        </div>
        <form action="" method="POST" id="pauseForm">
            <div class="modal-body text-center">
                <h3>Are you sure you want to delete this product?</h3>
                <i class="text-danger fas fa-exclamation-circle fa-5x"></i>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn bg-gradient-success" id="modalDeleteProd">Yes</button>
                <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">No</button>
            </div>
        </form>
      </div>
    </div>
  </div>
