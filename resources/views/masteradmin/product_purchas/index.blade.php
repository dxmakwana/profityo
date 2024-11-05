@extends('masteradmin.layouts.app')
<title>Profityo | Products & Services (Purchases)</title>
<?php //dd($access); ?>
@if(isset($access['view_product_services_purchases']) && $access['view_product_services_purchases'] == 1) 
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center justify-content-between">
        <div class="col-auto">
          <h1 class="m-0">Products & Services (Purchases)</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Products & Services (Purchases)</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
          @if(isset($access['add_product_services_purchases']) && $access['add_product_services_purchases']) 
            <a href="{{ route('business.purchasproduct.create') }}"><button class="add_btn"><i
                  class="fas fa-plus add_plus_icon"></i>Add A Product Or Service</button></a>
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
      <!-- Main row -->
      @if(Session::has('purchases-product-add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-product-add') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-product-add');
            @endphp
          @endif
          @if(Session::has('purchases-product-delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ Session::get('purchases-product-delete') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
              Session::forget('purchases-product-delete');
            @endphp
          @endif
      <div class="card px-20">
        <div class="card-body1">
          <div class="col-md-12 table-responsive pad_table">
            <table id="example1" class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Tax</th>
                  <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                </tr>
              </thead>
              <tbody>
                @if (count($PurchasProduct) > 0)
                @foreach ($PurchasProduct as $value)
              <tr>
              <td>{{ $value->purchases_product_name }}</td>
              <td>{{ $value->purchases_product_desc }}</td>
              <td>{{ $currencys->firstWhere('id', $value->purchases_product_currency_id)->currency_symbol ?? '' }}{{ $value->purchases_product_price }}</td>
              <td><strong>{{ $value->tax->tax_abbreviation }} ({{ $value->tax->tax_rate }}%)</strong> - {{ $value->tax->tax_name }}</td>
              <!-- <td><span class="overdue_text">$75.00 Overdue</span></td> -->
              <td class="text-right">
              @if(isset($access['update_product_services_purchases']) && $access['update_product_services_purchases']) 
              <!-- <a href=""><i class="fas ffa-solid fa-key view_icon_grid"></i></a> -->
              <a href="{{ route('business.purchasproduct.edit',$value->purchases_product_id) }}"><i class="fas fa-solid fa-pen-to-square edit_icon_grid"></i></a>
              @endif
              <!-- <a data-toggle="modal" data-target="#delete-role-modal"><i
                class="fas fa-solid fa-trash delete_icon_grid"></i></a> -->
                @if(isset($access['delete_product_services_purchases']) && $access['delete_product_services_purchases']) 
                <a data-toggle="modal" data-target="#delete-product-modal-{{ $value->purchases_product_id }}"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                @endif
              </td>
              </tr>

              <div class="modal fade" id="delete-product-modal-{{ $value->purchases_product_id }}" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">
                <form id="delete-plan-form" action="{{ route('business.purchasproduct.destroy', ['PurchasesProduct' => $value->purchases_product_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body pad-1 text-center">
                <i class="fas fa-solid fa-trash delete_icon"></i>
                <p class="company_business_name px-10"><b>Delete Product & services</b></p>
                <p class="company_details_text px-10">Delete Item</p>
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

<!-- ./wrapper -->


@endsection
@endif