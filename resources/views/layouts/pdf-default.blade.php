<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title> AcmEv </title>
    <meta name="description" content="AcmEv">
    <meta name="author" content="Group 16 - D&P Universidad de Sevilla">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- #CSS Links -->

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Custom css -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{asset('css/custom.css')}}">

    <style>
        .page-break {
            page-break-after: always;
        }
    </style>

    @yield('styles')

</head>
<body>
<div class="container">

    @yield('content')

</div>
</body>