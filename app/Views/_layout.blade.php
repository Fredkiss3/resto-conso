<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title> @yield('title', 'Accueil') - GI-IHPHB Resto</title>
    <meta name="description" content="Introduction"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui"
    />
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    <!-- base css -->

    {!! link_tag('css/vendors.bundle.css') !!}
    {!! link_tag('css/app.bundle.css') !!}
    {!! link_tag('img/logo.png', 'icon', 'image/x-icon') !!}
    {!! link_tag("css/notifications/toastr/toastr.css") !!}
    {!! link_tag("css/theme-demo.css") !!}
    {!! link_tag('css/datagrid/datatables/datatables.bundle.css') !!}
    {!! link_tag('css/fa-solid.css') !!}
    {!! link_tag('css/formplugins/select2/select2.bundle.css') !!}
    {!! link_tag('css/fa-brands.css') !!}

    <style>
        .select2-dropdown {
            z-index: 5000;
        }
    </style>

    @yield('after-css')

</head>
<body>

<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
    <div class="page-inner">
        @yield('menu')

        <div class="page-content-wrapper">
        @yield('body')

        <!-- BEGIN Color profile -->
            <!-- this area is hidden and will not be seen on screens or screen readers -->
            <!-- we use this only for CSS color refernce for JS stuff -->
            <p id="js-color-profile" class="d-none">
                <span class="color-primary-50"></span>
                <span class="color-primary-100"></span>
                <span class="color-primary-200"></span>
                <span class="color-primary-300"></span>
                <span class="color-primary-400"></span>
                <span class="color-primary-500"></span>
                <span class="color-primary-600"></span>
                <span class="color-primary-700"></span>
                <span class="color-primary-800"></span>
                <span class="color-primary-900"></span>
                <span class="color-info-50"></span>
                <span class="color-info-100"></span>
                <span class="color-info-200"></span>
                <span class="color-info-300"></span>
                <span class="color-info-400"></span>
                <span class="color-info-500"></span>
                <span class="color-info-600"></span>
                <span class="color-info-700"></span>
                <span class="color-info-800"></span>
                <span class="color-info-900"></span>
                <span class="color-danger-50"></span>
                <span class="color-danger-100"></span>
                <span class="color-danger-200"></span>
                <span class="color-danger-300"></span>
                <span class="color-danger-400"></span>
                <span class="color-danger-500"></span>
                <span class="color-danger-600"></span>
                <span class="color-danger-700"></span>
                <span class="color-danger-800"></span>
                <span class="color-danger-900"></span>
                <span class="color-warning-50"></span>
                <span class="color-warning-100"></span>
                <span class="color-warning-200"></span>
                <span class="color-warning-300"></span>
                <span class="color-warning-400"></span>
                <span class="color-warning-500"></span>
                <span class="color-warning-600"></span>
                <span class="color-warning-700"></span>
                <span class="color-warning-800"></span>
                <span class="color-warning-900"></span>
                <span class="color-success-50"></span>
                <span class="color-success-100"></span>
                <span class="color-success-200"></span>
                <span class="color-success-300"></span>
                <span class="color-success-400"></span>
                <span class="color-success-500"></span>
                <span class="color-success-600"></span>
                <span class="color-success-700"></span>
                <span class="color-success-800"></span>
                <span class="color-success-900"></span>
                <span class="color-fusion-50"></span>
                <span class="color-fusion-100"></span>
                <span class="color-fusion-200"></span>
                <span class="color-fusion-300"></span>
                <span class="color-fusion-400"></span>
                <span class="color-fusion-500"></span>
                <span class="color-fusion-600"></span>
                <span class="color-fusion-700"></span>
                <span class="color-fusion-800"></span>
                <span class="color-fusion-900"></span>
            </p>
            <!-- END Color profile -->
        </div>
    </div>
</div>
<!-- END Page Wrapper -->

<!-- DOC: script to save and load page settings -->
{!! script_tag('js/localPref.js') !!}
{!! script_tag('js/vendors.bundle.js') !!}
{!! script_tag('js/app.bundle.js') !!}
{!! script_tag('js/notifications/toastr/toastr.js') !!}

@if(!empty($flash))
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 100,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        toastr["{{ $flash['type']}}"]("{{$flash['message']}}");
    </script>
@endif


{!! script_tag('js/datagrid/datatables/datatables.bundle.js') !!}
{!! script_tag('js/datagrid/datatables/datatables.export.js') !!}
{!! script_tag('js/formplugins/select2/select2.bundle.js') !!}

<script>
    $(document).ready(function () {
        $(function () {
            $('.select2').select2();
        });

    });

</script>

@yield('after-js')
</body>
</html>
