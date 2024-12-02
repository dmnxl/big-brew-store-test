<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-warning" id="ModalEditLabel">Ingredients Name: <span id="modalIngredientsNames" style="word-break: break-all"></span></h5>
        </div>
        <form action="" method="POST" id="EditGroupForm">
            @method('POST')
            @csrf
            <div class="modal-body">
                <div class="row">
                    <!-- Hidden Field for Ingredient ID -->
                    <div class="col-lg-12 mb-3">
                        <input type="hidden" name="inv_id" class="form-control" id="inv_id" required>
                    </div>

                    <!-- Edit Ingredients Name Field -->
                    <div class="col-lg-12 mb-3">
                        <label class="form-control-label" for="ingredientsName">Edit Ingredients Name <span class="text-danger">*</span></label>
                        <input type="text" name="ingredientsName" class="form-control" placeholder="Input Ingredients name" id="ingredientsName" maxlength="200" required>
                    </div>

                    <!-- Edit Stock Field -->
                    <div class="col-lg-12 mb-3">
                        <label class="form-control-label" for="stock">Edit Stock <span class="text-danger">*</span></label>

                        <div class="input-group">
                            <input type="number" name="stock" class="form-control" placeholder="Input number of stock" id="stock" required min="1">
                            <select name="unit" id="unit" class="form-control" required>
                                <option value="">Select Unit</option>
                                <option value="kg">kg</option>
                                <option value="grams">grams</option>
                                <option value="liters">liters</option>
                                <option value="milliliters">milliliters</option>
                                <option value="pieces">pieces</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn bg-gradient-success" id="ModalEditGrp">Save</button>
                <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
      </div>
    </div>
</div>
