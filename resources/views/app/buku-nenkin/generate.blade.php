<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>J-Expert</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700;800&amp;family=Inter:wght@300;400;500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
          <script id="tailwind-config">
         tailwind.config = {
           darkMode: "class",
           theme: {
             extend: {
               "colors": {
                       "error-container": "#ffdad6",
                       "tertiary": "#633500",
                       "on-primary-fixed-variant": "#134688",
                       "surface-bright": "#f8f9fb",
                       "surface-container": "#eceef0",
                       "on-secondary-fixed": "#001d36",
                       "on-error": "#ffffff",
                       "error": "#ba1a1a",
                       "surface-container-highest": "#e0e3e5",
                       "on-primary": "#ffffff",
                       "on-tertiary": "#ffffff",
                       "surface-container-lowest": "#ffffff",
                       "on-tertiary-container": "#ffc28d",
                       "secondary": "#46607f",
                       "on-surface-variant": "#434750",
                       "on-surface": "#191c1e",
                       "on-secondary-container": "#455f7d",
                       "secondary-fixed": "#d1e4ff",
                       "primary": "#063f81",
                       "inverse-primary": "#abc7ff",
                       "on-secondary": "#ffffff",
                       "tertiary-fixed-dim": "#ffb877",
                       "secondary-container": "#bfd9fd",
                       "surface": "#f8f9fb",
                       "surface-container-high": "#e6e8ea",
                       "secondary-fixed-dim": "#aec9ec",
                       "surface-dim": "#d8dadc",
                       "primary-container": "#2b579a",
                       "surface-container-low": "#f2f4f6",
                       "on-primary-container": "#b7cfff",
                       "surface-tint": "#335ea1",
                       "inverse-surface": "#2d3133",
                       "surface-variant": "#e0e3e5",
                       "on-tertiary-fixed": "#2e1600",
                       "on-tertiary-fixed-variant": "#6c3a00",
                       "outline-variant": "#c3c6d2",
                       "inverse-on-surface": "#eff1f3",
                       "on-error-container": "#93000a",
                       "on-primary-fixed": "#001b3f",
                       "on-background": "#191c1e",
                       "outline": "#737782",
                       "primary-fixed-dim": "#abc7ff",
                       "on-secondary-fixed-variant": "#2e4966",
                       "background": "#f8f9fb",
                       "tertiary-container": "#844900",
                       "primary-fixed": "#d7e3ff",
                       "tertiary-fixed": "#ffdcc1"
               },
               "borderRadius": {
                       "DEFAULT": "0.125rem",
                       "lg": "0.25rem",
                       "xl": "0.5rem",
                       "full": "0.75rem"
               },
               "fontFamily": {
                       "headline": ["Public Sans"],
                       "body": ["Inter"],
                       "label": ["Inter"]
               }
             },
           },
         }
      </script>

   
    
    @stack('css')
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary-container selection:text-white">
        <!-- Watermark -->
    <div class="max-w-5xl w-full">
            <!-- Document Header Section -->
            <header class="mb-10 space-y-4">
                <div class="flex items-center gap-4 text-black text-center justify-center">
                <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                    Data Pemohon Bagi Yang Tidak Punya Buku Nenkin
                </h1>
                </div>
                <div class="flex items-center gap-4 text-black text-center justify-center">   
                <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                    履歴（公的年金制度加入経過）
                </h1>
                </div>
                <div class="flex items-center gap-4 text-black text-center justify-center">   
                <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                    できるだけくわしく、正確に記入してください。
                </h1>
                </div>
                <div class="flex items-center gap-4 text-black text-center justify-center">   
                <h1 class="font-headline text-3xl font-extrabold tracking-tight uppercase text-center">
                    歴（公的年金制度加入経過）
                </h1>
                </div>
            </header>
            <livewire:buku-nenkin.generate :objId="$objId" />
        </div>
</body>

    {{-- JAVASCRIPT --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @stack('js')
</body>

</html>
