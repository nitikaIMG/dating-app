<!DOCTYPE html>

<html class="no-js" lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="Minaati is a bootstrap minimal & clean admin template">
        <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, admin theme, bootstrap 4, responsive, sass support, ui kits, crm, ecommerce">
        <meta name="author" content="Themesbox17">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Minaati - Bootstrap Minimal & Clean Admin Template</title>

        @include('layouts.links.style')
        @stack('custom-styles')
        <!-- End css -->
    </head>
    <body class="vertical-layout">  
        <div id="containerbar">  
            @auth
            {{-- @if(!Request::is('workspace/create'))  --}}
            {{-- <div id="main_content"> --}}
                <div>
                    @include('layouts.navbar.sidebar')
                </div>
            {{-- @endif --}}
            @endauth.

                @auth
            <div class="rightbar">
                {{-- @if(!Request::is('workspace/create'))  --}}
                {{-- <div class="page"> --}}
                    @include('layouts.navbar.navbar')
                {{-- @endif --}}
                @endauth

                    @yield('content')

                    {{-- @if(!Request::is('workspace/create'))  --}}
                    
                    <div class="section-body">
                        @include('layouts.footer.footer')
                    </div>
                    {{-- </div> --}}
                    {{-- <div> --}}
                @auth
            </div>       
                @endauth
                        {{-- @endif --}}
                

            @include('layouts.links.script')
            @stack('custom-scripts')
        </div>
    </body>
</html>