@extends('masteradmin.layouts.app')
<title>Profityo | Vendors & Services (Purchases)</title>
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Vendors</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Vendors</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="#"><button class="add_btn_br"><i class="fas fa-download add_plus_icon"></i>Import From Google Contact</button></a>
              <a href="#"><button class="add_btn_br"><i class="fas fa-download add_plus_icon"></i>Import From CSV</button></a>
              <a href="{{ route('business.purchasvendor.create') }}"><button class="add_btn"><i
                  class="fas fa-plus add_plus_icon"></i>Add A Vendor</button></a>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <section class="content px-10">
    <div class="container-fluid">
      <!-- Main row -->
      @if(Session::has('purchases-vendor-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-vendor-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-vendor-add');
            @endphp
          @endif
          @if(Session::has('purchases-vendor-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-vendor-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-vendor-delete');
            @endphp
          @endif
      <div class="card px-20">
        <div class="card-body1">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example1" class="table table-hover text-nowrap">
              <thead>
                 <tr>
                      <th>Type</th>
                      <th>Vendor Name</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Direct Deposit</th>
                      <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                    </tr>
              </thead>
              <tbody>
                @if (count($PurchasVendor) > 0)
                @foreach ($PurchasVendor as $value)
              <tr>
              <td>{{ $value->purchases_vendor_type }}</td>
              <td>{{ $value->purchases_vendor_name }}</td>
              <td>{{ $value->purchases_vendor_email }}</td>
              <td>{{ $value->purchases_vendor_email }}</td>
              <td><a href="new-bill.html" class="invoice_underline" data-toggle="modal" data-target="#add_bank_account">Add Bank Details</a></td>
              <!-- <td><span class="overdue_text">$75.00 Overdue</span></td> -->
              <td class="text-right">
              <!-- <a href=""><i class="fas ffa-solid fa-key view_icon_grid"></i></a> -->
              <a href="{{ route('business.purchasvendor.edit',$value->purchases_vendor_id) }}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
              <!-- <a data-toggle="modal" data-target="#delete-role-modal"><i
                class="fas fa-solid fa-trash delete_icon_grid"></i></a> -->
                <a data-toggle="modal" data-target="#delete-vendor-modal-{{ $value->purchases_vendor_id }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
              </td>
              </tr>

              <div class="modal fade" id="delete-vendor-modal-{{ $value->purchases_vendor_id }}" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <form id="delete-plan-form" action="{{ route('business.purchasvendor.destroy', ['PurchasesVendor' => $value->purchases_vendor_id]) }}" method="POST">
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
              @endforeach            
                @else
                  <tr class="odd">
                    <td valign="top" colspan="7" class="dataTables_empty">No records found</td>
                  </tr>
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
<div class="modal fade" id="add_bank_account" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Babk Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <h5 class="pad-3">oddevenInfotech2</h5>
            <div class="row pxy-15 px-10">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="routingnumber">Routing Number <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="routingnumber" aria-describedby="inputGroupPrepend" placeholder="" required> 
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="accountnumber">Account Number <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="routingnumber" aria-describedby="inputGroupPrepend" placeholder="" required> 
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="accounttype">Bank Account Type <span class="text-danger">*</span></label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio1" checked="">
                    <label class="form-check-label">Checking</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio1">
                    <label class="form-check-label">Savings</label>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="vendors-list.html"><button type="button" class="add_btn_br">Back To Vendors List</button></a>
          <button type="submit" class="add_btn">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- ./wrapper -->


@endsection