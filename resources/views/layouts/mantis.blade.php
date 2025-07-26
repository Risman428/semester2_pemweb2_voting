
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Aplikasi Voting</title>
  <!-- [Meta] -->
  <x-meta />
  <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<x-sidebar />
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<x-header />
<!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      {{-- <x-breadcrumbs /> --}}
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success" id="success-alert" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @elseif (session('warning'))
            <div class="container">
                <div class="alert alert-warning" id="warning-alert" role="alert">
                    {{ session('warning') }}
                </div>
            </div>
        @endif
        

        @yield('content')
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <x-footer />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#table');
            $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
            $("#warning-alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#warning-alert").slideUp(500);
            });
        });
    </script>


  {{-- Apert Chart --}}
  <script src="{{ asset('template/dist/assets/js/apexcharts.min.js') }}"></script>
  <!-- [Page Specific JS] start -->
  <!-- Bootstrap 5 JS (Wajib untuk Dropdown, Collapse, Modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- [Page Specific JS] end -->
  <!-- Required Js -->
  <script src="{{ asset('template/dist') }}/assets/js/plugins/popper.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/fonts/custom-font.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/pcoded.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/feather.min.js"></script>

  
  
  
  
  <script>layout_change('light');</script>
  
  
  
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>
  
    
@include('sweetalert::alert')
</body>
<!-- [Body] end -->

</html>