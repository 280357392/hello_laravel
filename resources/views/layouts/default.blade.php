<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Weibo App') - Laravel</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
@include('layouts._header')

<div class="container">
    {{--消息提醒视图--}}
    @include('shared._messages')
    @yield('content')
</div>

<div class="container">
    @include('layouts._footer')
</div>
</body>
</html>