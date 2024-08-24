@if(isset($access['view_estimates']) && $access['view_estimates']) 
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
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ __('Estimates') }}</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
            <a href="{{ route('business.estimates.create') }}"><button class="add_btn"><i
                  class="fas fa-plus add_plus_icon"></i>{{ __('Create Estimate') }}</button></a>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content px-10">
    <div class="container-fluid">
      @if(Session::has('estimate-add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('estimate-add') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('estimate-add');
      @endphp
      @endif

      @if(Session::has('estimate-delete'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('estimate-delete') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        @php
        Session::forget('estimate-delete');
      @endphp
      @endif

    

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
              <input type="text" class="form-control datetimepicker-input" placeholder="From" data-target="#fromdate" />
              <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
              </div>
            </div>
            <div class="input-group date" id="todate" data-target-input="nearest">
              <input type="text" class="form-control datetimepicker-input" placeholder="To" data-target="#todate" />
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
          <li class="nav-item"><a class="nav-link active" href="#activeestimate" data-toggle="tab">Active <span
                class="badge badge-toes">{{ count($activeEstimates) }}</span></a></li>
          <li class="nav-item"><a class="nav-link" href="#draftestimate" data-toggle="tab">Draft <span
                class="badge badge-toes">{{ count($draftEstimates) }}</span></a></li>
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
                    @if (count($activeEstimates) > 0)
                      @foreach ($activeEstimates as $value)
                        <tr id="estimate-row-approve-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ $value->sale_estim_date }}</td>
                          <td>{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Sent';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Convert to Invoice') {
                                        $nextStatus = 'Cancel';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @if(isset($access['update_estimates']) && $access['update_estimates']) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimateapprove-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                       
                        </tr>
                        
                        <div class="modal fade" id="deleteestimateapprove-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete Customer</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>

                      @endforeach
                    @else
                      <tr>
                        <th colspan="6">No Data found</th>
                      </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

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
                    @if (count($draftEstimates) > 0)
                      @foreach ($draftEstimates as $value)
                        <tr id="estimate-row-draft-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ $value->sale_estim_date }}</td>
                          <td>{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <!-- Actions Dropdown -->
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Sent';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Convert to Invoice') {
                                        $nextStatus = 'Cancel';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @if(isset($access['update_estimates']) && $access['update_estimates']) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}"  class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimatedraft-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>

                        <div class="modal fade" id="deleteestimatedraft-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                              @csrf
                              @method('DELETE')
                          <div class="modal-body pad-1 text-center">
                            <i class="fas fa-solid fa-trash delete_icon"></i>
                            <p class="company_business_name px-10"><b>Delete Customer</b></p>
                            <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                          
                              <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                            <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                            <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>


                      @endforeach
                    @else
                    <tr>
                      <th colspan="6">No Data found</th>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div>
            </div>

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
                    @if (count($allEstimates) > 0)
                      @foreach ($allEstimates as $value)
                        <tr id="estimate-row-{{ $value->sale_estim_id }}">
                          <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}</td>
                          <td>{{ $value->sale_estim_number }}</td>
                          <td>{{ $value->sale_estim_date }}</td>
                          <td>{{ $value->sale_estim_final_amount }}</td>
                          <td><span class="status_btn">{{ $value->sale_status }}</span></td>
                          <td>
                            <ul class="navbar-nav ml-auto float-sm-right">
                              <li class="nav-item dropdown d-flex align-items-center">
                             
                                @php
                                    $nextStatus = '';
                                    if($value->sale_status == 'Draft') {
                                        $nextStatus = 'Approve';
                                    } elseif($value->sale_status == 'Approve') {
                                        $nextStatus = 'Sent';
                                    } elseif($value->sale_status == 'Sent') {
                                        $nextStatus = 'Convert to Invoice';
                                    } elseif($value->sale_status == 'Convert to Invoice') {
                                        $nextStatus = 'Cancel';
                                    }
                                @endphp

                                @if($nextStatus)
                                <a href="javascript:void(0);" onclick="updateStatus({{ $value->sale_estim_id }}, '{{ $nextStatus }}')" >
                                    {{ $nextStatus }}
                                </a>
                                @else
                                    <span class="d-block">Unknown Status</span>
                                @endif
                                <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                                  <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                                </a>
                               
                                <div class="dropdown-menu dropdown-menu-right">
                                  @if(isset($access['view_estimates']) && $access['view_estimates']) 
                                  <a href="{{ route('business.estimates.view', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-eye mr-2"></i> View
                                  </a>
                                  @endif
                                  @if(isset($access['update_estimates']) && $access['update_estimates']) 
                                  <a href="{{ route('business.estimates.edit', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
                                  </a>
                                  @endif
                                  <a href="{{ route('business.estimates.duplicate', $value->sale_estim_id) }}" class="dropdown-item">
                                    <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                                  </a>
                                  <a target="_blank" href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id,'print' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-print mr-2"></i> Print
                                  </a>
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-invoice mr-2"></i> Convert To Invoice
                                  </a>
                                  <a href="javascript:void(0);"  data-id="{{ $value->sale_estim_id }}" onclick="sendEstimate('{{ route('business.estimate.send', [$value->sale_estim_id, $user_id]) }}', {{ $value->sale_estim_id }})"  class="dropdown-item">
                                    <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                                  </a>
                                  <a href="{{ route('business.estimate.sendviews', [ $value->sale_estim_id, $user_id, 'download' => 'true']) }}" class="dropdown-item">
                                    <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                                  </a>
                                  @if(isset($access['delete_estimates']) && $access['delete_estimates']) 
                                  <a href="#" class="dropdown-item" data-toggle="modal" data-target="#deleteestimatall-{{ $value->sale_estim_id }}">
                                    <i class="fas fa-solid fa-trash mr-2"></i> Delete
                                  </a>
                                  @endif
                                </div>
                              </li>
                            </ul>
                          </td>
                        </tr>

                        <div class="modal fade" id="deleteestimatall-{{ $value->sale_estim_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST" action="{{ route('business.estimates.destroy', ['id' => $value->sale_estim_id]) }}" id="delete-form-{{ $value->sale_estim_id }}" data-id="{{ $value->sale_estim_id }}">
                            @csrf
                            @method('DELETE')
                        <div class="modal-body pad-1 text-center">
                          <i class="fas fa-solid fa-trash delete_icon"></i>
                          <p class="company_business_name px-10"><b>Delete Customer</b></p>
                          <p class="company_details_text">Are You Sure You Want to Delete This Customer?</p>
                         
                            <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                          <button type="button" class="delete_btn px-15" data-id="{{ $value->sale_estim_id }}">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>

                      @endforeach
                          @else
                      <tr>
                        <th colspan="6">No Data found</th>
                      </tr>
                    @endif
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

</div>
<!-- ./wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  function updateStatus(estimateId, nextStatus) {
    $.ajax({
      url: "{{ route('business.estimates.statusStore', ':id') }}".replace(':id', estimateId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            sale_status: nextStatus 
        },
        success: function(response) {
            if (response.success) {
                // alert(response.message);
                location.reload(); 
            } else {
                // alert(response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while updating the status.');
        }
    });
}

$(document).on('click', '.delete_btn', function() {
    var estimateId = $(this).data('id'); 
    var form = $('#delete-form-' + estimateId);
    var url = form.attr('action'); 

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(), 
        success: function(response) {
            if (response.success) {
                $('#estimate-row-' + estimateId).remove();

                $('#estimate-row-draft-' + estimateId).remove();

                $('#estimate-row-approve-' + estimateId).remove();

                $('#deleteestimatall-' + estimateId).modal('hide');
                $('#deleteestimatedraft-' + estimateId).modal('hide');
                $('#deleteestimateapprove-' + estimateId).modal('hide');

                // alert(response.message);
            } else {
                alert('An error occurred: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('An error occurred while deleting the record.');
        }
    });
});
</script>
<script>
    function sendEstimate(url, estimateId) {
      // alert(estimateId); 
        if (confirm('Are you sure you want to send this estimate?')) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                   
                    alert('Estimate link sent to the customer successfully.');
                    location.reload(); 
                },
                error: function(xhr) {
                    alert('An error occurred while sending the estimate.');
                }
            });
        }
    }
</script>
@endsection
@endif