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
                        <form method="POST" action="{{ route('plans.store') }}">
                            @csrf

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">View</th>
                                        <th class="text-center">Update</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" {{ $permission->is_access ? 'checked' : '' }} name="{{ $permission->mname }}" id="chk_{{ $permission->mname }}" value="1"> 
                                                <label for="chk_{{ $permission->mname }}">{{ $permission->mtitle }}</label>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" {{ $permission->is_access_add ? 'checked' : '' }} name="add_{{ $permission->mname }}" id="chk_add_{{ $permission->mname }}" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" {{ $permission->is_access_view ? 'checked' : '' }} name="view_{{ $permission->mname }}" id="chk_view_{{ $permission->mname }}" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" {{ $permission->is_access_update ? 'checked' : '' }} name="update_{{ $permission->mname }}" id="chk_update_{{ $permission->mname }}" value="1">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" {{ $permission->is_access_delete ? 'checked' : '' }} name="delete_{{ $permission->mname }}" id="chk_delete_{{ $permission->mname }}" value="1">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="col-12 text-center">
                            <a href="#"><button class="add_btn_br">Cancel</button></a>
                            <a href="#"><button class="add_btn">Save</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    @include('layouts.footerlink')
</body>
</html>
