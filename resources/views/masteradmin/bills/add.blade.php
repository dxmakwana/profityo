@extends('masteradmin.layouts.app')
<title>Profityo | Add Bills</title>
@if(isset($access['add_bills']) && $access['add_bills'] == 1) 
@section('content')


 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __('New Bill') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __('New Bill') }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br">cancel</button></a>
              <a href="#"><button class="add_btn">Save</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <!-- card -->   
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">New Bill</h3>
          </div>
          <!-- /.card-header -->
          <form id="items-form" action="{{ route('business.estimates.store') }}" method="POST">
          @csrf
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Vendor <span class="text-danger">*</span></label>
                  <select class="form-control select2" name="sale_vendor_id" id="sale_vendor_id" style="width: 100%;" required>
                    <option>Select a Vendor...</option>
                    @foreach($salevendor as $vendor)
                        <option value="{{ $vendor->purchases_vendor_id }}" {{ $vendor->purchases_vendor_id == old('sale_vendor_id') ? 'selected' : '' }}>
                        {{ $vendor->purchases_vendor_name }}
                        </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Bill Date</label>
                  <div class="input-group date" id="billdate" data-target-input="nearest">
                    <!-- <input type="text" class="form-control datetimepicker-input" placeholder="" data-target="#billdate">
                    <div class="input-group-append" data-target="#billdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div> -->

                    <x-flatpickr id="from-datepicker" class="form-control" name="sale_bill_date" placeholder="Select a date" />
                    <div class="input-group-append">
                        <div class="input-group-text" id="from-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="billnumber">Bill #</label>
                  <input type="number" name="sale_bill_number" id="sale_bill_number" class="form-control" id="billnumber" placeholder="Enter Bill #">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Currency <span class="text-danger">*</span></label>
                  <select class="form-control select2" id="sale_currency_id" name="sale_currency_id"style="width: 100%;" required>
                    <option>Select a Currency...</option>
                    @foreach($currencys as $curr)
                        <option value="{{ $curr->id }}" data-symbol="{{ $curr->currency_symbol }}" {{ $curr->id == old('sale_currency_id', $currency->id) ? 'selected' : '' }}>
                        {{ $curr->currency }} ({{ $curr->currency_symbol }}) - {{ $curr->currency_name }}
                        </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="vendor">Due Date</label>
                  <div class="input-group date" id="duedate" data-target-input="nearest">
                  <x-flatpickr id="to-datepicker" class="form-control" name="sale_bill_valid_date" placeholder="Select a date" />
                    <div class="input-group-append">
                        <div class="input-group-text" id="from-calendar-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                  </div>
                </div>
              </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="sale_bill_customer_ref">P.O./S.O.</label>
                  <input type="text" class="form-control" id="sale_bill_customer_ref" name="sale_bill_customer_ref" placeholder="Enter P.O./S.O.">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="sale_bill_note">Notes</label>
                  <textarea id="sale_bill_note" name="sale_bill_note" class="form-control" rows="3" placeholder=""></textarea>
                </div>
              </div>
            </div>
            <div class="row px-10">
              <div class="col-md-12 text-right">
                <a id="add" class="additem_btn"><i class="fas fa-plus add_plus_icon"></i>Add A Line</a>
              </div>
              <div class="col-md-12 table-responsive ">
                <table class="table table-hover text-nowrap dashboard_table item_table" id="dynamic_field">
                  <thead>
                  <tr>
                    <th style="width: 300px;">Items</th>
                    <th style="width: 300px;">Expense Category</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Tax</th>
                    <th class="text-right">Amount</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr class="item-row" id="item-row-template">
                      <td>
                        <div>
                          <select class="form-control select2" name="items[][sale_product_id]" style="width: 100%;">
                            <option>Select Items</option>
                            @foreach($products as $product)
                                <option value="{{ $product->sale_product_id }}" {{ $product->sale_product_id == old('sale_product_id') ? 'selected' : '' }}>
                                {{ $product->sale_product_name }}
                                </option>
                            @endforeach
                          </select>
                        </div>
                      </td>
                      <td>
                        <div>
                          <select class="form-control select2" style="width: 100%;">
                            <option>Select Category</option>
                            <option>Accounting Fees</option>
                            <option>Bank Service Charges</option>
                            <option>Computer - Hardware</option>
                          </select>
                        </div>
                      </td>
                      <td><input type="number" class="form-control" placeholder="Enter item description"></td>
                      <td><input type="number" class="form-control" placeholder="1"></td>
                      <td>
                        <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend">
                      </td>
                      <td>
                        <select class="form-control select2" style="width: 100%;">
                          <option>Tax1 10%</option>
                          <option>cgst 18%</option>
                          <option>igst 2%</option>
                        </select>
                      </td>
                      <td class="text-right">$0.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
            </div>
            <div class="row justify-content-end">
              <div class="col-md-4 subtotal_box">
                <div class="table-responsive">
                  <table class="table total_table">
                    <tr>
                      <td style="width:50%">Sub Total :</td>
                      <td>$275.00</td>
                    </tr>
                    <tr>
                      <td>Tax1 :</td>
                      <td>$23.75</td>
                    </tr>
                    <tr>
                      <td>Total :</td>
                      <td>$261.25</td>
                    </tr>
                    <tr>
                      <td>Total Paid :</td>
                      <td>$261.25</td>
                    </tr>
                    <tr>
                      <td>Amount Due :</td>
                      <td>$261.25</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="dropdown-divider"></div>
            <div class="col-md-12 text-center py-20">
              <a href="#"><button class="add_btn_br px-10">Cancel</button></a>
              <a href="#"><button class="add_btn px-10">Save</button></a>
            </div>
            <!-- /.row -->
          </div>
          </form>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here --> 
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@endsection
@endif