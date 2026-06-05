@extends('app.layouts.public')

@section('title', $title)

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
                    Faq’s 1
                </h3>
                </div>
                <div class="border-t border-gray-100 p-4 sm:p-6 dark:border-gray-800">
                <!-- ====== FAQ One Start -->
                <div x-data="{ openItem: 0 }" class="space-y-4">
                    <!-- item 1 -->
                    <div x-data="{ isOpen: true }" x-init="$watch('openItem', value =&gt; isOpen = value === 0)" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div @click="openItem = openItem === 0 ? null : 0" class="flex cursor-pointer items-center justify-between py-3 pr-3 pl-6" :class="isOpen ? 'bg-gray-50 dark:bg-white/[0.03]' : ''">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            Do I get free updates?
                            </h4>
                            <button :class="isOpen ? 'text-gray-800 dark:text-white/90 rotate-180' : 'text-gray-500 dark:text-gray-400'" class="flex h-12 w-full max-w-12 items-center justify-center rounded-full bg-gray-100 duration-200 ease-linear dark:bg-white/[0.03] text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            </button>
                        </div>
                        <div x-show="isOpen" class="px-6 py-7" style="display: none;">
                            <p class="text-base text-gray-500 dark:text-gray-400">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                            magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit
                            amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                            accumsan.
                            </p>
                        </div>
                    </div>
                    <!-- item 2 -->
                    <div x-data="{ isOpen: false }" x-init="$watch('openItem', value =&gt; isOpen = value === 1)" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div @click="openItem = openItem === 1 ? null : 1" class="flex cursor-pointer items-center justify-between py-3 pr-3 pl-6" :class="isOpen ? 'bg-gray-50 dark:bg-white/[0.03]' : ''">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            Can I Customize TailAdmin to suit my needs?
                            </h4>
                            <button :class="isOpen ? 'text-gray-800 dark:text-white/90 rotate-180' : 'text-gray-500 dark:text-gray-400'" class="flex h-12 w-full max-w-12 items-center justify-center rounded-full bg-gray-100 duration-200 ease-linear dark:bg-white/[0.03] text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            </button>
                        </div>
                        <div x-show="isOpen" class="px-6 py-7" style="display: none;">
                            <p class="text-base text-gray-500 dark:text-gray-400">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                            magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit
                            amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                            accumsan.
                            </p>
                        </div>
                    </div>
                    <!-- item 3 -->
                    <div x-data="{ isOpen: false }" x-init="$watch('openItem', value =&gt; isOpen = value === 2)" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                        <div @click="openItem = openItem === 2 ? null : 2" class="flex cursor-pointer items-center justify-between py-3 pr-3 pl-6" :class="isOpen ? 'bg-gray-50 dark:bg-white/[0.03]' : ''">
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">
                            What does "Unlimited Projects" mean?
                            </h4>
                            <button :class="isOpen ? 'text-gray-800 dark:text-white/90 rotate-180' : 'text-gray-500 dark:text-gray-400'" class="flex h-12 w-full max-w-12 items-center justify-center rounded-full bg-gray-100 duration-200 ease-linear dark:bg-white/[0.03] text-gray-500 dark:text-gray-400">
                            <svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.75 8.875L12 15.125L18.25 8.875" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            </button>
                        </div>
                        <div x-show="isOpen" class="px-6 py-7" style="display: none;">
                            <p class="text-base text-gray-500 dark:text-gray-400">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                            magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit
                            amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                            accumsan.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- ====== FAQ One End -->
                </div>
            </div>
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
                        <!-- item 2 -->
                        <div x-data="{ id: 2 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 2, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 2 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 2 ? null : 2" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 2, 'text-gray-800 dark:text-white/90': openItem !== 2 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Which license type is suitable for me?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 2, 'text-gray-500 dark:text-gray-400': openItem !== 2 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 2">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 2" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 2" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                        <!-- item 3 -->
                        <div x-data="{ id: 3 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 3, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 3 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 3 ? null : 3" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 3, 'text-gray-800 dark:text-white/90': openItem !== 3 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                What are the "Seats" mentioned on pricing plans?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 3, 'text-gray-500 dark:text-gray-400': openItem !== 3 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 3">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 3" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 3" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <!-- item 4 -->
                        <div x-data="{ id: 4 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 4, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 4 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 4 ? null : 4" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 4, 'text-gray-800 dark:text-white/90': openItem !== 4 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Can I Customize TailAdmin to suit my needs?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 4, 'text-gray-500 dark:text-gray-400': openItem !== 4 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 4">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 4" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 4" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                        <!-- item 5 -->
                        <div x-data="{ id: 5 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 5, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 5 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 5 ? null : 5" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 5, 'text-gray-800 dark:text-white/90': openItem !== 5 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                What does "Unlimited Projects" mean?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 5, 'text-gray-500 dark:text-gray-400': openItem !== 5 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 5">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 5" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 5" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                        <!-- item 6 -->
                        <div x-data="{ id: 6 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 6, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 6 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 6 ? null : 6" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 6, 'text-gray-800 dark:text-white/90': openItem !== 6 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Can I upgrade to a higher plan?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 6, 'text-gray-500 dark:text-gray-400': openItem !== 6 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 6">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 6" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 6" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
                            <p class="text-base text-gray-800">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor
                                sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia
                                accumsan.
                            </p>
                            </div>
                        </div>
                        <!-- item 7 -->
                        <div x-data="{ id: 7 }" :class="{ 'bg-brand-50 dark:bg-brand-100': openItem === 7, 'bg-gray-100 dark:bg-white/[0.03]': openItem !== 7 }" class="overflow-hidden rounded-xl bg-gray-100 dark:bg-white/[0.03]">
                            <div @click="openItem = openItem === 7 ? null : 7" class="flex cursor-pointer items-center justify-between px-6 py-4">
                            <h4 :class="{ 'text-gray-800': openItem === 7, 'text-gray-800 dark:text-white/90': openItem !== 7 }" class="text-lg font-medium text-gray-800 dark:text-white/90">
                                Are there dark and light mode options?
                            </h4>
                            <button :class="{ 'text-gray-800 dark:text-gray-800': openItem === 7, 'text-gray-500 dark:text-gray-400': openItem !== 7 }" class="text-gray-500 dark:text-gray-400">
                                <span x-show="openItem !== 7">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9998C6.44772 12.9998 6 13.4475 6 13.9998C6 14.5521 6.44772 14.9998 7 14.9998V12.9998ZM21.0008 14.9998C21.5531 14.9998 22.0008 14.5521 22.0008 13.9998C22.0008 13.4475 21.5531 12.9998 21.0008 12.9998V14.9998ZM15.0003 6.99951C15.0003 6.44723 14.5526 5.99951 14.0003 5.99951C13.448 5.99951 13.0003 6.44723 13.0003 6.99951H15.0003ZM13.0003 21.0003C13.0003 21.5526 13.448 22.0003 14.0003 22.0003C14.5526 22.0003 15.0003 21.5526 15.0003 21.0003H13.0003ZM7 14.9998H21.0008V12.9998H7V14.9998ZM13.0003 6.99951V21.0003H15.0003V6.99951H13.0003Z" fill="#667085"></path>
                                    </svg>
                                </span>
                                <span x-show="openItem === 7" style="display: none;">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 12.9995C6.44772 12.9995 6 13.4472 6 13.9995C6 14.5518 6.44772 14.9995 7 14.9995V12.9995ZM21.0008 14.9995C21.5531 14.9995 22.0008 14.5518 22.0008 13.9995C22.0008 13.4472 21.5531 12.9995 21.0008 12.9995V14.9995ZM7 14.9995H21.0008V12.9995H7V14.9995Z" fill="#1D2939"></path>
                                    </svg>
                                </span>
                            </button>
                            </div>
                            <div x-show="openItem === 7" class="border-brand-100 dark:border-brand-200 border-t p-6" style="display: none;">
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
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Faq’s 3
                </h3>
                </div>
                <div class="border-t border-gray-100 p-5 sm:p-6 xl:p-10 dark:border-gray-800">
                <!-- FAQ Three -->
                <div class="gird-cols-1 grid gap-x-8 xl:grid-cols-2">
                    <div class="space-y-3 sm:space-y-5">
                        <!-- item-->
                        <div class="py-4">
                            <div class="flex items-start gap-4">
                            <div class="text-gray-700 dark:text-gray-500">
                                <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-3 text-lg font-medium text-gray-800 dark:text-white/90">
                                    Do I get free updates?
                                </h4>
                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et
                                    nunc ut risus imperdiet lacinia.
                                    <br>
                                    <br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                            </div>
                        </div>
                        <!-- divider -->
                        <div class="h-px w-full bg-gray-200 dark:bg-gray-800"></div>
                        <!-- item-->
                        <div class="py-4">
                            <div class="flex items-start gap-4">
                            <div class="text-gray-700 dark:text-gray-500">
                                <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-3 text-lg font-medium text-gray-800 dark:text-white/90">
                                    Which license type is suitable for me?
                                </h4>
                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                            </div>
                        </div>
                        <!-- divider -->
                        <div class="h-px w-full bg-gray-200 dark:bg-gray-800"></div>
                        <!-- item-->
                        <div class="py-4">
                            <div class="flex items-start gap-4">
                            <div class="text-gray-700 dark:text-gray-500">
                                <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-3 text-lg font-medium text-gray-800 dark:text-white/90">
                                    What are the "Seats" mentioned on pricing plans?
                                </h4>
                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et
                                    nunc ut risus imperdiet lacinia.
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3 sm:space-y-5">
                        <!-- item-->
                        <div class="py-4">
                            <div class="flex items-start gap-4">
                            <div class="text-gray-700 dark:text-gray-500">
                                <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-3 text-lg font-medium text-gray-800 dark:text-white/90">
                                    Can I Customize TailAdmin to suit my needs?
                                </h4>
                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et
                                    nunc ut risus imperdiet lacinia.
                                    <br>
                                    <br>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                </p>
                            </div>
                            </div>
                        </div>
                        <!-- divider -->
                        <div class="h-px w-full bg-gray-200 dark:bg-gray-800"></div>
                        <!-- item-->
                        <div class="py-4">
                            <div class="flex items-start gap-4">
                            <div class="text-gray-700 dark:text-gray-500">
                                <svg class="fill-current" width="24" height="26" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 14C3.75 9.44365 7.44365 5.75 12 5.75C16.5563 5.75 20.25 9.44365 20.25 14C20.25 18.5563 16.5563 22.25 12 22.25C7.44365 22.25 3.75 18.5563 3.75 14ZM12 3.75C6.33908 3.75 1.75 8.33908 1.75 14C1.75 19.6609 6.33908 24.25 12 24.25C17.6609 24.25 22.25 19.6609 22.25 14C22.25 8.33908 17.6609 3.75 12 3.75ZM10.7491 9.52507C10.7491 10.2154 11.3088 10.7751 11.9991 10.7751H12.0001C12.6905 10.7751 13.2501 10.2154 13.2501 9.52507C13.2501 8.83472 12.6905 8.27507 12.0001 8.27507H11.9991C11.3088 8.27507 10.7491 8.83472 10.7491 9.52507ZM12.0001 19.6214C11.4478 19.6214 11.0001 19.1737 11.0001 18.6214V12.9449C11.0001 12.3926 11.4478 11.9449 12.0001 11.9449C12.5524 11.9449 13.0001 12.3926 13.0001 12.9449V18.6214C13.0001 19.1737 12.5524 19.6214 12.0001 19.6214Z" fill=""></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="mb-3 text-lg font-medium text-gray-800 dark:text-white/90">
                                    What does "Unlimited Projects" mean?
                                </h4>
                                <p class="text-base text-gray-500 dark:text-gray-400">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis
                                    magna ac nibh malesuada consectetur at vitae ipsum. Lorem ipsum
                                    dolor sit amet, consectetur adipiscing elit. Nam fermentum, leo et
                                    lacinia accumsan, ligula ante hendrerit nisi, eget vulputate ante
                                    justo et justo.
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FAQ Three -->
                </div>
            </div>
        </div>
    </div>
    </main>
@endsection