<!-- Modal -->
<div class="modal fade" id="ModalInventory" tabindex="-1" role="dialog" aria-labelledby="ModalCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h3 class="modal-title" id="ModalInventoryLabel">Add Add-Ons</h3>
            </div>
            <form action="" method="POST" id="AddIngredientsForm">
                @csrf
                <div class="modal-body text-start">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="basic-url">Add Ons Name <span class="text-danger">*</span></label>
                            <input type="text" name="ingredients-name" class="form-control" placeholder="Input Add Ons Name" required>
                        </div>
                        <div class="col-lg-12">
                            <label for="basic-url">Stocks <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="stock" class="form-control" placeholder="Input number of stock" required min="1">
                                <select name="unit" class="form-control" required>
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
                    <button type="submit" class="btn bg-gradient-success">Save</button>
                    <button type="button" class="btn bg-gradient-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
