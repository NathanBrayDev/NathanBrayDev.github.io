<!doctype html>

<!-- HTML5 Boilerplate -->
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"><!--<![endif]-->

<head>
    
    <meta charset="utf-8">
    
    {{-- <title>{{ seo()->title }} | {{ env('site') }}</title> --}}
    

    @props(['page'])
        
    {!! seo()->for($page) !!}

    @yield('extra_styles')

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @livewireStyles
    @cookieconsentscripts
</head>


<body class="body {{ ($page->slug<>"/")?$page->slug:"homepage" }}">

    <header>
        <div class="row">
            <div class="container">
                <h1>Header</h1>
            </div>
        </div>
    </header>

    <main class="page-content">
        @yield('content')    
    </main>

    <footer class="page-footer">

        <div class="row">
            <div class="container">
                <h2>Footer</h2>
            </div>
        </div>

        

    </footer><!-- / page-footer 000 -->


    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_ID') }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '{{ env('GOOGLE_ANALYTICS_ID') }}');
    </script>
    
    @yield('extra_scripts')
    @livewireScripts
    @cookieconsentview
</body>
</html>







{{-- <x-filament-fabricator::layouts.base :title="$page->title"> --}}
    {{-- Header Here --}}



     {{-- Footer Here --}}
{{-- </x-filament-fabricator::layouts.base> --}}