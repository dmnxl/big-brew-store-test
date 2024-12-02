<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productName"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="AddOrder">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" id="productId" name="productId">
                                    <input type="hidden" id="editIndex">
                                    <label for="basic-url">Quantity: <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity_medio" class="form-control" placeholder="Input number of order" required min="1">
                                </div>
                                <div class="col-md-12 mt-1">
                                    <label for="basic-url">Size: <span class="text-danger">*</span></label>
                                    <div id="sizes"></div>
                                </div>

                                <div class="col-md-12 mt-1">
                                    <label for="basic-url">Sugar Level: <span class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sugarLevel" id="sugarLever1" value="0%">
                                        <label class="form-check-label" for="sugarLever1">
                                          0%
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sugarLevel" id="sugarLever2" value="25%">
                                        <label class="form-check-label" for="sugarLever2">
                                          25%
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sugarLevel" id="sugarLever3" value="50%">
                                        <label class="form-check-label" for="sugarLever3">
                                          50%
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sugarLevel" id="sugarLever4" value="75%">
                                        <label class="form-check-label" for="sugarLever4">
                                          75%
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sugarLevel" id="sugarLever5" value="100%">
                                        <label class="form-check-label" for="sugarLever5">
                                          100%
                                        </label>
                                      </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="basic-url">Add Ons:</label>
                            @foreach($inventoryItems as $inventory)
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input inventory-checkbox" id="inventory{{ $inventory->id }}" name="inventory_items[]" value="{{ $inventory->id }}">
                                    <label class="form-check-label" for="inventory{{ $inventory->id }}">{{ $inventory->ingredients_name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="addToCartButton">Add to cart</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
