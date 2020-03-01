<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Saridharma</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('adminlte\air-datepicker\dist\css\datepicker.css')}}">
  
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link href="{{url('/adminlte/zed/css/fullcalendar.css')}}" rel='stylesheet' />
  <link rel="stylesheet" href="{{url('/adminlte/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('/adminlte/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{url('/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-yellow-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>K</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Klinik</b> B.2.0</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
         
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('/adminlte/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{auth()->user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('adminlte/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                <p>
                 {{auth()->user()->name}}
                  <small>{{auth()->user()->email}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{url('/logout')}}" class="btn btn-default btn-flat">logout</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/adminlte/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{auth()->user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{nama_lokasi()}}</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/unit')}}"><i class="fa fa-circle-o"></i> Unit</a></li>
            <li><a href="{{url('/pendapatan')}}"><i class="fa fa-circle-o"></i> Pendapatan</a></li>
             <li><a href="{{url('/statistik')}}"><i class="fa fa-circle-o"></i> statistik</a></li>
              <li><a href="{{url('/survie')}}"><i class="fa fa-circle-o"></i> survei</a></li>
          </ul>
        </li>
        @if(auth()->user()->role == 'admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/tindakan')}}"><i class="fa fa-circle-o"></i>Tindakan</a></li>
            <li><a href="{{url('/itemmedis')}}"><i class="fa fa-circle-o"></i>Item Obat</a></li>
            <li><a href="{{url('/suplier')}}"><i class="fa fa-circle-o"></i>Suplier</a></li>
            <li><a href="{{url('/suplier/maping')}}"><i class="fa fa-circle-o"></i>Suplier Maping</a></li>
          </ul>
        </li>
        @endif

        @if(auth()->user()->role == 'admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-address-book"></i>
            <span>Master Manajemen</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/lokasi')}}"><i class="fa fa-circle-o"></i>Lokasi/Unit Cabang</a></li>
              <li><a href="{{url('/poli')}}"><i class="fa fa-circle-o"></i>Poli/Ruangan</a></li>
            <li><a href="{{url('/asuransi')}}"><i class="fa fa-circle-o"></i>Asuransi</a></li>
            <li><a href="{{url('/rujukan')}}"><i class="fa fa-circle-o"></i>Rujukan</a></li>
            <li><a href="{{url('/faskes')}}"><i class="fa fa-circle-o"></i>Faskes</a></li>
            <li><a href="{{url('/gudang')}}"><i class="fa fa-circle-o"></i>Gudang/Store</a></li>
          </ul>
        </li>
        @endif

         @if(auth()->user()->role == 'admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-circle-o"></i>
            <span>Master SDM</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/karyawan')}}"><i class="fa fa-circle-o"></i>Karyawan</a></li>
              <li><a href="{{url('/dokter')}}"><i class="fa fa-circle-o"></i>Dokter</a></li>
            <li><a href="{{url('/perawat')}}"><i class="fa fa-circle-o"></i>Perawat</a></li>
            <li><a href="{{url('/staff')}}"><i class="fa fa-circle-o"></i>Staff</a></li>
            <li><a href="{{url('/user')}}"><i class="fa fa-circle-o"></i>User Login</a></li>
            <li><a href="{{url('/user/maping')}}"><i class="fa fa-circle-o"></i>User Maping</a></li>
          </ul>
        </li>
        @endif
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Registrasi Rawat Jalan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/pasien/create')}}"><i class="fa fa-circle-o"></i>Pasien Baru</a></li>
            <li><a href="{{url('/pendaftaran')}}"><i class="fa fa-circle-o"></i>Pasien Lama</a></li>
            <li><a href="{{url('/pasien')}}"><i class="fa fa-circle-o"></i>Data Pasien</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user-md"></i>
            <span>Pemeriksaan Pasien</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/registrasi/rawat_jalan')}}"><i class="fa fa-circle-o"></i>Rawat Jalan</a></li>
            <li><a href="{{url('/registrasi/rawat_jalan')}}"><i class="fa fa-circle-o"></i>Rawat Inap</a></li>
            <li><a href="{{url('/registrasi/ugd')}}"><i class="fa fa-circle-o"></i>UGD</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Pembayaran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('/pembayaran')}}"><i class="fa fa-circle-o"></i>Open Kas</a></li>
            <li><a href="{{url('/payment')}}"><i class="fa fa-circle-o"></i>Pembayaran</a></li>
             <li><a href="{{url('/pembayaran/rekap')}}"><i class="fa fa-circle-o"></i>Closing Kas</a></li>
           
           <!-- 
            <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li> -->
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Inventory Farmacy</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('suplier/maping')}}"><i class="fa fa-circle-o"></i>Maping Suplier</a></li>
            <li><a href="{{url('pembelian')}}"><i class="fa fa-circle-o"></i>Pembelian</i></a></li>
            <li><a href="{{url('penerimaan')}}"><i class="fa fa-circle-o"></i>Penerimaan</a></li>
            <li><a href="{{url('retur')}}"><i class="fa fa-circle-o"></i>Retur</a></li>
            <li><a href="{{url('kartustok')}}"><i class="fa fa-circle-o"></i>Kartu Stok</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Pembukuan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('Kas')}}"><i class="fa fa-circle-o"></i>Kas</a></li>
            <li><a href="{{url('jurnalumum')}}"><i class="fa fa-circle-o"></i>Jurnal Umum</a></li>
            <li><a href="{{url('jurnalkhusus')}}"><i class="fa fa-circle-o"></i>Jurnal Khusus</a></li>
            <li><a href="{{url('jurnalpenyesuaian')}}"><i class="fa fa-circle-o"></i>Jurnal Penyesuaian</a></li>
            <li><a href="{{url('labarugi')}}"><i class="fa fa-circle-o"></i>Laba/Rugi</a></li>
            <li><a href="{{url('neraca')}}"><i class="fa fa-circle-o"></i>Neraca</a></li>
          
            </ul>
        </li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.1.0
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="#">klinikbersama.id</a>.</strong>All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="{{url('/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{url('/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- bootstrap datepicker -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{url('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<!-- jQuery 3 -->
<script src="{{url('/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{url('/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{url('/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/adminlte/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/adminlte/js/demo.js')}}"></script>
<!-- DataTables -->
<script src="{{url('/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte\air-datepicker\dist\js\datepicker.js')}}"></script>
<script src="{{asset('adminlte\air-datepicker\dist\js\i18n\datepicker.en.js')}}"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
$('#dataTable1').DataTable({"bAutoWidth": false})
$('#dataTableDashboard1').DataTable({
"order": [[ 0, "desc" ]],
"lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
"searching": false,
"bLengthChange": false
});

$('#idSiswa').select2({placeholder: "Pilih Siswa...", width: '100%'});
$('#idGuru').select2({placeholder: "Pilih Guru...", width: '100%'});
$('#idKelas').select2({placeholder: "Pilih Kelas...", width: '100%'});
$('#idPraktek').select2({placeholder: "Pilh Lokasi...", width: '100%'});

$('#date').datepicker({
  autoclose: true,
  locale: 'no',
  format: 'yyyy-mm-dd',
})
$('#datepicker1').datepicker({
  autoclose: true,
  locale: 'no',
  format: 'yyyy-mm-dd',
})
$('#datepickerNow').datepicker('setDate', 'today');
$('#datepickerNow1').datepicker('setDate', 'today');

</script>

</body>
</html>
