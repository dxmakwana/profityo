<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profityo | Business Detail</title>
    @include('layouts.headerlink')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.navigation')
        @include('layouts.sidebar')

       <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="m-0">Business Detail</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="super_adminindex.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Business Detail</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-auto">
            <!-- <ol class="breadcrumb float-sm-right">
              <a href="#" data-toggle="modal" data-target="#deletebusiness"><button class="add_btn_br"><i class="fas fa-solid fa-trash mr-2"></i>Delete</button></a>
              <a href="edit-business.html"><button class="add_btn_br"><i class="fas fa-solid fa-pen-to-square mr-2"></i>Edit</button></a>
            </ol> -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Business Information</h3>
              </div>
              <div class="card-body">
                <div class="row justify-content-between">
                  <div class="col-auto">
                    <table class="table estimate_detail_table">
                      <tbody>
                        <tr>
                            <td><strong>Business Name :</strong></td>
                            <td>{{ $user->user_business_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Name :</strong></td>
                            <td>{{ $user->user_first_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone :</strong></td>
                            <td>{{ $user->user_phone }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email :</strong></td>
                            <td>{{ $user->user_email }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-auto">
                    <table class="table estimate_detail_table">
                      <tbody>
                      <tr>
                          <td><strong>Membership Plan :</strong></td>
                          <td>{{ $user->plan ? $user->plan->sp_name : 'No Plan' }}</td>
                      </tr>
                      <tr>
                          <td><strong>Total Users :</strong></td>
                          <td>{{ $user->totalUserCount }}</td>
                      </tr>
                      <tr>
                          <td><strong>Created Date :</strong></td>
                          <td>{{ $user->created_at }}</td>
                      </tr>
                      <tr>
                          <td><strong>Last Updated Date :</strong></td>
                          <td>{{ $user->updated_at }}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto"><h3 class="card-title">Business User</h3></div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body1">
                            <div class="col-md-12 table-responsive pad_table">
                                <table id="example4" class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>User Role</th>
                                            <th>Last Updated</th>
                                            <th>Status</th>
                                            <!-- <th class="sorting_disabled text-right" data-orderable="false">Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($udetail as $detail)
                                        <tr>
                                            <td>{{ $detail->users_name }}</td>
                                            <td>{{ $detail->users_email  }}</td>
                                            <td>{{ $detail->users_phone  }}</td>
                                            <td>{{ $detail->role_name}}</td>
                                            <td>{{ $detail->updated_at }}</td>
                                            <td> @if ($detail->user_status == 0)
                                                  <span class="status_btn converted_status"> Active </span>
                                                  @else
                                                  <span class="status_btn overdue_status">Inactive</span>
                                                  @endif
                                            </td>
                                            <!-- <td class="text-right">
                                                <a data-toggle="modal" data-target="#deleteuser"><i class="fas fa-solid fa-trash delete_icon_grid"></i></a>
                                            </td> -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
  <div class="modal fade" id="deletebusiness" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete Business</b></p>
          <p class="company_details_text px-10">Are You Sure You Want to Delete This Business?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="deleteuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body pad-1 text-center">
          <i class="fas fa-solid fa-trash delete_icon"></i>
          <p class="company_business_name px-10"><b>Delete User</b></p>
          <p class="company_details_text px-10">Are You Sure You Want to Delete This User?</p>
          <button type="button" class="add_btn px-15" data-dismiss="modal">Cancel</button>
          <button type="submit" class="delete_btn px-15">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- ./wrapper -->


    @include('layouts.footerlink')

</body>

</html>