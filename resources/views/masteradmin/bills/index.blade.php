@extends('masteradmin.layouts.app')
<title>Profityo | View All Bills</title>
@if(isset($access['view_bills']) && $access['view_bills'] == 1) 
@section('content')
<!-- @include('flatpickr::components.style') -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __('Bills') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __('Bills') }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              @if(isset($access['add_bills']) && $access['add_bills']) 
                <a href="{{ route('business.bill.create') }}"><button class="add_btn"><i
                      class="fas fa-plus add_plus_icon"></i>{{ __('Create A Bill') }}</button></a>
              @endif
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-12 px-20 fillter_box">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
              <p class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</p>
            </div><!-- /.col -->
            <div class="col-auto">
              <p class="m-0 float-right filter-text">Clear Filters<i class="fas fa-regular fa-circle-xmark"></i></p>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-1024 col-md-6 px-10">
              <select class="form-control select2" style="width: 100%;">
                <option default>All Vendors</option>
                <option>Lamar Mitchell</option>
                <option>Britanney Avery</option>
                <option>Sebastian Ware</option>
                <option>Kyla Carrillo</option>
              </select>
            </div>
            <div class="col-lg-4 col-1024 col-md-6 px-10 d-flex">
              <div class="input-group date" id="fromdate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate"/>
                <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div>
              </div>
              <div class="input-group date" id="todate" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate"/>
                <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->

          <div class="card px-20">
            <div class="card-body1">
              <div class="col-md-12 table-responsive pad_table">
                <table id="example4" class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Vendors</th>
                      <th>Number</th>
                      <th>Date</th>
                      <th>Due Date</th>
                      <th>Amount Due</th>
                      <th>Status</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if (count($allBill) > 0)
                  @foreach ($allBill as $value)
                    <tr id="row-bill-{{ $value->sale_bill_id }}">
                      <td>Lamar Mitchell</td>
                      <td>2</td>
                      <td>2024-04-04</td>
                      <td>20 Days Ago</td>
                      <td>$12.50</td>
                      <td><span class="status_btn Paid_status">Paid</span></td>
                      <td>
                        <ul class="navbar-nav ml-auto float-right">
                          <li class="nav-item dropdown d-flex align-items-center">
                            <span class="d-block invoice_underline">View</span>
                            <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                              <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a href="view-bill.html" class="dropdown-item">
                                <i class="fas fa-regular fa-eye mr-2"></i> View
                              </a>
                              <a href="edit-bill.html" class="dropdown-item">
                                <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                              </a>
                              <a href="#" class="dropdown-item">
                                <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                              </a>
                              <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deletebill">
                                <i class="fas fa-solid fa-trash mr-2"></i> Delete
                              </a>
                            </div>
                          </li>
                        </ul>
                      </td>
                    </tr>
                    @endforeach    
                    @else
                        <tr class="odd"><td valign="top" colspan="7" class="dataTables_empty">No records found</td></tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div><!-- /.card-body -->
          </div><!-- /.card-->
          
        <!-- /.row (main row) -->
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
  <div class="modal fade" id="deletebill" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Bill</b></p>
          <p class="company_details_text px-10">Delete Bill 2</p>
          <p class="company_details_text">Are You Sure You Want to Delete This Bill?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="recordpaymentpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Record A Manual Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Payment Date</label>
                  <div class="input-group date" id="estimatedate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder="" data-target="#estimatedate">
                    <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Amount</label>
                  <input type="number" class="form-control" aria-describedby="inputGroupPrepend" placeholder="$12.50"> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Method</label>
                  <select class="form-control form-select">
                    <option>Select a Payment Method...</option>
                    <option>Bank Payment</option>
                    <option>Cash</option>
                    <option>Check</option>
                    <option>Credit Card</option>
                    <option>PayPal</option>
                    <option>Other Payment Method</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <label>Account <span class="text-danger">*</span></label>
                <select class="form-control form-select" required>
                  <option>Select a Payment Account...</option>
                  <option>Cash on Hand (USD)</option>
                  <option>Chisom Latifat (AED)</option>
                  <option>INR for cash (INR)</option>
                  <option>Shareholder Loan (USD)</option>
                  <option>Wave Payroll Clearing (USD)</option>
                </select>
                <p class="mb-0">Any Account Into Which You Deposit And Withdraw Funds From.</p>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="recordpaymentmemonotes">Memo / Notes</label>
                  <textarea id="recordpaymentmemonotes" class="form-control" rows="3" placeholder="Enter your text here"></textarea>
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


@endsection
@endif