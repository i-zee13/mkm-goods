<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,700,800" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css?v=1.0">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    @if($controller !== "Products")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @endif
    <link rel="stylesheet" type="text/css" href="/css/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/css/select2-bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="/css/dropify.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/dropzone.css" />
    <link rel="stylesheet" type="text/css" href="/css/datepicker.css?v=1.1" />
    <link rel="stylesheet" type="text/css" href="/css/timepicker.css?v=1.1" />
    <style>
        /* body {
            display: none
        } */

        #notifDiv {
            display: none;
            background: red;
            color: white;
            font-weight: 400;
            font-size: 15px;
            width: 350px;
            position: fixed;
            top: 80%;
            left: 10%;
            z-index: 10000;
            padding: 10px 20px
        }

        #addMoreProductsInOrder:hover {
            color: white !important
        }

        #product-cl-sec {
            box-shadow: 0px 0px 100px 0px rgba(0, 0, 0, 0.5);
        }

        .overlay-for-sidebar {
            display: none;
            position: fixed;
            width: 100vw;
            height: 100vh;
            z-index: 998;
            opacity: 0;
        }

        /* .select2 {
            width: 100% !important;
            z-index: 999
        } */

        .dz-image img {
            width: 100%;
            height: 100%;
        }

        .peventsDisabled {
            pointer-events: none
        }

        .datepicker-dropdown {
            z-index: 1060 !important;
        }

        #repDelayBtn:hover,
        #addProdBtn:hover,
        #markComplBtn:hover {
            color: white !important
        }
        .select2{
            width: 100% !important;
        }
    </style>

    <link href="/css/wizard.css" rel="stylesheet" type="text/css" />
    <link href="/css/jquery.steps.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/selectize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css?v=7.1">
    <link rel="stylesheet" type="text/css" href="/css/menu.css?v=6.4" />
    <link rel="stylesheet" type="text/css" href="/css/product.css?v=8.1" />
    <link rel="stylesheet" type="text/css" href="/css/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" href="/css/animate.css">
  
</head>

<body id="page-top">

    <div id="notifDiv">
    </div>

    <button class="notAllowedError" style="display: none" data-toggle="modal"
        data-target=".supplierProductAssignmentModal"></button>

    @include('includes.modals')
    <div id="wrapper">
        @if (explode('/',Request::path())[0] != 'CompletedOrderDetail')
        @include('includes.nav-new')
        @endif
        <div id="content-wrapper">
            <div class="overlay-blure"></div>
            <div class="overlay-for-sidebar" style="display: none"></div>
            @include('includes.alerts')
            <div class="container {{Request::path() == 'dashboard' ? 'container-1240 _dashboard' : ''}}">
                <div class="md-header-fixed">
                    <div class="MD__Logo"><img src="images/Sourcecode-Academia-BE-l.jpg" alt="" /></div>
                    <button class="mobile__toggler" id="modalShow"><span></span></button>
                </div>
                @yield('data-sidebar')
                <div id="contentContainerDiv" class="blur-div">
                    @yield('content')
                </div>
            </div>
            @include('includes.footer')
        </div>
    </div>


    {{--<script src="/js/jquery-3.3.1.slim.min.js"></script>--}}
    <script src="/js/jquery-3.3.1.min.js"></script> 
     <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ url('ckfinder/ckfinder.js') }}"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/datatables.min.js"></script>
    <script src="/js/select2.min.js"></script>
    <script src="/js/dropify.min.js"></script>
    <script src="/js/custom.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/selectize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="/js/jquery.mCustomScrollbar.min.js"></script>

    <script src="/js/bootstrap-datepicker.js?v=1.1"></script>
    <!-- <script src="/js/time_picker.js?v=1.1"></script>  -->
    <script src="/js/time-picker-bootstrap.js?v=1.1"></script>
    <script src="/js/time-picker-movement.js?v=1.1"></script>

    <script src="/js/dropzone.js"></script>
    <script src="/js/AudioPlayer.js?v=1.0"></script>
    @if($controller == "Correspondence")
    <script src="/js/chart.bundle.min.js"></script>
    <script src="/js/chartjs.js"></script>
    <script src="/js/echarts-en.min.js"></script>
    <script src="/js/echarts-liquidfill.min.js"></script>
    <script src="/js/jquery.nestable.js"></script>
    <script src="/js/dashboard-data.js?v=3.1"></script>
    @elseif($controller == "DashboardController")
    <script src="/js/chart.bundle.min.js"></script>
    <script src="/js/chartjs.js"></script>
    <script src="/js/echarts-en.min.js"></script>
    <script src="/js/echarts-liquidfill.min.js"></script>
    <script src="/js/jquery.nestable.js"></script>
    <script src="/js/dashboard-main.js?v=3.0"></script>
    @endif

    {{--    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>--}}
    <!-- <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.33/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 

    <script>
        var rightsGiven = JSON.parse('{!! json_encode($userPermissions) !!}');
        var userDesignation = JSON.parse('{!! $designation->pnl_access !!}');
        var allControllersData = JSON.parse('{!! json_encode($allControllers) !!}');
        var controller = '{!! $controller !!}';
        var controllerAction = '{!! $action !!}';
        var currentSegment = '{!! Request::segment(1) !!}';
        var csrfToken = $('[name="csrf_token"]').attr('content');
        var loggedInUser =
            '{!! json_encode(["user_id" => Auth::user()->id, "name" => Auth::user()->name, "picture" => Auth::user()->picture]) !!}';
        loggedInUser = JSON.parse(loggedInUser);
        //$(".sortable").sortable();



    </script>

    <script src="/js/master.js?v={{ time() }}"></script>

    <script src="/js/custom/nav.js?v=1.2.0"></script>

    @stack('js')
    

</body>

</html>
