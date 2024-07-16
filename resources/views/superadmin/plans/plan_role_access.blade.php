<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profityo | New Subscription Plans Access</title>
    @include('layouts.headerlink')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.navigation')
        @include('layouts.sidebar')

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-6">
                            <h1 class="m-0">Subscription Plans Access</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Subscription Plans Access</li>
                            </ol>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <a href="#"><button class="add_btn_br">Cancel</button></a>
                                <a href="#"><button class="add_btn">Save</button></a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content px-10">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Details</h3>
                        </div>
                        <form method="POST" action="{{ route('plans.updaterole', ['plan' => $plan->sp_id]) }}">
                            @csrf
                            @method('PUT')

                            <div class="card-body2">
                                <div class="col-md-12 table-responsive pad_table">
                                    <table class="table table-hover text-nowrap plan_access_table">
                                        <thead>
                                            <tr>
                                                <th>Module</th>
                                                <th class="text-center">Add</th>
                                                <th class="text-center">Edit</th>
                                                <th class="text-center">Delete</th>
                                                <th class="text-center">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                            <input type="hidden" name="mid_{{ $permission->mname }}" value="{{ $permission->mid }}">
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" {{ $permission->is_access ? 'checked' : '' }}
                                                                name="{{ $permission->mname }}"
                                                                id="chk_{{ $permission->mname }}" value="1">
                                                            <label class="form-check-label"
                                                                for="chk_{{ $permission->mname }}">{{ $permission->mtitle }}</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" {{ $permission->is_access_add ? 'checked' : '' }}
                                                            name="add_{{ $permission->mname }}"
                                                            id="chk_add_{{ $permission->mname }}" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" {{ $permission->is_access_view ? 'checked' : '' }}
                                                            name="view_{{ $permission->mname }}"
                                                            id="chk_view_{{ $permission->mname }}" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" {{ $permission->is_access_update ? 'checked' : '' }}
                                                            name="update_{{ $permission->mname }}"
                                                            id="chk_update_{{ $permission->mname }}" value="1">
                                                    </td>
                                                    <td class="text-center">
                                                        <input class="form-check-input" type="checkbox" {{ $permission->is_access_delete ? 'checked' : '' }}
                                                            name="delete_{{ $permission->mname }}"
                                                            id="chk_delete_{{ $permission->mname }}" value="1">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.card-body -->
                            <div class="col-md-12">
                                <div class="row plan_acc_report_lable">Reports</div>
                                <div class="row report_row  justify-content-between">
                                    @foreach ($reports as $reports_val)
                                        <div class="col-auto">
                                            <div class="form-check">
                                                <label class="form-check-label"
                                                    for="chk_{{ $reports_val->mname }}">{{ $reports_val->mtitle }}</label>
                                                <input class="form-check-input" type="checkbox" {{ $reports_val->is_access ? 'checked' : '' }} name="{{ $reports_val->mname }}"
                                                    id="chk_{{ $reports_val->mname }}" value="1">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>


                            <div class="col-md-12 text-center py-20">
                                <a href="{{ route('plans.index') }}" class="add_btn_br px-10">Cancel</a>
                                <a href="#"><button class="add_btn px-10">Save</button></a>
                            </div>
                        </form>
                    </div><!-- /.card-->
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    @include('layouts.footerlink')
</body>

</html>