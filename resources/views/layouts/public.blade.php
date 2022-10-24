<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('images/frontend/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('images/frontend/favicon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,400;1,500;1,600&display=swap"
    rel="stylesheet" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/frontend_css/datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_css/style.css') }}" rel="stylesheet">
    <link rel="{{ asset('stylesheet" href="css/animate.css') }}">
    <script src="{{ asset('js/frontend_js/jquery-3.4.0.min.js') }}"></script>
    
    <style>
      .disable-click{
        pointer-events:none;
      }
      .enable-click{
        cursor: pointer;
      }
      #notifDiv {
            display: none;
            background: red;
            color: white;
            font-weight: 400;
            font-size: 15px;
            width: 330px;
            position: fixed;
            top: 70%;
            left: 73%;
            z-index: 10000;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
  @include('includes.modals-web')
  <div id="notifDiv">
  </div>
    <div class="content-wrapper">
        <div class="w-section bg-gray BGP email-section">
          <div class="email-header">
            <div class="container">
              <div class="row">
                <div class="col-auto pl-0"><a href="#"><img class="e-logo" alt="" src="{{ asset('images/Sourcecode-Academia-BE-l.jpg') }}"></a>
                </div>
                <div class="col email-phone pr-0"><i class="fa fa-phone"></i> (+1) 647-643-5426</div>
              </div>
            </div>
          </div>
          <div class="container">
              @yield('content')      
          </div>
        </div>
        @include('includes.footer-web')
    </div>
    {{-- Js Files --}}
    
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/frontend_js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/frontend_js/select2.min.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('js/form-file-upload-data.js') }}"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}"></script>
    <script src="{{ asset('js/frontend_js/wow.js') }}"></script>
    {{-- Custom JS --}}
    <script>
      document.querySelector("#nav-toggle")
      .addEventListener("click", function () {
        this.classList.toggle("active");
      });
      $(document).ready(function () {
        $('.navbar-dark .dmenu, .top_nav .dmenu').hover(function () {
          $(this).find('.sm-menu').first().stop(true, true).slideDown(180);
        }, function () {
          $(this).find('.sm-menu').first().stop(true, true).slideUp(100)
        });
      });
      Headerfix = document.getElementById("topHeader");
      var myScrollFunc = function () {
        var y = window.scrollY;
        if (y >= 250) {
            topHeader.className = "topheader n-hiden"
          } else {
            topHeader.className = "topheader n-show"
          }
        };
        window.addEventListener("scroll", myScrollFunc);
        $('.form-control').on('focus blur', function (e) {
          $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
        $('._datepicker').datepicker({
          format: 'mm-dd-yyyy'
        });
        wow = new WOW(
          {
            animateClass: 'animated',
            offset: 50,
            callback: function (box) {
              console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        }
        );
        wow.init();  
        </script>
    <script>
    $(document).ready(function(){
      $(".formselect").select2();
      $(".formselect").select2({width: '100%'});
      
      $("#datepicker").datepicker({
        format: "yyyy-mm-dd",
      }).on('changeDate', function(e) {
        $(this).datepicker('hide');
      }); 
    })  
    </script>
    <script src="{{asset('js/custom/intake-form-frontend.js')}}"></script>
    @stack('js')
  </body>
  </html>
  