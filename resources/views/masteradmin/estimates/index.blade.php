@extends('masteradmin.layouts.app')
<title>Profityo | View All Estimates</title>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">{{ __('Estimates') }}</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">{{ __('Estimates') }}</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('business.estimates.create') }}"><button class="add_btn"><i class="fas fa-plus add_plus_icon"></i>{{ __('Create Estimate') }}</button></a>
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
        <div class="col-lg-12 fillter_box">
          <div class="row align-items-center justify-content-between">
            <div class="col-auto">
              <p class="m-0 filter-text"><i class="fas fa-solid fa-filter"></i>Filters</p>
            </div><!-- /.col -->
            <div class="col-auto">
              <p class="m-0 float-sm-right filter-text">Clear Filters<i class="fas fa-regular fa-circle-xmark"></i></p>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-1024 col-md-6 px-10">
              <select class="form-control select2" style="width: 100%;">
                <option default>All customers</option>
                <option>Lamar Mitchell</option>
                <option>Britanney Avery</option>
                <option>Sebastian Ware</option>
                <option>Kyla Carrillo</option>
              </select>
            </div>
            <div class="col-lg-2 col-1024 col-md-6 px-10">
              <select class="form-control form-select" style="width: 100%;">
                <option default>All statuses</option>
                <option>Draft</option>
                <option>Expired</option>
                <option>Converted</option>
                <option>Saved</option>
                <option>Sent</option>
                <option>Viewed</option>
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
            <div class="col-lg-3 col-1024 col-md-6 px-10">
              <div class="input-group">
                <input type="search" class="form-control" placeholder="Enter estimate #">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
          <div class="card-header d-flex p-0 justify-content-center px-20 tab_panal">
            <ul class="nav nav-pills p-2 tab_box">
              <li class="nav-item"><a class="nav-link active" href="#activeestimate" data-toggle="tab">Active <span class="badge badge-toes">20</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#draftestimate" data-toggle="tab">Draft <span class="badge badge-toes">12</span></a></li>
              <li class="nav-item"><a class="nav-link" href="#allestimate" data-toggle="tab">All</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card px-20">
            <div class="card-body1">
              <div class="tab-content">
                <div class="tab-pane active" id="activeestimate">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example1" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <td>Lamar Mitchell</td>
                        <td>2</td>
                        <td>2024-04-04</td>
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn converted_status">Converted</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn converted_status">Converted</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn saved_status">Saved</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn saved_status">Saved</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                        <td>$12.50</td>
                        <td><span class="status_btn">Draft</span></td>
                        <td>
                          <ul class="navbar-nav ml-auto float-sm-right">
                            <li class="nav-item dropdown d-flex align-items-center">
                              <span class="d-block">Approve</span>
                              <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                <a href="view-estimate.html" class="dropdown-item">
                                  <i class="fas fa-regular fa-eye mr-2"></i> View
                                </a>
                                <a href="edit-estimate.html" class="dropdown-item">
                                  <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-print mr-2"></i> Print
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                </a>
                                <a href="#" class="dropdown-item">
                                  <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                </a>
                                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                <!-- /.tab-pane -->
                <div class="tab-pane" id="draftestimate">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example5" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                <!-- /.tab-pane -->
                <div class="tab-pane" id="allestimate">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example4" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Lamar Mitchell</td>
                          <td>2</td>
                          <td>2024-04-04</td>
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn converted_status">Converted</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn converted_status">Converted</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn saved_status">Saved</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn saved_status">Saved</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                          <td>$12.50</td>
                          <td><span class="status_btn">Draft</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                <span class="d-block">Approve</span>
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="view-estimate.html" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  <a href="edit-estimate.html" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimate">
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
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
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
  <div class="modal fade" id="deleteestimate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Estimate</b></p>
          <p class="company_details_text px-10">Delete Estimate #3</p>
          <p class="company_details_text">Are You Sure You Want to Delete This Estimate?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ./wrapper -->

@endsection
