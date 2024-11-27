@extends('masteradmin.layouts.app')
<title>Profityo | New Product Or Service</title>
@if(isset($access['add_product_services_purchases']) && $access['add_product_services_purchases']) 
@section('content')
<link rel="stylesheet" href="{{ url(path: 'public/vendor/flatpickr/css/flatpickr.css') }}">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">New Employee</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">New Employee</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <ol class="breadcrumb float-sm-right">
              <a href="{{ route('business.employee.index') }}"><button class="add_btn_br">Cancel</button></a>
              <button type="submit" form="items-form" class="add_btn">Save</button>
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
            <h3 class="card-title">Personal Information</h3>
          </div>
          
          <!-- /.card-header -->
          <form id="items-form" method="POST" action="{{ route('business.employee.store') }}">
          @csrf
          <div class="card-body2">
            <div class="row pad-5">
              <div class="col-md-4">
              <div class="form-group">
              <label for="employeefirstname">First Name</label>
              <input type="text" class="form-control" id="employeefirstname" name="emp_first_name" value="{{ old('emp_first_name') }}" placeholder="Enter First Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employeelastname">Last Name</label>
              <input type="text" class="form-control" id="employeelastname" name="emp_last_name" value="{{ old('emp_last_name') }}" placeholder="Enter Last Name">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employeesecuritynumber">Social Security Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('emp_social_security_number') is-invalid @enderror" id="employeesecuritynumber" name="emp_social_security_number" value="{{ old('emp_social_security_number') }}" placeholder="Enter Social Security Number">
              @error('emp_social_security_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="employeeaddress">Address Line 1</label>
              <input type="text" class="form-control" id="employeeaddress" name="emp_hopy_address" value="{{ old('emp_hopy_address') }}" placeholder="Enter a Location">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>State</label>
              <select class="form-control" name="state_id" id="state_id">
                <option value="">Select State</option>
                @foreach($State as $state)
                  <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employeecity">City</label>
              <input type="text" class="form-control" id="employeecity" name="city_name" value="{{ old('city_name') }}" placeholder="Enter A City">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employeezipcode">Postal/ZIP Code</label>
              <input type="text" class="form-control" id="employeezipcode" name="zipcode" value="{{ old('zipcode') }}" placeholder="Enter a Zip Code">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group @error('emp_dob') is-invalid @enderror">
              <label>Date of Birth <span class="text-danger">*</span></label>
            
              <div class="input-group date" id="estimatedate" data-target
              -input="nearest">
           
              <x-flatpickr 
                    id="from-datepicker" 
                    name="emp_dob" 
                    placeholder="Select a date" 
                />
              <div class="input-group-append">
                <div class="input-group-text" id="from-calendar-icon">
                    <i class="fa fa-calendar-alt"></i>
                </div>
              </div>
            </div>
            @error('emp_dob')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="employeeemail">Email</label>
              <input type="email" class="form-control" id="employeeemail" name="emp_email" value="{{ old('emp_email') }}" placeholder="Enter Email">
            </div>
          </div>
        </div>
        <div class="modal_sub_title">Work Information</div>
        <div class="row pad-5">
          <div class="col-md-4">
            <div class="form-group @error('emp_doh') is-invalid @enderror">
              <label>Date of hire <span class="text-danger">*</span></label>
             
              <div class="input-group date" id="estimatevaliddate" data-target-input="nearest">
          
            <x-flatpickr 
                    id="to-datepicker" 
                    name="emp_doh" 
                    placeholder="Select a date" 
                />
              <div class="input-group-append">
                <div class="input-group-text" id="to-calendar-icon">
                    <i class="fa fa-calendar-alt"></i>
                </div>
              </div>
              
            </div>
            @error('emp_doh')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror

            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Work Location <span class="text-danger">*</span></label>
              <!-- <select class="form-control" name="emp_work_location" style="width: 100%;" required>
                <option value="">Choose an item...</option>
              </select> -->
              <select class="form-control @error('emp_work_location') is-invalid @enderror" name="emp_work_location" id="emp_work_location">
                <option value="">Select State</option>
                @foreach($State as $state)
                  <option value="{{ $state->id }}" {{ old('emp_work_location') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select>
              @error('emp_work_location')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Wage Type <span class="text-danger">*</span></label>
              <select class="form-control @error('emp_wage_type') is-invalid @enderror" id="emp_wage_type" name="emp_wage_type">
                <option value="{{ old('emp_wage_amount') }}">Select</option>
                <option value="Hourly">Hourly</option>
                <option value="Annual">Annual</option>
              </select>
              @error('emp_wage_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              <!-- <select class="form-control" name="emp_wage_type" style="width: 100%;" required> -->
              <!-- <select class="form-control" name="emp_wage_type" id="emp_wage_type">
                
                <option value="">Select State</option>
                @foreach($State as $state)
                  <option value="{{ $state->id }}" {{ old('emp_wage_type') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                @endforeach
              </select> -->
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="wagesamount">Wages Amount <span class="text-danger">*</span></label>
              <input type="number" class="form-control @error('emp_wage_amount') is-invalid @enderror" id="wagesamount" name="emp_wage_amount" value="{{ old('emp_wage_amount') }}" placeholder="0.00">
              @error('emp_wage_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
            </div>
          </div>
        </div>
          <div class="row py-20 px-10">
            <div class="col-md-12 text-center">
              <a href="{{ route('business.employee.index') }}" class="add_btn_br">Cancel</a>
              <a href="#"><button class="add_btn">Save</button></a>
            </div>
          </div><!-- /.col -->
          </form>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content --> 
  </div>
<!-- /.content-wrapper -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ url('public/vendor/flatpickr/js/flatpickr.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment"></script>

  <script>
document.addEventListener('DOMContentLoaded', function() {

        var fromdatepicker = flatpickr("#from-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            onChange: calculateDays
        });

        var todatepicker = flatpickr("#to-datepicker", {
            locale: 'en',
            altInput: true,
            dateFormat: "m/d/Y",
            altFormat: "d/m/Y",
            allowInput: true,
            onChange: calculateDays
        });

        document.getElementById('from-calendar-icon').addEventListener('click', function() {
            fromdatepicker.open(); 
        });

        document.getElementById('to-calendar-icon').addEventListener('click', function() {
            todatepicker.open(); 
        });

        function calculateDays() {
        var sdate = fromdatepicker.input.value;  
        var edate = todatepicker.input.value;  
        var totalDays = 0;   

        if(sdate && edate) {
            var startDate = new Date(sdate);
            var endDate = new Date(edate);

            var timeDifference = endDate.getTime() - startDate.getTime();

            var totalDays = timeDifference / (1000 * 3600 * 24); 

            if (totalDays < 0) {
            document.getElementById("total-days").innerText = "Invalid date range"; 
            document.getElementById("hidden-total-days").value = ''; 

          } else {
              document.getElementById("total-days").innerText = totalDays; 
              document.getElementById("hidden-total-days").value = totalDays; 
          }

        }

      }
});

    </script>





<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sellCheckbox = document.getElementById('purchases_product_sell');
    const buyCheckbox = document.getElementById('purchases_product_buy');
    const incomeAccountGroup = document.getElementById('income_account_group');
    const expenseAccountGroup = document.getElementById('expense_account_group');

    function toggleVisibility() {
      incomeAccountGroup.style.display = sellCheckbox.checked ? 'block' : 'none';
      expenseAccountGroup.style.display = buyCheckbox.checked ? 'block' : 'none';
    }

    toggleVisibility();

    sellCheckbox.addEventListener('change', toggleVisibility);
    buyCheckbox.addEventListener('change', toggleVisibility);
  });
</script>


@endsection
@endif