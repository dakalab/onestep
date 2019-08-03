<head>
    <meta charset="UTF-8">
    <title> @yield('htmlheader_title', 'Modern shopping cart') - {{ strip_tags(\Setting::getValue('site_name')) }}</title>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    <link href="{{ mix('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ mix('/css/web.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/plugins/select2/css/select2-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" >

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
    .navbar-default {
        background-color: #fff;
        border-color: #fff;
    }
    .table-cell {
        border: 1px solid #f4f4f4;
        padding: 8px;
        vertical-align: top;
        display: table-cell;
    }
    .logo-lg {
        {{ \Setting::getValue('logo_style') }}
    }
    @media (max-width: 768px) {
        .logo-lg {
            max-height:25px;
        }
    }
    </style>

    <script>
        window.trans = @php
            $lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
            $trans = [];
            foreach ($lang_files as $f) {
                $filename = pathinfo($f)['filename'];
                $trans[$filename] = trans($filename);
            }
            $trans['adminlte_lang_message'] = trans('adminlte_lang::message');
            echo json_encode($trans);
        @endphp
    </script>

    @if (config('google.aw'))
    <!-- Google Analytics and AdWords -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={!! config('google.aw') !!}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{!! config('google.aw') !!}');

    @if (config('google.ua'))
    gtag('config', '{!! config('google.ua') !!}');
    @endif

    gtag('event', 'conversion', {
        'send_to': '{!! config('google.aw') !!}/{!! config('google.cv') !!}',
        'transaction_id': ''
    });
    </script>
    @endif

    @if (config('google.tag'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{!! config('google.tag') !!}');</script>
    <!-- End Google Tag Manager -->
    @endif

</head>
