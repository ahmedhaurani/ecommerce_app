<header class="bg-[#f3f6f4] shadow-md dark:bg-gray-600" x-data="{ openMenu: false, openCategory: false }">
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
<div class="flex items-center">
    <a href="/" class="text-xl font-semibold dark:text-white">
        @if($websiteSettings->logo)
            <img
                src="{{ Storage::url($websiteSettings->logo) }}"
                alt="{{ $websiteSettings->site_name }}"
                class="h-8 w-auto sm:h-10 md:h-12 lg:h-16 xl:h-20 max-w-full"
            >
        @else
            {{ $websiteSettings->site_name ?? 'Default Site Name' }}
        @endif
    </a>
</div>



        <!-- Centered, Larger Search Bar -->
        {{-- <div class="hidden md:flex items-center mx-auto w-full max-w-xl">
            <!-- Adjusted max-width to control overall size -->
            <form action="" method="GET" class="flex items-center w-full">
                <input type="text" name="query" placeholder="...البssحث"
                    class="w-full py-2 px-4 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none">
                <!-- w-full for full width and increased padding -->
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-r-md hover:bg-orange-600">
                    🔍
                </button>
            </form>
        </div> --}}
        <div class="hidden md:flex items-center mx-auto w-full max-w-2xl">
            <form wire:submit.prevent="search" class="container px-4 mx-auto flex items-center justify-center">
                <div class="border border-gray-400 rounded-lg bg-white shadow-md flex w-full max-w-2xl overflow-hidden">
                    <!-- Reduced space here -->
                    <!-- Input Field with Icon -->
                    <div class="relative flex-grow">
                        <input type="text" wire:model="query" name="query" placeholder="ابحث عن المنتجات..."
                            class="w-full py-2 pl-12 pr-4 rtl:pl-4 rtl:pr-12 rounded-l-lg focus:outline-none text-gray-800 dark:bg-gray-700 dark:text-white border-none" />
                        <span class="absolute inset-y-0 flex items-center text-gray-400 pointer-events-none
                                 ltr:left-0 ltr:pl-4 rtl:right-0 rtl:pr-4">
                            🔍
                        </span>
                    </div>
                    <!-- Submit Button with Dynamic Text for RTL/LTR -->
                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600
                    rtl:rounded-l-lg rtl:rounded-r-none ltr:rounded-r-lg ltr:rounded-l-none">
<i class="fas fa-search text-base"></i> <!-- Replace text with icon -->
</button>

                </div>
            </form>
        </div>





        <!-- Quick Access Buttons Section -->
        <div class="flex items-center space-x-4 rtl:space-x-reverse">

    <!-- Cart Icon -->
  <!-- Cart Icon -->
<a wire:navigate
class="font-medium flex items-center {{ request()->is('cart') ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-500 py-3 md:py-6 dark:text-gray-400 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-blue-600"
href="{{ route('cart', ['locale' => app()->getLocale()]) }}">
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
      class="flex-shrink-0 w-10 h-10 mr-1 {{ request()->is('cart') ? 'stroke-gray-600' : 'stroke-blue-500' }} hover:stroke-gray-500 transition duration-200 ease-in-out">
     <path stroke-linecap="round" stroke-linejoin="round"
           d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
 </svg>
 <span
     class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-red-50 border border-red-200 text-red-600">
     {{$total_count}}
 </span>
</a>

<!-- Profile Icon -->
<a wire:navigate
class="font-medium flex items-center {{ request()->is('profile') ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-500 py-3 md:py-6 dark:text-gray-400 dark:hover:text-blue-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-blue-600"
href="#">
 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
      class="flex-shrink-0 w-10 h-10 mr-2 {{ request()->is('profile') ? 'stroke-gray-600' : 'stroke-blue-500' }} hover:stroke-green-500 transition duration-200 ease-in-out">
     <path stroke-linecap="round" stroke-linejoin="round"
           d="M16.5 7.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM4.5 19.5a8.25 8.25 0 0 1 15 0v.75H4.5v-.75Z" />
 </svg>
</a>




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


    <!-- Mobile Menu and Categories (Vertical List) -->
    <div :class="{'hidden': !openMenu, 'block': openMenu}" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:hidden"
        x-show="openMenu">
        <!-- Categories Navbar for Mobile (Vertical List) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-2">
            <div class="max-w-[85rem] mx-auto px-4">
                <div class="flex flex-col gap-2">
                    <!-- Changed to flex-col for vertical alignment -->
                    @foreach($categories as $category)
                    <div x-data="{ openSub: false }" class="relative group">
                        <!-- Main Category Link with Subcategory Toggle -->


                        <a @click.prevent="openSub = !openSub" href="{{ locale_route('category.products', ['slug' => $category->slug]) }}"
                            class="font-medium text-gray-700 dark:text-gray-300 hover:text-blue-700 flex items-center">
                            {{ $category->getTranslatedName(app()->getLocale()) }}
                            @if($category->children->isNotEmpty())
                            <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                            </svg>
                            @endif
                        </a>

                        <!-- Subcategories Dropdown (Show when clicked) -->
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

        <!-- Search Bar for Mobile -->
        <div class="bg-white dark:bg-gray-900 p-4">
            <form wire:submit.prevent="search" class="container px-4 mx-auto flex items-center justify-center">
                <div
                    class="border-2 border-blue-600 rounded-lg bg-white shadow-md flex w-full max-w-lg overflow-hidden">
                    <!-- Reduced border and rounded size -->
                    <div class="relative flex-grow">
                        <!-- Adjust padding for RTL and LTR layouts -->
                        <input type="text" name="query" placeholder="...ابحث"
                            class="w-full py-2 pr-8 pl-4 rtl:pl-8 rtl:pr-4 rounded-l-md border-0 focus:outline-none text-gray-800 dark:bg-gray-700 dark:text-white" />
                        <!-- Icon positioning for RTL/LTR -->
                        <span class="absolute inset-y-0 flex items-center text-gray-400 pointer-events-none
                                     ltr:left-0 ltr:pl-3 rtl:right-0 rtl:pr-3">
                            🔍
                        </span>
                    </div>
                    <!-- Dynamic text for RTL and LTR and reduced rounding -->
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-r-md hover:bg-blue-600
                                                  rtl:rounded-l-md rtl:rounded-r-none ltr:rounded-r-md ltr:rounded-l-none">
                        <p class="font-semibold text-base uppercase">
                            {{ app()->getLocale() == 'ar' ? 'بحث' : 'Search' }}
                        </p>
                    </button>
                </div>
            </form>
        </div>






    </div>

    <!-- Categories Navbar for Large Screen (Horizontal List) -->
    <div class="hidden md:flex bg-gray-200 dark:bg-gray-700 py-2">
        <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex flex-wrap gap-4">
                @foreach($categories as $category)
                <div x-data="{ openSub: false }" class="relative group">
                    <!-- Main Category Link with Subcategory Toggle -->
                    <a @mouseenter="openSub = true" @mouseleave="openSub = false" href="{{ locale_route('category.products', ['slug' => $category->slug]) }}"
                        class="font-medium text-gray-700 dark:text-gray-300 hover:text-blue-700 flex items-center">
                        {{ $category->getTranslatedName(app()->getLocale()) }}
                        @if($category->children->isNotEmpty())
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                        </svg>
                        @endif
                    </a>

                    <!-- Subcategories Dropdown -->
                    @if($category->children->isNotEmpty())
                    <div x-show="openSub" @mouseenter="openSub = true" @mouseleave="openSub = false"
                        class="absolute left-0 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 py-2"
                        x-transition>
                        @foreach($category->children as $subcategory)
                        <a href="{{ locale_route('category.products', ['slug' => $category->slug]) }}"
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
</header>
