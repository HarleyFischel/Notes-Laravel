<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notes - @yield('title')</title>

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            margin:0;
        }
        .header {
            position:fixed;
            top:0;
            background:rgba(0,0,0,.7);
            color:#FFF;
            height:45px;
            width:100%;
        }
        .header .title {
            margin:10px;
            float:left;
        }
        .header .nav {
            list-style: none;
            float:right;
        }
        .header .nav li {
            border-radius:20px;
            display:inline;
            margin:5px;
            padding:5px 20px;
        }
        .header .nav li a {
            color:#FFF;
            text-decoration: none;
        }
        .header .nav li:hover {
            background-color:rgba(0,0,122,.7);
        }
        .link {
            cursor:pointer;
        }
        .container li:hover {
            color:#559;
        }
        .container {
            margin:10px;
            margin-top:65px;
        }
        .container .notes {
            padding:0;
            list-style: none;
        }
        .container .notes li {
            margin:5px;
            padding:10px 20px;
            border:1px solid #DDD;
            border-radius:10px;
        }
        .container .notes li a {
            color:#333;
            text-decoration: none;
        }
        .container .notes li a:hover {
            color:#559;
        }
        textarea {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-size:1.0rem;
            width:100%;
            height:240px;
        }
        pre {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            white-space: pre-wrap;       /* css-3 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
    </style>
</head>
<body>
<div class="header">
@section('header')
    <h2 class="title">My Notes</h2>
@show
</div>

<div class="container">
    @yield('content')
</div>
</body>
</html>
@stack('scripts')