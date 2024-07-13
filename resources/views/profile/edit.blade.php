@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2 align-items-center">
          <div class="col-sm-12">
            <h1 class="m-0">Personal Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
              <li class="breadcrumb-item active">Personal Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content px-10">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card">
              <div class="profile nav flex-column nav-tabs" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="vert-tabs-personalinformation-tab" data-toggle="pill" href="#vert-tabs-personalinformation" role="tab" aria-controls="vert-tabs-personalinformation" aria-selected="true">Personal Information <i class="fas fa-angle-right right"></i></a>
                <a class="nav-link" id="vert-tabs-changepassword-tab" data-toggle="pill" href="#vert-tabs-changepassword" role="tab" aria-controls="vert-tabs-changepassword" aria-selected="false">Change Password <i class="fas fa-angle-right right"></i></a>
              </div>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="tab-content" id="vert-tabs-tabContent">
              <div class="tab-pane text-left fade show active" id="vert-tabs-personalinformation" role="tabpanel" aria-labelledby="vert-tabs-personalinformation-tab">
                <div class="card">
                  @include('profile.partials.update-profile-information-form')
                </div>
              </div>
              <div class="tab-pane fade" id="vert-tabs-changepassword" role="tabpanel" aria-labelledby="vert-tabs-changepassword-tab">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Change Password</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body2">
                    <div class="row pad-5">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="oldpassword">Old Password</label>
                          <input type="text" class="form-control" id="oldpassword" placeholder="Enter Old Password">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="newpassword">New Password</label>
                          <input type="text" class="form-control" id="newpassword" placeholder="Enter New Password">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="confirmnewpassword">Confirm New Password</label>
                          <input type="text" class="form-control" id="confirmnewpassword" placeholder="Enter Your Confirm Password">
                        </div>
                      </div>
                    </div>
                    <div class="row py-20 px-10">
                      <div class="col-md-12 text-center">
                        <a href="#"><button class="add_btn">Save Changes</button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
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
</div>
<!-- ./wrapper -->


@endsection
