@extends('masteradmin.layouts.app')
<title>Profityo | Estimate Preview</title>

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="m-0">Estimate Preview</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Estimate</li>
                        <li class="breadcrumb-item active">#{{ $previewData['sale_estim_number'] ?? 'N/A' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content px-10">
        <div class="container-fluid">
            <!-- Estimates Card -->
           
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estimates</h3>
                    <h3 class="card-title float-sm-right">#{{ $previewData['sale_estim_number'] ?? 'N/A' }}</h3>
                </div>
                <div class="card-body2">
                    <div class="row justify-content-between pad-3">
                        <div class="col-md-3">
                            <img src="{{ asset('http://localhost/profityo2/public/dist/img/logo.png') }}" alt="Profityo Logo" class="estimate_logo_img">
                        </div>
                        <div class="col-md-6 text-right">
                            <p class="estimate_view_title">Estimate</p>
                            <p class="company_details_text">{{ $previewData['sale_estim_summary'] ?? 'Summary' }}</p>
                            <!-- Add more dynamic fields here if necessary -->
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row justify-content-between pad-2">
                        <div class="col-auto">
                            <p class="company_business_name" style="text-decoration: underline;">Bill To</p>
                            <!-- Replace with dynamic customer details -->
                        </div>
                        <div class="col-auto">
                            <table class="table estimate_detail_table">
                                <tr>
                                    <td><strong>Estimate Number:</strong></td>
                                    <td>{{ $previewData['sale_estim_number'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Customer Ref:</strong></td>
                                    <td>{{ $previewData['sale_estim_customer_ref'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estimate Date:</strong></td>
                                    <td>{{ $previewData['sale_estim_date'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Valid Until:</strong></td>
                                    <td>{{ $previewData['sale_estim_valid_date'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Grand Total (USD):</strong></td>
                                    <td><strong>${{ number_format($previewData['sale_estim_final_amount'] ?? 0, 2) }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row px-10">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-hover text-nowrap dashboard_table item_table">
                                <thead>
                                    <tr>
                                        <th>Items</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Discount</th>
                                        <th>Tax</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($previewData['items'] ?? [] as $item)
                                        <tr>
                                            <td>{{ $item['sale_product_id'] ?? 'N/A' }}</td>
                                            <td>{{ $item['sale_estim_item_desc'] ?? 'N/A' }}</td>
                                            <td>{{ $item['sale_estim_item_qty'] ?? 'N/A' }}</td>
                                            <td>{{ number_format($item['sale_estim_item_price'] ?? 0, 2) }}</td>
                                            <td>{{ $item['sale_estim_item_discount'] ?? 'N/A' }}</td>
                                            <td>{{ $item['sale_estim_item_tax'] ?? 'N/A' }}</td>
                                            <td>{{ number_format(($item['sale_estim_item_price'] * $item['sale_estim_item_qty']) - $item['sale_estim_item_discount'] + $item['sale_estim_item_tax'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Add more sections as necessary -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

