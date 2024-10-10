
                      @foreach($sentLogs as $log)
              <a class="d-block w-100" data-toggle="collapse" href="#collapseOne-{{ $loop->index }}">
              <div class="card-header accordion-button">
                <div class="row align-items-center">
                <div class="col-auto">
                  <p class="mb-0">{{ $log->created_at->format('M d') }}</p>
                </div>
                <div class="col-auto align-items-center d-flex">
                  <img src="{{url('public/dist/img/send.svg')}}" class="send_icon">
                  <p class="invoiceid_text mar_15 mb-0">{{ $log->log_msg }}</p>
                </div>
                <div class="col-auto">
                  <button class="status_btn mar_15">Sent</button>
                </div>
                </div>
              </div>
              </a>

              <div id="collapseOne-{{ $loop->index }}" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <div class="row justify-content-between">
                <div class="col-auto">
                  <table class="table estimate_detail_table">
                  @if($log->log_type == 1 && $log->estimate)
            <tr>
            <td><strong>Date</strong></td>
            <td>{{ $log->estimate->sale_estim_date }}</td>
            </tr>
            <tr>
            <td><strong>Due Date</strong></td>
            <td>{{ $log->estimate->sale_estim_valid_date }}</td>
            </tr>
            <tr>
            <td><strong>P.O/S.O</strong></td>
            <td>{{ $log->estimate->sale_estim_customer_ref }}</td>
            </tr>
            <tr>
            <td><strong>Items</strong></td>
            <td>{{ $log->estimate->sale_estim_date }}</td>
            </tr>
            <tr>
            <td><strong>Total</strong></td>
            <td>{{ $log->estimate->total_amount }}</td>
            </tr>
          @elseif($log->log_type == 2 && $log->invoice)
        <tr>
        <td><strong>Date</strong></td>
        <td>{{ $log->invoice->sale_inv_date }}</td>
        </tr>
        <tr>
        <td><strong>Due Date</strong></td>
        <td>{{ $log->invoice->sale_inv_valid_date }}</td>
        </tr>
        <tr>
        <td><strong>P.O/S.O</strong></td>
        <td>{{ $log->invoice->sale_inv_customer_ref }}</td>
        </tr>
        <tr>
        <td><strong>Items</strong></td>
        <td>{{ $log->invoice->item ?? 'n/a' }}</td>
        </tr>
        <tr>
        <td><strong>Total</strong></td>
        <td>{{ $log->invoice->total_amount ?? 'n/a' }}</td>
        </tr>
      @else
      <tr>
      <td colspan="2">No related data found.</td>
      </tr>
    @endif
                  </table>
                </div>
                <div class="col-auto">
                  <a href="#"><button class="add_btn_br">View related events</button></a>

                  @if($log->log_type == 1)
            <a href="{{ route('business.estimates.view', $log->estimate->sale_estim_id) }}"><button
            class="add_btn">View Estimate</button></a>
          @elseif($log->log_type == 2 && $log->invoice)
        <a href="{{ route('business.invoices.view', $log->invoice->sale_inv_id) }}">
        <button class="add_btn">View Invoice</button>
        </a>
      @endif
                </div>
                </div>
              </div>
              </div>
            @endforeach

                   