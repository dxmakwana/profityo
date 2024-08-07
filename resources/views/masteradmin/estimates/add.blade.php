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
          <h1 class="m-0">{{ __('New Estimate') }}</h1>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('business.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ __('New Estimate') }}</li>
          </ol>
        </div><!-- /.col -->
        <div class="col-auto">
          <ol class="breadcrumb float-sm-right">
            <a href="#"><button class="add_btn_br">Preview</button></a>
            <a href="#"><button class="add_btn">Save & Continue</button></a>
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
      <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Business Address and Contact Details, Title, Summary, and Logo</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row justify-content-between">
            <div class="col-md-3 px-10">
              <div class="business_logo_uplod_box">
                @if($businessDetails && $businessDetails->bus_image)
          <img src="{{ url(env('IMAGE_URL') . 'masteradmin/business_profile/' . $businessDetails->bus_image) }}"
            class="elevation-2" target="_blank">
          <!-- <h3 class="card-title float-sm-right px-10" data-toggle="modal" data-target="#removebusinessimage">Remove image</h3> -->

          <div class="modal fade" id="removebusinessimage" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body pad-1 text-center">
              <i class="fas fa-solid fa-trash delete_icon"></i>
              <p class="company_details_text">Removing your logo will remove it from all existing and future
                invoices and estimates. Are you sure you want to remove your business logo?</p>
              <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
              <button type="submit" class="delete_btn px-15">Delete</button>
              </div>
            </div>
            </div>
          </div>
        @else
      <form method="post" id="editBusinessImageForm" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- <input type="file" name="image" id="image" class="form-control" >  -->
        <img src="{{url('public/dist/img/upload_icon.png')}}" class="upload_icon_img">
        <p class="upload_text">Browse or Drop your Logo Here Maximum 5MB in Size. JPG, PNG, or GIF Formats.
        Recommended Size: 300 x 200 Pixels.</p>
      </form>
    @endif

              </div>
            </div>
            <!-- /.col -->
            <div class="col-md-7 px-10">
              <div class="row justify-content-end">
                <div class="col-md-7 float-sm-right">
                  <input type="text" class="form-control text-right" id="estimatetitle" placeholder="Estimate Title">
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-md-7 float-sm-right px-10">
                  <input type="text" class="form-control text-right" id="estimatesummary"
                    placeholder="Summary (e.g. project name, description of estimate)">
                </div>
              </div>
              <div class="px-10">
                <p class="company_business_name text-right">{{ $businessDetails->bus_company_name }}</p>
                <p class="company_details_text text-right">{{  $businessDetails->bus_address1 }}</p>
                <p class="company_details_text text-right">{{  $businessDetails->bus_address2 }}</p>
                <p class="company_details_text text-right">{{ $businessDetails->state->name ?? '' }},
                  {{  $businessDetails->city_name }} {{ $businessDetails->zipcode }}
                </p>
                <p class="company_details_text text-right">{{  $businessDetails->country->name ?? '' }}</p>
                <p class="company_details_text text-right">Phone: {{  $businessDetails->bus_phone }}</p>
                <p class="company_details_text text-right">Mobile: {{  $businessDetails->bus_mobile }}</p>
                <p class="company_details_text text-right">{{  $businessDetails->bus_website }}</p>
              </div>
              <h3 class="card-title float-sm-right px-10" data-toggle="modal"
                data-target="#editbusiness_companyaddress"><img src="{{url('public/dist/img/dot.png')}}"
                  class="dot_img">Edit your business address and contact details</h3>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
      <!-- /.card -->

      <!-- card -->
      <div class="card card-default">
        <!-- /.card-header -->
        <div class="card-body2">
          <div class="row justify-content-between pad-3">
            <div class="col-md-3">
              <div class="add_customer_box">
                <img src="{{url('public/dist/img/customer1.png')}}" class="upload_icon_img">
                <span class="add_customer_text">Add Customer</span>
              </div>
              <div class="add_customer_list" style="display: none;">
                <select id="customerSelect" class="form-control select2" style="width: 100%;">
                  <option>Select Items</option>
                  @foreach($salecustomer as $customer)
            <option value="{{ $customer->sale_cus_id }}" {{ $customer->sale_cus_id == old('customer_id') ? 'selected' : '' }}>
            {{ $customer->sale_cus_business_name }}
            </option>
          @endforeach
                </select>

                <div id="customerInfo">

                </div>
              </div>
            </div>

          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="estimatenumber">Estimate Number</label>
                  <input type="text" class="form-control" id="estimatenumber" placeholder="">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="estimatecustomerref">Customer Ref</label>
                  <input type="text" class="form-control" id="estimatecustomerref" placeholder="">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Date</label>
                  <div class="input-group date" id="estimatedate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder=""
                      data-target="#estimatedate" />
                    <div class="input-group-append" data-target="#estimatedate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Valid Until</label>
                  <div class="input-group date" id="estimatevaliddate" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" placeholder=""
                      data-target="#estimatevaliddate" />
                    <div class="input-group-append" data-target="#estimatevaliddate" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                    </div>
                  </div>
                  <p class="within_day">Within 7 days</p>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
        <div class="row px-10">
          <div class="col-md-12 text-right">
            <button class="editcolum_btn" data-toggle="modal" data-target="#editcolum"><i
                class="fas fa-solid fa-pen-to-square mr-2"></i>Edit Columns</button>
            <button class="additem_btn"><i class="fas fa-plus add_plus_icon"></i>Add Item</button>
          </div>
          <div class="col-md-12 table-responsive">
              <table class="table table-hover text-nowrap dashboard_table item_table">
                  <thead>
                      <tr>
                          <th style="width: 30%;">Items</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Discount</th>
                          <th>Tax</th>
                          <th class="text-right">Amount</th>
                          <th>Actions</th> <!-- New column for actions -->
                      </tr>
                  </thead>
                  <tbody>
                      <tr class="item-row" id="item-row-template" style="display: none;">
                          <td>
                              <div>
                                  <select class="form-control select2" style="width: 100%;">
                                      <option>Select Items</option>
                                      <option>product121321anjjalklk</option>
                                      <option>Items1</option>
                                      <option>product121321anjjalklk</option>
                                  </select>
                                  <input type="number" class="form-control px-10" placeholder="Enter item description">
                              </div>
                          </td>
                          <td><input type="number" class="form-control" placeholder="1"></td>
                          <td>
                              <div class="d-flex">
                                  <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend">
                                  <select class="form-select form-selectcurrency">
                                      <option>$</option>
                                      <option>€</option>
                                      <option>(CFA)</option>
                                      <option>£</option>
                                  </select>
                              </div>
                          </td>
                          <td>
                              <div class="d-flex">
                                  <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend">
                                  <select class="form-select form-selectcurrency">
                                      <option>%</option>
                                      <option>Kz</option>
                                  </select>
                              </div>
                          </td>
                          <td>
                              <select class="form-control select2" style="width: 100%;">
                                  <option>Tax1 10%</option>
                                  <option>cgst 18%</option>
                                  <option>igst 2%</option>
                              </select>
                          </td>
                          <td class="text-right">$0.00</td>
                          <td><i class="fa fa-trash delete-item"></i></td>
                      </tr>
                      <!-- Initial default row -->
                      <tr class="item-row">
                          <td>
                              <div>
                                  <select class="form-control select2" style="width: 100%;">
                                      <option>Select Items</option>
                                      <option>product121321anjjalklk</option>
                                      <option>Items1</option>
                                      <option>product121321anjjalklk</option>
                                  </select>
                                  <input type="number" class="form-control px-10" placeholder="Enter item description">
                              </div>
                          </td>
                          <td><input type="number" class="form-control" placeholder="1"></td>
                          <td>
                              <div class="d-flex">
                                  <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend">
                                  <select class="form-select form-selectcurrency">
                                      <option>$</option>
                                      <option>€</option>
                                      <option>(CFA)</option>
                                      <option>£</option>
                                  </select>
                              </div>
                          </td>
                          <td>
                              <div class="d-flex">
                                  <input type="text" class="form-control form-controltext" aria-describedby="inputGroupPrepend">
                                  <select class="form-select form-selectcurrency">
                                      <option>%</option>
                                      <option>Kz</option>
                                  </select>
                              </div>
                          </td>
                          <td>
                              <select class="form-control select2" style="width: 100%;">
                                  <option>Tax1 10%</option>
                                  <option>cgst 18%</option>
                                  <option>igst 2%</option>
                              </select>
                          </td>
                          <td class="text-right">$0.00</td>
                          <td><i class="fa fa-trash delete-item"></i></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <!-- /.col -->
        </div>
        <hr />
        <div class="row justify-content-end">
          <div class="col-md-4 subtotal_box">
            <div class="table-responsive">
              <table class="table total_table">
                <tr>
                  <td style="width:50%">Sub Total :</td>
                  <td>$275.00</td>
                </tr>
                <tr>
                  <td>Discount :</td>
                  <td>$12.50</td>
                </tr>
                <tr>
                  <td>Tax :</td>
                  <td>$23.75</td>
                </tr>
                <tr>
                  <td>Total:</td>
                  <td>$261.25</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <div class="row pad-2">
          <div class="col-md-12">
            <div class="form-group">
              <label for="inputDescription">Notes / Terms</label>
              <textarea id="inputDescription" class="form-control" rows="3"
                placeholder="Enter notes or terms of service that are visible to your customer"></textarea>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div>


    </div>
    <!-- /.card -->

    <!-- card -->
    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Footer</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row justify-content-between">
          <div class="col-md-12">
            <textarea id="inputDescription" class="form-control" rows="3"
              placeholder="Enter a footer for this estimate (e.g. tax information, thank you note)"></textarea>
          </div>
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.card -->

    <div class="row py-20">
      <div class="col-md-12 text-center">
        <a href="#"><button class="add_btn_br">Preview</button></a>
        <a href="#"><button class="add_btn">Save & Continue</button></a>
      </div>
    </div><!-- /.col -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<div class="modal fade" id="editbusiness_companyaddress" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Edit Business Address and Contact Details') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="editBusinessForm" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">
          <div class="row pxy-15 px-10">
            <div class="col-md-12">
              <div class="form-group">
                <x-input-label for="company-business" :value="__('Company/Business')"> <span
                    class="text-danger">*</span></x-input-label>
                <x-text-input type="text" class="form-control" id="bus_company_name" placeholder="Enter Business Name"
                  name="bus_company_name" required autofocus autocomplete="bus_company_name"
                  :value="old('bus_company_name', $businessDetails->bus_company_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_company_name')" />
              </div>
            </div>
          </div>
          <div class="modal_sub_title">Address</div>
          <div class="row pxy-15 px-10">
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_address1" :value="__('Address Line 1')" />
                <x-text-input type="text" class="form-control" id="bus_address1" placeholder="Enter A Address Line 1"
                  name="bus_address1" required autofocus autocomplete="bus_address1" :value="old('bus_address1', $businessDetails->bus_address1 ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_address1')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_address2" :value="__('Address Line 2')" />
                <x-text-input type="text" class="form-control" id="bus_address2" placeholder="Enter A Address Line 2"
                  name="bus_address2" required autofocus autocomplete="bus_address2" :value="old('bus_address2', $businessDetails->bus_address2 ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_address2')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="city_name" :value="__('City')" />
                <x-text-input type="text" class="form-control" id="city_name" placeholder="Enter A City"
                  name="city_name" required autofocus autocomplete="city_name" :value="old('city_name', $businessDetails->city_name ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('city_name')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="zipcode" :value="__('Postal/ZIP Code')" />
                <x-text-input type="text" class="form-control" id="zipcode" placeholder="Enter a Zip Code"
                  name="zipcode" required autofocus autocomplete="zipcode" :value="old('zipcode', $businessDetails->zipcode ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="country" :value="__('Country')" />
                <select class="form-control select2" style="width: 100%;" id="country" name="country_id" required>
                  <option default>Select a Country...</option>
                  @foreach($countries as $country)
            <option value="{{ $country->id }}" {{ old('country_id', $businessDetails->country_id ?? '') == $country->id ? 'selected' : '' }}>{{ $country->name }} ({{ $country->iso2 }})</option>
          @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('Country')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="state" :value="__('Province/State')" />
                <select class="form-control select2" style="width: 100%;" id="state" name="state_id" required>
                  <option default>Select a State...</option>
                  @foreach($states as $state)
            <option value="{{ $state->id }}" {{ $state->id == old('state_id', $businessDetails->state_id) ? 'selected' : '' }}>
            {{ $state->name }}
            </option>
          @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('state')" />
              </div>
            </div>
          </div>
          <div class="modal_sub_title">Contact</div>
          <div class="row pxy-15 px-10">
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_phone" :value="__('Phone')" />
                <x-text-input type="text" class="form-control" id="bus_phone" placeholder="Enter a Phone"
                  name="bus_phone" required autofocus autocomplete="bus_phone" :value="old('bus_phone', $businessDetails->bus_phone ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_phone')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_mobile" :value="__('Mobile')" />
                <x-text-input type="text" class="form-control" id="bus_mobile" placeholder="Enter a Mobile"
                  name="bus_mobile" required autofocus autocomplete="bus_mobile" :value="old('bus_mobile', $businessDetails->bus_mobile ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_mobile')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <x-input-label for="bus_website" :value="__('Website')" />
                <x-text-input type="text" class="form-control" id="bus_website" placeholder="Enter a Website"
                  name="bus_website" required autofocus autocomplete="bus_website" :value="old('bus_website', $businessDetails->bus_website ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bus_website')" />
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="currency">Business Currency </label>
                <h4 for="currency">
                  @if ($currency)
            <h4 for="currency">{{ $currency->currency }} - {{ $currency->currency_name }}</h4>
          @else
        <h4 for="currency">No currency information available</h4>
      @endif
                </h4>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="add_btn_br" data-dismiss="modal">Cancel</button>
            <button type="submit" class="add_btn">{{ __('Save Changes') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editcolum" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Customize this Estimate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">
          <div class="modal_sub_title" style="margin-top: 0;">Edit The Titles Of The Columns Of This
            Estimate:</div>
          <div class="colum_box">
            <h2 class="edit-colum_title">Items</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="item1" name="r1" checked>
                  <label for="item1">Items (Default)</label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="icheck-primary">
                  <input type="radio" id="item2" name="r1">
                  <label for="item2">Products</label>
                </div>
              </div>
              <div class="col-md-2">
                <div class="icheck-primary">
                  <input type="radio" id="item3" name="r1">
                  <label for="item3">Services</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="item4" name="r1">
                  <label for="item4">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="colum_box">
            <h2 class="edit-colum_title">Units</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="quantity1" name="r2" checked>
                  <label for="quantity1">Quantity (Default)</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="quantity2" name="r2">
                  <label for="quantity2">Hours</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="quantity3" name="r2">
                  <label for="quantity3">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="colum_box">
            <h2 class="edit-colum_title">Price</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="price1" name="r3" checked>
                  <label for="price1">Price (Default)</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="price2" name="r3">
                  <label for="price2">Rate</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="price3" name="r3">
                  <label for="price3">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="colum_box">
            <h2 class="edit-colum_title">Discount</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="discount1" name="r4" checked>
                  <label for="discount1">Discount (Default)</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="discount2" name="r4">
                  <label for="discount2">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="colum_box">
            <h2 class="edit-colum_title">Tax</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="tax1" name="r5" checked>
                  <label for="tax1">Tax (Default)</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="tax2" name="r5">
                  <label for="tax2">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="colum_box">
            <h2 class="edit-colum_title">Amount</h2>
            <div class="row align-items-center justify-content-between">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="amount1" name="r6" checked>
                  <label for="amount1">Amount (Default)</label>
                </div>
              </div>
              <div class="col-md-5">
                <div class="icheck-primary d-flex align-items-center">
                  <input type="radio" id="amount2" name="r6">
                  <label for="amount2">Other</label>
                  <input type="text" class="form-control mar_15" placeholder="">
                </div>
              </div>
            </div>
          </div>

          <div class="modal_sub_title px-15">Hide columns:</div>

          <div class="colum_box">
            <div class="row align-items-center">
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hideitem" name="r7">
                  <label for="hideitem">Hide Item Name</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hideunit" name="r8">
                  <label for="hideunit">Hide Units</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hideprice" name="r9">
                  <label for="hideprice">Hide Price</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hidediscount" name="r10">
                  <label for="hidediscount">Hide Discount</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hidetax" name="r11">
                  <label for="hidetax">Hide Tax</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hideamount" name="r12">
                  <label for="hideamount">Hide Amount</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="icheck-primary">
                  <input type="radio" id="hidedescription" name="r13">
                  <label for="hidedescription">Hide Item Description</label>
                </div>
              </div>
            </div>
          </div>

          <div class="row pad-3">
            <div class="col-md-12">
              <div class="icheck-primary">
                <input type="radio" id="apply1" name="r16">
                <label for="apply1">Apply These Settings to Future Estimates.</label>
                <p>These settings will apply to estimates and invoices. You can change these anytime from
                  Invoice Customization settings.</p>
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


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    $('.select2').select2();
    $('#country').change(function () {
      var countryId = $(this).val();
      // alert(countryId);
      if (countryId) {
        $.ajax({
          url: '{{ env('APP_URL') }}{{ config('global.businessAdminURL') }}/states/' + countryId,
          type: 'GET',
          dataType: 'json',
          success: function (data) {
            $('#state').empty();
            $('#state').append('<option value="">Select a State...</option>');
            $.each(data, function (key, value) {
              $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
      } else {
        $('#state').empty();
        $('#state').append('<option value="">Select a State...</option>');
      }
    });
  });
</script>
<script>
  $(document).ready(function () {
    $('#editBusinessForm').on('submit', function (event) {
      event.preventDefault();

      $.ajax({
        url: '{{ route('business.business.edits') }}',
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.success) {
            var business = response.data;

            $('.company_business_name').text(business.bus_company_name);
            $('.company_details_text').eq(0).text(business.bus_address1);
            $('.company_details_text').eq(1).text(business.bus_address2);
            $('.company_details_text').eq(2).text(business.state.name + ', ' + business.city_name + ' ' + business.zipcode);
            $('.company_details_text').eq(3).text(business.country.name);
            $('.company_details_text').eq(4).text('Phone: ' + business.bus_phone);
            $('.company_details_text').eq(5).text('Mobile: ' + business.bus_mobile);
            $('.company_details_text').eq(6).text(business.bus_website);

            $('#editbusiness_companyaddress').modal('hide');

            // alert(response.message);
          } else {
            console.log('Update failed');
          }
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
        }
      });
    });

    //delete business image
    $('.delete_btn').on('click', function (event) {
      event.preventDefault();

      $.ajax({
        url: '{{ route('business.business.edits') }}',
        type: 'PATCH',
        data: {
          _token: '{{ csrf_token() }}',
          delete_image: true
        },
        success: function (response) {
          if (response.success) {
            $('.company_details_text').eq(7).remove();
            $('#removebusinessimage').modal('hide');
            alert(response.message);
          } else {
            console.log('Delete failed');
          }
        },
        error: function (xhr) {
          console.log('Error:', xhr.responseText);
        }
      });
    });

    //onchange image upload

    // $('#image').on('change', function(event) {
    //   event.preventDefault();
    //   var formData = new FormData($('#editBusinessImageForm')[0]);
    //   alert(formData);
    //       $.ajax({
    //           url: '{{ route('business.business.edit') }}',
    //           type: 'PATCH',
    //           data: formData,
    //           processData: false,
    //           contentType: false,
    //           success: function(response) {
    //               if (response.success) {
    //                   var business = response.data;

    //                   $('.company_business_name').text(business.bus_company_name);
    //                   $('.company_details_text').eq(0).text(business.bus_address1);
    //                   $('.company_details_text').eq(1).text(business.bus_address2);
    //                   $('.company_details_text').eq(2).text(business.state.name + ', ' + business.city_name + ' ' + business.zipcode);
    //                   $('.company_details_text').eq(3).text(business.country.name);
    //                   $('.company_details_text').eq(4).text('Phone: ' + business.bus_phone);
    //                   $('.company_details_text').eq(5).text('Mobile: ' + business.bus_mobile);
    //                   $('.company_details_text').eq(6).text(business.bus_website);

    //                   // Update the image if uploaded
    //                   if (business.bus_image) {
    //                       $('.upload_icon_img').attr('src', '{{ url("storage/masteradmin/business_profile") }}/' + business.bus_image);
    //                   }

    //                   alert(response.message);
    //               } else {
    //                   console.log('Update failed');
    //               }
    //           },
    //           error: function(xhr) {
    //               console.log('Error:', xhr.responseText);
    //           }
    //       });
    //   });

    //show customer list droupdown list
    $('.add_customer_box').on('click', function () {
      var $customerList = $(this).siblings('.add_customer_list');
      var $addCustomerBox = $(this);

      if ($customerList.is(':visible')) {

        $customerList.hide();
        $addCustomerBox.show();
      } else {

        $('.add_customer_list').hide();
        $('.add_customer_box').show();
        $customerList.show();
        $addCustomerBox.hide();
      }
    });

    //cutomer data get
    $('#customerSelect').change(function () {
      var customerId = $(this).val();
      if (customerId) {
        $.ajax({
          url: '{{ route("business.salescustomers.getCustomerInfo") }}',
          type: 'GET',
          data: { sale_cus_id: customerId },
          success: function (response) {
            if (response.success) {
              var customer = response.data;
              var customerInfoHtml = `
                          <h4>Bill to</h4>
                          <p><strong>${customer.sale_cus_business_name}</strong></p>
                          <p>${customer.sale_cus_first_name}</p>
                          <p>${customer.sale_cus_last_name}</p>
                          <p>${customer.sale_cus_account_number}</p>
                          <p>${customer.sale_cus_website}</p>
                          <p>${customer.sale_bill_address1}, ${customer.sale_bill_address2}, ${customer.sale_bill_city_name}, ${customer.sale_bill_zipcode}</p>
                          <p>${customer.state.name}</p>
                          <p>${customer.country.name}</p>

                          <h4>Ship to</h4>
                          <p>${customer.sale_ship_address1}, ${customer.sale_ship_address2}, ${customer.sale_ship_city_name}, ${customer.sale_ship_zipcode}</p>
                          <p>${customer.sale_ship_phone}</p>

                          <p>${customer.sale_cus_email}</p>
                          <p>${customer.sale_cus_phone}</p>
                          <a href="#" id="chooseDifferentCustomer">Choose a different customer</a>
                      `;
              $('#customerInfo').html(customerInfoHtml).show(); 

              $('#chooseDifferentCustomer').click(function (e) {
                e.preventDefault();
                $('#customerInfo').hide(); 
                $('#customerSelect').focus(); 
              });
            } else {
              alert(response.message);
            }
          },
          error: function () {
            alert('Error retrieving customer information');
          }
        });
      } else {
        $('#customerInfo').hide(); 
      }
    });

      // Function to create a new default row
      function createDefaultRow() {
        var $templateRow = $('#item-row-template').clone().removeAttr('id').removeAttr('style').addClass('item-row');
        $templateRow.find('input').val('');
        // Ensure dropdowns are not duplicated in the template
        $templateRow.find('select.select2').each(function() {
          // $(this).prop('selectedIndex', 0);
          // $(this).val(null).trigger('change'); // Reset select fields
          $(this).next('.select2-container').remove(); // Remove any existing Select2 containers
        });

        $templateRow.find('select.select2').select2();

        return $templateRow;
    }

    // Add item functionality
    $('.additem_btn').click(function() {
        var $newRow = createDefaultRow();
        $('.item_table tbody').append($newRow);
        // initializeSelect2($newRow); // Initialize select2 for the new row
    });

    // Remove item functionality
    $(document).on('click', '.delete-item', function() {
        var $row = $(this).closest('tr');
        $row.remove();

        // Check if there are no rows left and add a new row if needed
        if ($('.item_table tbody tr.item-row').length === 0) {
            var $newRow = createDefaultRow();
            $('.item_table tbody').append($newRow);
            // initializeSelect2($newRow); // Initialize select2 for the new row
        }
    });

    // Ensure there's at least one row on page load
    if ($('.item_table tbody tr.item-row').length === 0) {
        var $newRow = createDefaultRow();
        $('.item_table tbody').append($newRow);
        // initializeSelect2($newRow); // Initialize select2 for the initial row
    } else {
        // Initialize select2 for existing rows on page load
        // initializeSelect2($('.item_table tbody'));
    }
    initializeSelect2($('.item_table tbody'));
  });
</script>


<!-- ./wrapper -->