<header class="bg-[#ECECEC] shadow-md dark:bg-gray-600" x-data="{ openMenu: false, openCategory: false }">
    <!-- Top Bar with Contact and Social Media -->
    <div class="py-2 px-4 bg-gray-900">
        <div class="max-w-[85rem] mx-auto flex justify-between items-center">
            <!-- Header Text -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse text-base font-medium text-white">
                <span>{{ $websiteSettings->header_ads_text }}</span>
            </div>

            <!-- Icons Section -->
            <div class="flex items-center space-x-4 rtl:space-x-reverse text-base text-white">
                <!-- Email Icon -->
                <a href="mailto:contact@example.com" class="hover:text-gray-100">
                    <i class="fas fa-envelope"></i>
                </a>
                <!-- Phone Icon -->
                <a href="#" class="hover:text-gray-100">
                    <i class="fas fa-phone"></i>
                </a>
                <!-- Web Icon -->
                <a href="#" class="hover:text-gray-100">
                    <i class="fas fa-globe"></i>
                </a>

                <!-- Language Dropdown -->
                <div x-data="{ open: false }" class="relative inline-block text-left">
                    <!-- Button -->
                    <button @click="open = !open" type="button"
                        class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                        id="menu-button" aria-expanded="true" aria-haspopup="true">
                        <i class="fas fa-language"></i>
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.outside="open = false"
                        class="origin-top-right absolute right-0 mt-2 min-w-max w-24 sm:w-24 md:w-24 lg:w-24 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        <div class="py-1" role="none">
                            @foreach (config('app.available_locales') as $locale)
                            <a href="{{ route('lang.switch', ['locale' => $locale]) }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                role="menuitem" tabindex="-1">
                                {{ strtoupper($locale) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- Main Navbar -->
    <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8 py-2 flex items-center justify-between">
        <!-- Logo Section -->
        <div class="flex items-center flex-shrink-0">
            <a href="/" class="flex items-center space-x-2">
                @if($websiteSettings->logo)
                    <img src="{{ Storage::url($websiteSettings->logo) }}" alt="{{ $websiteSettings->site_name }}" class="h-10 md:h-12">
                @else
                    <span class="text-lg font-semibold">{{ $websiteSettings->site_name ?? 'Site Name' }}</span>
                @endif
            </a>
        </div>



        <!-- Centered, Larger Search Bar -->
        {{-- <div class="hidden md:flex items-center mx-auto w-full max-w-xl">
            <!-- Adjusted max-width to control overall size -->
            <form action="" method="GET" class="flex items-center w-full">
                <input type="text" name="query" placeholder="...البssحث"
                    class="w-full py-2 px-4 rounded-r-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none">
                <!-- w-full for full width and increased padding -->
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-l-md hover:bg-orange-600">
                    <i class="fas fa-search text-base"></i>
                </button>
            </form>
        </div> --}}
        <div class="hidden md:flex items-center mx-auto w-full max-w-xl">
            {{-- <form wire:submit.prevent="search" class="container px-4 mx-auto flex items-center justify-center">
                <input
                    type="text"
                    name="query"
                    placeholder="{{ app()->getLocale() == 'ar' ? '...ابحث' : 'Search...' }}"
                    class="w-full py-2 px-4
                           rounded-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none
                           rtl:rounded-l-md ltr:rounded-l-md" />
                <button
                    type="submit"
                    class="bg-orange-500 text-white px-4 py-2
                           rounded-md hover:bg-orange-600
                           rtl:rounded-r-md ltr:rounded-l-md">
                    <i class="fas fa-search text-base"></i>
                </button>
            </form> --}}

                <div class="relative w-full sm:max-w-2xl sm:mx-auto ">
                  <div class="overflow-hidden z-0 rounded-full relative p-3">
                    <form wire:submit.prevent="search" role="form" class="relative flex z-50 bg-white rounded-md items-center justify-center  border-2">
                      <input type="text" placeholder=" {{ __('general.search') }}" class="rounded-full flex-1 px-6  text-gray-700 focus:outline-none">
                      <button class="bg-orange-500 text-white rounded-md font-semibold px-8 py-2 hover:bg-indigo-400 focus:bg-indigo-600 focus:outline-none">  <i class="fas fa-search text-base"></i>
                      </button>
                    </form>
                    <div class="glow glow-1 z-10 bg-pink-400 absolute"></div>
                    <div class="glow glow-2 z-20 bg-purple-400 absolute"></div>
                    <div class="glow glow-3 z-30 bg-yellow-400 absolute"></div>
                    <div class="glow glow-4 z-40 bg-blue-400 absolute"></div>
                  </div>
                </div>


        </div>






        <!-- Quick Access Buttons Section -->
        <div class="flex items-center space-x-4 rtl:space-x-reverse">

            <!-- Cart Icon -->
            <div class="flex items-center space-x-4  rtl:space-x-reverse">
                <!-- Cart Button -->

                <a href="{{ route('cart', ['locale' => app()->getLocale()]) }}"
                    class="relative flex items-center px-4 py-1 text-sm font-medium text-white bg-indigo-700 border border-blue-700 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all md:px-6">
                    <span class="hidden lg:inline text-xs font-semibold"> {{ __('general.cart') }} </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:mr-2" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                            d="M704 1536q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm896 0q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm128-1088v512q0 24-16.5 42.5t-40.5 21.5l-1044 122q13 60 13 70 0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-11 8-31.5t16-36 21.5-40 15.5-29.5l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t19.5 15.5 13 24.5 8 26 5.5 29.5 4.5 26h1201q26 0 45 19t19 45z" />
                    </svg>
                    <span class="text-xs font-medium bg-red-500 text-white text-xs font-bold rounded-full px-1.5 ">
                        {{$total_count}}
                    </span>
                    <span
                        class="absolute top-0 right-0 transform translate-x-1 -translate-y-1 bg-red-500 text-white text-xs font-bold rounded-full px-1.5">
                        {{ $total_count }}
                    </span>
                </a>

                <!-- User Dropdown -->
                @if(Auth::check())
                <div x-data="{ open: false }" class="relative">
                    <!-- Dropdown Toggle Button -->
                    <button @click="open = !open"
                        class="flex items-center px-4 py-1 text-sm font-medium text-white bg-indigo-700 border border-blue-700 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all md:px-6">
                        <span class="hidden lg:inline font-semibold">{{ __('general.account') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:ml-2" viewBox="0 0 1792 1792"
                            fill="currentColor">
                            <path
                                d="M1600 1405q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q9 0 42 21.5t74.5 48 108 48 133.5 21.5 133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5z" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-50">
                        <a href="{{ route('my-order.index', ['locale' => app()->getLocale()]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ __('general.account') }}</a>
                        <a href="{{ route('profile.index', ['locale' => app()->getLocale()]) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">{{ __('general.my-orders') }}</a>
                        <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
                            @csrf
                            <button type="submit" class=" px-4 py-2 text-gray-700 hover:bg-gray-100">
                                {{ __('general.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Login Button for Guests -->
                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                    class="flex items-center px-4 py-1 text-sm font-medium text-white bg-indigo-700 border border-blue-700 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all md:px-6">
                    <span class="hidden lg:inline  text-xs  font-semibold">{{ __('general.login') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 md:mr-2 md:ml-2" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                            d="M1600 1405q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q9 0 42 21.5t74.5 48 108 48 133.5 21.5 133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5z" />
                    </svg>
                </a>
                @endif
            </div>





            <!-- Mobile Menu Toggle Button (Visible Only on Mobile) -->
            <button @click="openMenu = !openMenu"
                class="md:hidden flex items-center p-2 rounded-md text-gray-800 dark:text-white">
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


    <div :class="{ 'hidden': !openMenu, 'block': openMenu }" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:hidden"
        x-show="openMenu">
        <!-- Categories Navbar for Mobile (Vertical List) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-4">
            <div class="max-w-[85rem] mx-auto px-6">
                <div class="flex flex-col gap-4">
                    @foreach($categories as $category)
                    <div x-data="{ openSub: false }" class="relative group">
                        <!-- Main Category Link -->
                        <a href="{{ locale_route('category.products', ['slug' => $category->slug]) }}"
                            class="flex items-center justify-between font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-700">
                            <span>{{ $category->getTranslatedName(app()->getLocale()) }}</span>
                            @if($category->children->isNotEmpty())
                            <svg @click.prevent="openSub = !openSub"
                                class="w-5 h-5 transform transition-transform cursor-pointer"
                                :class="{ 'rotate-180': openSub }" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                            </svg>
                            @endif
                        </a>

                        <!-- Subcategories Dropdown -->
                        @if($category->children->isNotEmpty())
                        <div x-show="openSub" @click.away="openSub = false"
                            class="mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg py-2 border border-gray-300 dark:border-gray-600"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95">
                            @foreach($category->children as $subcategory)
                            <a href="{{ locale_route('category.products', ['slug' => $subcategory->slug]) }}"
                                class="block px-6 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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

        <!-- Search Bar for Mobile -->
        <div class="p-6 bg-gray-50 dark:bg-gray-800">
            <form wire:submit.prevent="search" class="flex items-center justify-center max-w-lg mx-auto">
                <div
                    class="flex w-full bg-white dark:bg-gray-700 rounded-lg shadow-md border border-gray-300 dark:border-gray-600">
                    <!-- Input Field -->
                    <div class="relative flex-grow">
                        <input type="text" name="query"
                            placeholder="{{ app()->getLocale() == 'ar' ? '...ابحث' : 'Search...' }}"
                            class="w-full py-3 px-4 rounded-l-lg border-none focus:outline-none focus:ring-2 focus:ring-blue-600 dark:bg-gray-700 dark:text-white rtl:rounded-r-lg rtl:rounded-l-none" />
                        <span
                            class="absolute inset-y-0 flex items-center text-gray-400 pointer-events-none ltr:left-3 rtl:right-3">
                            🔍
                        </span>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-600 text-white px-5 py-3 rounded-r-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rtl:rounded-l-lg rtl:rounded-r-none">
                        {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Navbar for Large Screen (Horizontal List) -->
    <div class="hidden md:flex bg-[#e1e1e1] dark:bg-gray-700 py-2">
        <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex flex-wrap gap-4">
                @foreach($categories as $category)
                <div x-data="{ openSub: false }" class="relative group">
                    <!-- Main Category Link -->
                    <a
                        @mouseenter="openSub = true"
                        @mouseleave="openSub = false"
                        href="{{ locale_route('category.products', ['slug' => $category->slug]) }}"
                        class="font-semibold text-sm text-black dark:text-gray-300 hover:text-white rounded-md  hover:bg-[#01CC97] px-2 py-1  flex items-center transition-all duration-300 ease-in-out "
                    >
                        {{ $category->getTranslatedName(app()->getLocale()) }}
                        @if($category->children->isNotEmpty())
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                        </svg>
                        @endif
                    </a>

                    <!-- Subcategories Dropdown -->
                    @if($category->children->isNotEmpty())
                    <div
                        x-show="openSub"
                        @mouseenter="openSub = true"
                        @mouseleave="openSub = false"
                        class="absolute left-0 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 py-2 transition-all duration-300 ease-in-out"
                        x-transition
                    >
                        @foreach($category->children as $subcategory)
                        <a
                            href="{{ locale_route('category.products', ['slug' => $subcategory->slug]) }}"
                            class="block px-4 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition duration-300 ease-in-out"
                        >
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

</header>
