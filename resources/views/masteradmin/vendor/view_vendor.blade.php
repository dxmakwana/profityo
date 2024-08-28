<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profityo | Business Detail</title>
    @include('masteradmin.layouts.headerlink')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('masteradmin.layouts.navigation')
        @include('masteradmin.layouts.sidebar')

     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Vendor Detail</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
              <li class="breadcrumb-item active">Vendor</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
            <a data-toggle="modal" data-target="#delete-vendor-modal-{{ $PurchasVendor->purchases_vendor_id }}"><button class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
              <a href="{{ route('business.purchasvendor.edit',$PurchasVendor->purchases_vendor_id) }}"><button class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
              <a href="{{ route('business.purchasvendor.create') }}"><button class="add_btn">Create Another Vendor</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Vendor Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p class="company_business_name"> {{ $PurchasVendor->purchases_vendor_name }} {{ $PurchasVendor->purchases_vendor_last_name }}</p>
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_email }}</p>
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_phone }}</p>
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_address1 }} </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Additional Information</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_account_number }}</p>
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_zipcode }}</p>
                <p class="company_details_text">-</p>
                <p class="company_details_text">{{ $PurchasVendor->purchases_vendor_website }}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <div class="row justify-content-between align-items-center">
              <div class="col-auto"><h3 class="card-title">Bills</h3></div>
              <div class="col-auto"><a href="new-bill.html"><button class="reminder_btn">Create Bill</button></a></div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                  <input type="search" class="form-control" placeholder="Search by Description">
                  <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                          <i class="fa fa-search"></i>
                      </button>
                  </div>
                </div>
              </div>
              <div class="col-md-3 d-flex">
                <div class="input-group date" id="fromdate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate">
                  <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                  </div>
                </div>
                <div class="input-group date" id="todate" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate">
                  <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="vendordividerline"></div>
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
                  <tr>
                    <td>Lamar Mitchell</td>
                    <td>2</td>
                    <td>2024-04-04</td>
                    <td>20 Days Ago</td>
                    <td>$12.50</td>
                    <td><span class="status_btn Paid_status">Paid</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
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
                  <tr>
                    <td>Lamar Mitchell</td>
                    <td>2</td>
                    <td>2024-04-04</td>
                    <td>20 Days Ago</td>
                    <td>$12.50</td>
                    <td><span class="status_btn">Draft</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
                        <li class="nav-item dropdown d-flex align-items-center">
                          <span class="d-block invoice_underline">Approve</span>
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
                  <tr>
                    <td>Lamar Mitchell</td>
                    <td>2</td>
                    <td>2024-04-04</td>
                    <td>20 Days Ago</td>
                    <td>$12.50</td>
                    <td><span class="status_btn Paid_status">Paid</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
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
                  <tr>
                    <td>Lamar Mitchell</td>
                    <td>2</td>
                    <td>2024-04-04</td>
                    <td>20 Days Ago</td>
                    <td>$12.50</td>
                    <td><span class="status_btn overdue_status">Unpaid</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
                        <li class="nav-item dropdown d-flex align-items-center">
                          <span class="d-block invoice_underline" data-toggle="modal" data-target="#recordpaymentpopup">Record Payment</span>
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
                  <tr>
                    <td>Lamar Mitchell</td>
                    <td>2</td>
                    <td>2024-04-04</td>
                    <td>20 Days Ago</td>
                    <td>$12.50</td>
                    <td><span class="status_btn">Draft</span></td>
                    <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
                        <li class="nav-item dropdown d-flex align-items-center">
                          <span class="d-block invoice_underline">Approve</span>
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
                </tbody>
              </table>
            </div>
          </div>
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
  <div class="modal fade" id="delete-vendor-modal-{{ $PurchasVendor->purchases_vendor_id }}" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <form id="delete-plan-form" action="{{ route('business.purchasvendor.destroy', ['PurchasesVendor' => $PurchasVendor->purchases_vendor_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body pad-1 text-center">
                <i class="fas fa-solid fa-trash delete_icon"></i>
                <p class="company_business_name px-10"><b>Delete vendor & services</b></p>
                <p class="company_details_text px-10">Delete Item 2</p>
                <p class="company_details_text">Are You Sure You Want to Delete This Item?</p>
                <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                @csrf
                @method('DELETE')
                <button type="submit" class="delete_btn px-15">Delete</button>
                </div>
                </form>
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
</div>
<!-- ./wrapper -->


    @include('masteradmin.layouts.footerlink')

</body>

</html>