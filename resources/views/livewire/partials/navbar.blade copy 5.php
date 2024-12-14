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
    <div class="hidden md:flex items-center mx-auto w-full max-w-xl"> <!-- Adjusted max-width to control overall size -->
        <form action="" method="GET" class="flex items-center w-full">
            <input type="text" name="query" placeholder="...البحث" class="w-full py-2 px-4 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none"> <!-- w-full for full width and increased padding -->
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-r-md hover:bg-orange-600">
                🔍
            </button>
        </form>
    </div>

    <!-- Quick Access Buttons Section -->
    <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <a href="/cart" class="bg-blue-700 text-white py-1 px-3 rounded-md">🛒 سلة المشتريات 0 د.ع</a>
        <a href="/login" class="bg-blue-700 text-white py-1 px-3 rounded-md">تسجيل الدخول</a>
    <!-- Language Switcher -->
    <div class="relative">
        <button type="button" class="flex items-center text-gray-500 hover:text-blue-600 dark:text-gray-400">
            Language
            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6" />
            </svg>
        </button>
        <div class="absolute left-0 mt-1 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 hidden">
            <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Arabic</a>
            <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">English</a>
        </div>
    </div>
        <!-- Mobile Menu Toggle Button (Visible Only on Mobile) -->
        <button @click="openMenu = !openMenu" class="md:hidden flex items-center p-2 rounded-md text-gray-800 dark:text-white">
            <svg x-show="!openMenu" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="3" x2="21" y1="6" y2="6" />
                <line x1="3" x2="21" y1="12" y2="12" />
                <line x1="3" x2="21" y1="18" y2="18" />
            </svg>
            <svg x-show="openMenu" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6L6 18" />
                <path d="M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>


    <!-- Mobile Menu and Categories (Vertical List) -->
    <div :class="{'hidden': !openMenu, 'block': openMenu}" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:hidden" x-show="openMenu">
        <!-- Categories Navbar for Mobile (Vertical List) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-2">
            <div class="max-w-[85rem] mx-auto px-4">
                <div class="flex flex-col gap-2"> <!-- Changed to flex-col for vertical alignment -->
                    @foreach($categories as $category)
                        <div x-data="{ openSub: false }" class="relative group">
                            <!-- Main Category Link with Subcategory Toggle -->
                            <a @click.prevent="openSub = !openSub" href="" class="font-medium text-gray-700 dark:text-gray-300 hover:text-blue-700 flex items-center">
                                {{ $category->getTranslatedName(app()->getLocale()) }}
                                @if($category->children->isNotEmpty())
                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                                    </svg>
                                @endif
                            </a>

                            <!-- Subcategories Dropdown (Show when clicked) -->
                            @if($category->children->isNotEmpty())
                                <div x-show="openSub" @click.away="openSub = false" class="mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg py-2" x-transition>
                                    @foreach($category->children as $subcategory)
                                        <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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
            <form action="" method="GET" class="flex items-center w-full">
                <input type="text" name="query" placeholder="...البحث" class="flex-grow py-1 px-3 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none">
                <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded-r-md hover:bg-orange-600">
                    🔍
                </button>
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
                        <a @mouseenter="openSub = true" @mouseleave="openSub = false" href="" class="font-medium text-gray-700 dark:text-gray-300 hover:text-blue-700 flex items-center">
                            {{ $category->getTranslatedName(app()->getLocale()) }}
                            @if($category->children->isNotEmpty())
                                <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                                </svg>
                            @endif
                        </a>

                        <!-- Subcategories Dropdown -->
                        @if($category->children->isNotEmpty())
                            <div x-show="openSub" @mouseenter="openSub = true" @mouseleave="openSub = false" class="absolute left-0 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 py-2" x-transition>
                                @foreach($category->children as $subcategory)
                                    <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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
