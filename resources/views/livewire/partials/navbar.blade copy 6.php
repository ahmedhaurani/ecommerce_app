<header class="bg-white shadow-md dark:bg-gray-800" x-data="{ openMenu: false, openCategory: false }">
    <!-- Top Bar with Contact and Social Media -->
    <div class="bg-red-600 text-white py-1 px-4">
        <div class="max-w-[85rem] mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4 rtl:space-x-reverse text-sm">
                <span>التوصيل مجاني داخل بغداد و ٥ الاف لباقي محافظات العراق</span>
            </div>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                <a href="mailto:contact@example.com" class="hover:text-gray-200">📧</a>
                <a href="#" class="hover:text-gray-200">📞</a>
                <a href="#" class="hover:text-gray-200">🌐</a>
            </div>
        </div>
    </div>

    <!-- Main Navbar -->
    <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8 py-2 flex items-center justify-between">
        <!-- Logo Section -->
        <div class="flex items-center">
            <a href="/" class="text-xl font-semibold dark:text-white">iQprotein</a>
        </div>

        <!-- Centered, Larger Search Bar -->
        <div class="hidden md:flex items-center mx-auto w-full max-w-2xl">
            <!-- Use the Livewire ProductSearch component for live search -->
            <livewire:product-search />
        </div>

        <!-- Quick Access Buttons Section -->
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <!-- Cart Icon -->
            <a wire:navigate class="font-medium flex items-center {{ request()->is('cart') ? 'text-blue-600' : 'text-gray-500' }} hover:text-gray-400 py-3 md:py-6 dark:text-gray-400 dark:hover:text-gray-500 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                href="/cart">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="flex-shrink-0 w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">{{$total_count}}</span>
            </a>

            <!-- Login Icon -->
            <a href="/login" class="bg-blue-700 text-white p-3 rounded-full hover:bg-blue-800 flex items-center justify-center transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.485 2 2 6.485 2 12c0 5.515 4.485 10 10 10s10-4.485 10-10C22 6.485 17.515 2 12 2zm0 18c-4.411 0-8-3.589-8-8 0-4.412 3.589-8 8-8s8 3.588 8 8c0 4.411-3.589 8-8 8zm1-10v-2h-2v2H7v2h4v2h2v-2h4v-2h-4z" />
                </svg>
            </a>

            <!-- Language Switcher -->
            <div class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] md:py-4">
                <button type="button"
                    class="flex items-center w-full text-gray-500 hover:text-gray-400 font-medium dark:text-gray-400 dark:hover:text-gray-500">
                    Languages
                    <svg class="ms-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-48 hidden z-10 bg-white md:shadow-md rounded-lg p-2 dark:bg-gray-800 md:dark:border dark:border-gray-700 dark:divide-gray-700 before:absolute top-full md:border before:-top-5 before:start-0 before:w-full before:h-5">
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        href="{{ route('lang.switch', ['locale' => 'ar']) }}">
                        Arabic
                    </a>
                    <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                        href="{{ route('lang.switch', ['locale' => 'en']) }}">
                        English
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <button @click="openMenu = !openMenu" class="md:hidden flex items-center p-2 rounded-md text-gray-800 dark:text-white">
                <svg x-show="!openMenu" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg x-show="openMenu" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18" />
                    <path d="M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu and Categories (Vertical List) -->
    <div :class="{'hidden': !openMenu, 'block': openMenu}" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:hidden"
        x-show="openMenu">
        <!-- Categories Navbar for Mobile (Vertical List) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-2">
            <div class="max-w-[85rem] mx-auto px-4">
                <div class="flex flex-col gap-2">
                    @foreach($categories as $category)
                    <div x-data="{ openSub: false }" class="relative group">
                        <a @click.prevent="openSub = !openSub" href="{{ route('category.products', ['slug' => $category->slug]) }}"
                            class="font-medium text-gray-700 dark:text-gray-300 hover:text-blue-700 flex items-center">
                            {{ $category->getTranslatedName(app()->getLocale()) }}
                            @if($category->children->isNotEmpty())
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                            </svg>
                            @endif
                        </a>
                        @if($category->children->isNotEmpty())
                        <div x-show="openSub" @click.away="openSub = false"
                            class="mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg py-2" x-transition>
                            @foreach($category->children as $subcategory)
                            <a href=""
                                class="block px-4 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ $subcategory->getTranslatedName(app()->getLocale()) }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="bg-white dark:bg-gray-900 p-4">
            <livewire:product-search />
        </div>
    </div>
</header>
