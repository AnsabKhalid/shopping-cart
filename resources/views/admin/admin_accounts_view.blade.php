@extends('admin_layout.admin')

@section('content')
{{Form::hidden('', $increment = 1)}}  
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Feedback</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Feedback</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Feedback</h3>
              </div>
              @if (Session::has('error'))
                <div class="alert alert-danger">
                  {{Session::get('error')}}
                </div>
              @elseif (Session::has('status'))
                  <div class="alert alert-success">
                      {{Session::get('status')}}
                  </div>
             	@endif
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Number</th>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Date</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($adminViews as $adminView)
                      <tr>
                        <td>{{ $increment }}</td>
                        <td>{{ $adminView->admin_name }}</td>
                        <td>{{ $adminView->email }}</td>
                        <td>{{ date('D-M-Y', strtotime($adminView->created_at)) }}</td>
                        <td>
                          @if ($adminView->status == 1)
                            <a href="{{ url('/unactivate_account/'.$adminView->id) }}" class="btn btn-warning">Unactivate</a>
                          @else
                              <a href="{{ url('/activate_account/'.$adminView->id) }}" class="btn btn-success">Activate</a>
                          @endif
                            <a href="{{ url('/delete_admin/'.$adminView->id) }}" id="delete" class="btn btn-danger" ><i class="nav-icon fas fa-trash"></i></a>
                          </td>
                      </tr>
                      {{Form::hidden('', $increment += 1)}}
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Number</th>
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Date</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- DataTables -->
    <script src="public/backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="public/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="public/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="public/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="public/backend/dist/js/adminlte.min.js"></script>

    <script src="public/backend/dist/js/bootbox.min.js"></script>
    <!-- page script -->

    <script>
    $(document).on("click", "#delete", function(e){
    e.preventDefault();
    var link = $(this).attr("href");
    bootbox.confirm("Do you really want to delete this element ?", function(confirmed){
        if (confirmed){
            window.location.href = link;
        };
        });
    });
    </script>
    <!-- page script -->
    <script>
    $(function () {
        $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
        });
        $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        });
    });
    </script>
@endsection