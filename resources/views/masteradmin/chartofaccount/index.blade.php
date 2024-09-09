@extends('masteradmin.layouts.app')
<title>Profityo | Sales Customers</title>
@if(isset($access['view_customers']) && $access['view_customers']) 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Chart of Accounts</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Chart of Accounts</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <button class="add_btn" data-toggle="modal" data-target="#addaccount"><i class="fas fa-plus add_plus_icon"></i>Add A New Account</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
        <ul class="nav nav-pills p-2 tab_box">
            <li class="nav-item"><a class="nav-link active" id="assets-tab" href="#account-assets" data-toggle="tab">Assets <span class="badge badge-toes">9</span></a></li>
            <li class="nav-item"><a class="nav-link" id="liabilities-tab" href="#account-liabilities-creditcards" data-toggle="tab">Liabilities & Credit Cards <span class="badge badge-toes">10</span></a></li>
            <li class="nav-item"><a class="nav-link" id="income-tab" href="#account-income" data-toggle="tab">Income <span class="badge badge-toes">5</span></a></li>
            <li class="nav-item"><a class="nav-link" id="expenses-tab" href="#account-expenses" data-toggle="tab">Expenses <span class="badge badge-toes">6</span></a></li>
            <li class="nav-item"><a class="nav-link" id="equity-tab" href="#account-equity" data-toggle="tab">Equity <span class="badge badge-toes">2</span></a></li>
          </ul>
        <!-- <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="assets-tab" data-toggle="tab" href="#assets" role="tab">Assets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="liabilities-tab" data-toggle="tab" href="#liabilities" role="tab">Liabilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="income-tab" data-toggle="tab" href="#income" role="tab">Income</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="equity-tab" data-toggle="tab" href="#equity" role="tab">Equity</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="expenses-tab" data-toggle="tab" href="#expenses" role="tab">Expenses</a>
            </li>
        </ul> -->
        </div><!-- /.card-header -->
        <div class="tab-content px-20">
          <div class="tab-pane active" id="account-assets">
            @foreach ($assets as $asset)
            <div class="card">
              <div class="card-header">
              
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$asset->chart_menu_title}}</h3></div>
                </div>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                <div class="table-responsive">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>Account ID</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12"><div class="account-divider"></div></div>
                <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccount"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-liabilities-creditcards">
          @foreach ($liabilitiesAndCreditCards as $lccard)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$lccard->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>7008275225456</td>
                          <td>Cash on Hand<br><span class="last_update_text">Last transaction on 2024-04-04</span></td>
                          <td>Cash you haven't deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.</td>
                          <td class="text-right">
                            <a data-toggle="modal" data-target="#editthisaccount"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccount"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>
              </div>
            </div>
            @endforeach
            </div>
         
          
          <div class="tab-pane" id="account-income">
          @foreach ($income as $incomes)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$incomes->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>7008275225456</td>
                          <td>Cash on Hand<br><span class="last_update_text">Last transaction on 2024-04-04</span></td>
                          <td>Cash you haven't deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.</td>
                          <td class="text-right">
                            <a data-toggle="modal" data-target="#editthisaccount"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                          </td>
                        </tr>
                        <tr>
                          <td>7008275225456</td>
                          <td>Cash on Hand<br><span class="last_update_text">Last transaction on 2024-04-04</span></td>
                          <td>Cash you haven't deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.</td>
                          <td class="text-right">
                            <a data-toggle="modal" data-target="#editthisaccount"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccount"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-expenses">
          @foreach ($expenses as $expense)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$expense->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                  <div class="table-responsive">
                    <table class="table table-hover text-nowrap dashboard_table">
                      <thead>
                        <tr>
                          <th>Account ID</th>
                          <th>Account Name</th>
                          <th>Description</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>7008275225456</td>
                          <td>Cash on Hand<br><span class="last_update_text">Last transaction on 2024-04-04</span></td>
                          <td>Cash you haven't deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.</td>
                          <td class="text-right">
                            <a data-toggle="modal" data-target="#editthisaccount"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-12"><div class="account-divider"></div></div>
                  <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccount"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="tab-pane" id="account-equity">
          @foreach ($equity as $equitys)
            <div class="card">
              <div class="card-header">
                <div class="row justify-content-between align-items-center">
                  <div class="col-auto"><h3 class="card-title">{{$equitys->chart_menu_title}}</h3></div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body2">
                <div class="table-responsive">
                  <table class="table table-hover text-nowrap dashboard_table">
                    <thead>
                      <tr>
                        <th>Account ID</th>
                        <th>Account Name</th>
                        <th>Description</th>
                        <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>7008275225456</td>
                        <td>Cash on Hand<br><span class="last_update_text">Last transaction on 2024-04-04</span></td>
                        <td>Cash you haven't deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash.</td>
                        <td class="text-right">
                          <a data-toggle="modal" data-target="#editthisaccount"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-12"><div class="account-divider"></div></div>
                <div class="col-auto account_pad"><a class="add_new_account_text" data-toggle="modal" data-target="#addanaccount"><i class="fas fa-plus mr-2"></i>Add A New Account</a></div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div

  
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<!-- <div class="modal fade" id="addaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add An Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row pxy-15 px-10">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Account Type <span class="text-danger">*</span></label>
                  <select class="form-control select2" style="width: 100%;">
                    <option>Select one...</option>
                    <option>Cash and Bank</option>
                    <option>Money in Transit</option>
                    <option>Expected Payments from Customers</option>
                    <option>Inventory</option>
                    <option>Property, Plant, Equipment</option>
                    <option>Depreciation and Amortization</option>
                    <option>Vendor Prepayments and Vendor Credits</option>
                    <option>Other Short-Term Asset</option>
                    <option>Other Long-Term Asset</option>
                    <option>Credit Card</option>
                    <option>Loan and Line of Credit</option>
                    <option>Expected Payments to Vendors</option>
                    <option>Due For Payroll</option>
                    <option>Due to You and Other Business Owners</option>
                    <option>Customer Prepayments and Customer Credits</option>
                    <option>Other Short-Term Liability</option>
                    <option>Other Long-Term Liability</option>
                    <option>Income</option>
                    <option>Discount</option>
                    <option>Other Income</option>
                    <option>Operating Expense</option>
                    <option>Cost of Goods Sold</option>
                    <option>Payment Processing Fee</option>
                    <option>Payroll Expense</option>
                    <option>Business Owner Contribution and Drawing</option>
                    <option>Retained Earnings: Profit</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="account_name" placeholder="" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_id">Account ID</label>
                  <input type="text" class="form-control" id="account_id" placeholder="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea id="inputDescription" class="form-control" rows="3" placeholder=""></textarea>
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
  </div> -->
  <div class="modal fade" id="addanaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add An Account</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('chartofaccount.store') }}" method="POST">
        @csrf
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
              <div class="form-group">
                <label>Account Type</label>
                <select id="accountTypeDropdown" name="acc_type_id" class="form-control">
                  <!-- Options will be dynamically populated -->
                </select>
              </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="account_name" name="chart_acc_name" placeholder="" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Currency <span class="text-danger">*</span></label>
                  <select class="form-control from-select select2 @error('currency_id') is-invalid @enderror" name="currency_id" style="width: 100%;">
                      <option value="">Select a Currency</option>
                      @foreach($Country as $cur) 
                          <option value="{{ $cur->id }}">{{ $cur->currency }} ({{ $cur->currency_symbol }}) - {{ $cur->currency_name }}</option>
                      @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_id">Account ID</label>
                  <input type="text" class="form-control" id="account_id" name="chart_account_id" placeholder="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea id="inputDescription" class="form-control" name="sale_acc_desc" rows="3" placeholder=""></textarea>
                </div>
              </div>
            </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
          <button type="submit" class="add_btn">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="editthisaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Account Name</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Type <span class="text-danger">*</span></label>
                  <select class="form-control select2" style="width: 100%;">
                    <option>Select one...</option>
                    <option selected>Cash and Bank</option>
                    <option>Money in Transit</option>
                    <option>Expected Payments from Customers</option>
                    <option>Inventory</option>
                    <option>Property, Plant, Equipment</option>
                    <option>Depreciation and Amortization</option>
                    <option>Vendor Prepayments and Vendor Credits</option>
                    <option>Other Short-Term Asset</option>
                    <option>Other Long-Term Asset</option>
                    <option>Credit Card</option>
                    <option>Loan and Line of Credit</option>
                    <option>Expected Payments to Vendors</option>
                    <option>Due For Payroll</option>
                    <option>Due to You and Other Business Owners</option>
                    <option>Customer Prepayments and Customer Credits</option>
                    <option>Other Short-Term Liability</option>
                    <option>Other Long-Term Liability</option>
                    <option>Income</option>
                    <option>Discount</option>
                    <option>Other Income</option>
                    <option>Operating Expense</option>
                    <option>Cost of Goods Sold</option>
                    <option>Payment Processing Fee</option>
                    <option>Payroll Expense</option>
                    <option>Business Owner Contribution and Drawing</option>
                    <option>Retained Earnings: Profit</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_name">Account Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="account_name" placeholder="Cash on Hand" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Currency <span class="text-danger">*</span></label>
                  <select class="form-control select2" disabled="disabled" style="width: 100%;" required>
                    <option>Select a Currency...</option>
                    <option>CAD ($) - Canadian dollar</option>
                    <option selected>USD ($) - United States dollar</option>
                    <option>AED (AED) - UAE dirham</option>
                    <option>AFN (؋) - Afghani</option>
                    <option>ALL (Lek) - Lek</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account_id">Account ID</label>
                  <input type="text" class="form-control" id="account_id" placeholder="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="inputDescription">Description</label>
                  <textarea id="inputDescription" class="form-control" rows="3" placeholder="Cash you haven’t deposited in the bank. Add your bank and credit card accounts to accurately categorize transactions that aren't cash"></textarea>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="account_name">Archive Account <span class="text-danger">*</span></label>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">
                      <p class="mb-0"><strong>Prevent Further Usage of This Account.</strong></p>
                      <p class="mb-0">You Will Still be Able to Generate Eeports for this Account, and all Previously Categorized Transactions will Remain Unchanged.</p>
                    </label>
                  </div>
                </div>
              </div>
              <div class="account-divider"></div>
              <p class="mb-0 pad-1">No transactions for this account.</p>
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
  <!-- /.content-wrapper -->

 
  <!-- /.control-sidebar -->
  <!-- <div class="modal fade" id="deletesalestaxes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Sales Tax</b></p>
          <p class="company_details_text px-10">Are You Sure You Want to Delete This Sales Tax?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div> -->
<!-- ./wrapper -->
<script>
  const assets = @json($assets);
  const liabilities = @json($liabilitiesAndCreditCards);
  const income = @json($income);
  const equity = @json($equity);
  const expenses = @json($expenses);

  function populateDropdown(data) {
    const dropdown = document.getElementById('accountTypeDropdown');
    dropdown.innerHTML = ''; // Clear existing options
    data.forEach(item => {
      const option = document.createElement('option');
      option.value = item.chart_menu_id; // Assuming this is the value to use
      option.text = item.chart_menu_title; // Assuming this is the name to display
      dropdown.add(option);
    });
  }

  // Event listeners for tab clicks
  document.getElementById('assets-tab').addEventListener('click', () => populateDropdown(assets));
  document.getElementById('liabilities-tab').addEventListener('click', () => populateDropdown(liabilities));
  document.getElementById('income-tab').addEventListener('click', () => populateDropdown(income));
  document.getElementById('equity-tab').addEventListener('click', () => populateDropdown(equity));
  document.getElementById('expenses-tab').addEventListener('click', () => populateDropdown(expenses));

  // Load the default tab on page load
  document.addEventListener('DOMContentLoaded', function() {
    populateDropdown(assets); // Load assets by default
  });
</script>


@endsection
@endif