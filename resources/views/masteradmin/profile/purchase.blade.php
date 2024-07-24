<div class="modal fade" id="editcolum" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Customize this Estimate</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="modal_sub_title" style="margin-top: 0;">Edit The Titles Of The Columns Of This Estimate:</div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Items</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="item1" name="r1" checked>
                    <label for="item1">Items (Default)</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="icheck-primary">
                    <input type="radio" id="item2" name="r1">
                    <label for="item2">Products</label>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="icheck-primary">
                    <input type="radio" id="item3" name="r1">
                    <label for="item3">Services</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="item4" name="r1">
                    <label for="item4">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Units</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="quantity1" name="r2" checked>
                    <label for="quantity1">Quantity (Default)</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="quantity2" name="r2">
                    <label for="quantity2">Hours</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="quantity3" name="r2">
                    <label for="quantity3">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Price</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="price1" name="r3" checked>
                    <label for="price1">Price (Default)</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="price2" name="r3">
                    <label for="price2">Rate</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="price3" name="r3">
                    <label for="price3">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Discount</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="discount1" name="r4" checked>
                    <label for="discount1">Discount (Default)</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="discount2" name="r4">
                    <label for="discount2">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Tax</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="tax1" name="r5" checked>
                    <label for="tax1">Tax (Default)</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="tax2" name="r5">
                    <label for="tax2">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="colum_box">
              <h2 class="edit-colum_title">Amount</h2>
              <div class="row align-items-center justify-content-between">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="amount1" name="r6" checked>
                    <label for="amount1">Amount (Default)</label>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="icheck-primary d-flex align-items-center">
                    <input type="radio" id="amount2" name="r6">
                    <label for="amount2">Other</label>
                    <input type="text" class="form-control mar_15" placeholder="">
                  </div>
                </div>
              </div>
            </div>

            <div class="modal_sub_title px-15">Hide columns:</div>

            <div class="colum_box">
              <div class="row align-items-center">
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hideitem" name="r7">
                    <label for="hideitem">Hide Item Name</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hideunit" name="r8">
                    <label for="hideunit">Hide Units</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hideprice" name="r9">
                    <label for="hideprice">Hide Price</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hidediscount" name="r10">
                    <label for="hidediscount">Hide Discount</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hidetax" name="r11">
                    <label for="hidetax">Hide Tax</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hideamount" name="r12">
                    <label for="hideamount">Hide Amount</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="icheck-primary">
                    <input type="radio" id="hidedescription" name="r13">
                    <label for="hidedescription">Hide Item Description</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="row pad-3">
              <div class="col-md-12">
                <div class="icheck-primary">
                  <input type="radio" id="apply1" name="r16">
                  <label for="apply1">Apply These Settings to Future Estimates.</label>
                  <p>These settings will apply to estimates and invoices. You can change these anytime from Invoice Customization settings.</p>
                </div>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
        </div>
      </div>
    </div>
  </div>