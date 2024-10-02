<div class="card-body1">
                  <div class="col-md-12 table-responsive pad_table">
                    <table id="example4" class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>Customer</th>
                          <th>Number</th>
                          <th>Date</th>
                          <th>Due</th>
                          <th>Amount Due</th>
                          <th>Status</th>
                          <th class="sorting_disabled text-right" data-orderable="false">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if (count($allInvoices) > 0)
                        @foreach ($allInvoices as $value)
                    <tr id="invoices-row-all-{{ $value->sale_inv_id }}">
                      <td>{{ $value->customer->sale_cus_first_name }} {{ $value->customer->sale_cus_last_name }}
                      </td>
                      <td>{{ $value->sale_inv_number }}</td>
                      <td>{{ $value->sale_inv_date }}</td>
                      <td>{{ $value->sale_inv_final_amount }}</td>
                      <td>{{ $value->sale_inv_final_amount }}</td>
                      <td>@php
            $nextStatus = '';
            $nextStatusColor = '';
            if ($value->sale_status == 'Draft') {
            $nextStatusColor = '';
            } elseif ($value->sale_status == 'Unsent') {
            $nextStatusColor = '';
            } elseif ($value->sale_status == 'Sent') {
            $nextStatusColor = '';
            } elseif ($value->sale_status == 'Partlal') {
            $nextStatusColor = 'overdue_status';
            } elseif ($value->sale_status == 'Paid') {
            $nextStatusColor = 'Paid_status';
            }
            @endphp
                      <span class="status_btn {{ $nextStatusColor }}">{{ $value->sale_status }}</span>
                      </td>
                      <!-- Actions Dropdown -->
                      <td>
                      <ul class="navbar-nav ml-auto float-sm-right">
                      <li class="nav-item dropdown d-flex align-items-center">
                      @php
            $nextStatus = '';
            if ($value->sale_status == 'Draft') {
            $nextStatus = 'Approve';
            } elseif ($value->sale_status == 'Unsent') {
            $nextStatus = 'Send';
            } elseif ($value->sale_status == 'Sent') {
            $nextStatus = 'Record Payment';
            } elseif ($value->sale_status == 'Partlal') {
            $nextStatus = 'Record Payment';
            } elseif ($value->sale_status == 'Paid') {
            $nextStatus = 'View';
            }
            @endphp

                      @if($nextStatus == 'Record Payment')
              <a href="javascript:void(0);" data-toggle="modal" data-target="#recordpaymentpopup">
              Record Payment
              </a>

            @else
          <a href="javascript:void(0);"
          onclick="updateStatus({{ $value->sale_inv_id }}, '{{ $nextStatus }}')">
          {{ $nextStatus }}
          </a>
        @endif
                      <a class="nav-link user_nav" data-toggle="dropdown" href="#">
                        <span class="action_btn"><i class="fas fa-solid fa-chevron-down"></i></span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('business.invoices.view', $value->sale_inv_id) }}"
                        class="dropdown-item">
                        <i class="fas fa-regular fa-eye mr-2"></i> View
                        </a>
                        @if(isset($access['update_invoices']) && $access['update_invoices'])
              <a href="{{ route('business.invoices.edit', $value->sale_inv_id) }}"
              class="dropdown-item">
              <i class="fas fa-solid fa-pen-to-square mr-2"></i> Edit
              </a>
            @endif
                        <a href="{{ route('business.invoices.duplicate', $value->sale_inv_id) }}"
                        class="dropdown-item">
                        <i class="fas fa-regular fa-copy mr-2"></i> Duplicate
                        </a>
                        <a target="_blank"
                        href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'print' => 'true']) }}"
                        class="dropdown-item">
                        <i class="fas fa-solid fa-print mr-2"></i> Print
                        </a>

                        <a href="javascript:void(0);"
                        onclick="sendInvoice('{{ route('business.invoices.send', [$value->sale_inv_id, $user_id]) }}', {{ $value->sale_inv_id }})"
                        class="dropdown-item">
                        <i class="fas fa-regular fa-paper-plane mr-2"></i> Send
                        </a>
                        <a href="{{ route('business.invoices.sendviews', [$value->sale_inv_id, $user_id, 'download' => 'true']) }}"
                        class="dropdown-item">
                        <i class="fas fa-solid fa-file-pdf mr-2"></i> Export As Pdf
                        </a>
                        @if(isset($access['delete_invoices']) && $access['delete_invoices'])
              <a href="#" class="dropdown-item" data-toggle="modal"
              data-target="#deleteinvoiceall-{{ $value->sale_inv_id }}">
              <i class="fas fa-solid fa-trash mr-2"></i> Delete
              </a>
            @endif
                      </div>
                      </li>
                      </ul>
                      </td>

                    </tr>

                    <div class="modal fade" id="deleteinvoiceall-{{ $value->sale_inv_id }}" tabindex="-1"
                      role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                      <div class="modal-content">
                      <form method="POST"
                      action="{{ route('business.invoices.destroy', ['id' => $value->sale_inv_id]) }}"
                      id="delete-form2-{{ $value->sale_inv_id }}" data-id="{{ $value->sale_inv_id }}">
                      @csrf
                      @method('DELETE')
                      <div class="modal-body pad-1 text-center">
                        <i class="fas fa-solid fa-trash delete_icon"></i>
                        <p class="company_business_name px-10"><b>Delete invoice</b></p>
                        <p class="company_details_text">Are You Sure You Want to Delete This invoice?</p>

                        <!-- <input type="hidden" name="sale_cus_id" id="customer-id"> -->
                        <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
                        <button type="button" class="delete_btn2 px-15"
                        data-id="{{ $value->sale_inv_id }}">Delete</button>
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
                </div>



<script>

  $(function () {


    $('#example4').DataTable({
      paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true

    });

  });

</script>