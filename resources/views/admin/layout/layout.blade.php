<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Starter</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('adminLTE/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminLTE/dist/css/adminlte.min.css')}}">
   <!-- Toastr -->
   <link rel="stylesheet" href="{{asset('adminLTE/plugins/toastr/toastr.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('adminLTE/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('adminLTEplugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  @include('admin.layout.components.header')

    <!-- SEARCH FORM -->
 @include('admin.layout.components.searchform')

    <!-- Right navbar links -->
   {{-- @include('admin.layout.components.rightnavbar') --}}
   
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 @include('admin.layout.components.main-sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 @yield('content')
  <!-- /.content-wrapper -->
  </div>
  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
 @include('admin.layout.components.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('adminLTE/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('adminLTE/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('adminLTE/plugins/toastr/toastr.min.js')}}"></script>

@stack('custom-js')
</body>
</html>
