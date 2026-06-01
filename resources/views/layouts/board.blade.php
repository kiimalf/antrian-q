<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        @include('layouts.style-global')
        @yield('style-page')
    </head>
    
    <body style="background-color: var(--bg-base); min-height: 100vh; overflow-y: auto;">
        @yield('content')
        
        @include('layouts.script-global')
        @yield('script-page')
    </body>
</html>
