<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        @include('layouts.style-global')
        @yield('style-page')
    </head>
    
    <body>
        <div class="container-scroller">
            @include('layouts.navbar')
            <div class="container-fluid page-body-wrapper">
                <div class="main-panel no-sidebar">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                    
                </div>
            </div>
        </div>
        @include('layouts.script-global')
        @yield('script-page')
    </body>
    <footer>
        @include('layouts.footer')
    </footer>
</html>