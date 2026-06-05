@extends('app.layouts.public')

@section('title', 'FAQ Gensen')

@section('content')
    <main>
    <div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: `Faq’s`}">
            <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName">Faq’s</h2>
                <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="index.html">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName">Faq’s</li>
                </ol>
                </nav>
            </div>
        </div>
        <!-- Breadcrumb End -->
        <div class="space-y-5 sm:space-y-6">
            
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Faq’s 2
                </h3>
                </div>
                <div class="border-t border-gray-100 p-4 sm:p-6 dark:border-gray-800">
                <!-- FAQ Two -->
                <div x-data="{ openItem: 1 }" class="gap-y- gird-cols-1 grid gap-x-8 xl:grid-cols-2">
                    <div class="space-y-3">
                        <!-- item 1 -->
                        <div x-data="{ id: 1 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 1, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 1 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 1, 'text-gray-800 dark:text-white/90': openItem !== 1 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Do I get free updates?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 1, 'text-gray-500 dark:text-gray-400': openItem !== 1 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 1">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 1" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 1" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FAQ Two -->
                </div>
            </div>
        </div>
    </div>
    </main>
@endsection