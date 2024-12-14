<header class="bg-white shadow-md dark:bg-gray-800" x-data="{ openMenu: false, openCategory: false }">
    <!-- Top Bar with Contact and Social Media -->
    <div class="bg-red-600 text-white py-1 px-4">
        <div class="max-w-[85rem] mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4 rtl:space-x-reverse text-sm">
                <span>Free Delivery in Baghdad, 5k across provinces in Iraq</span>
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
        <!-- Logo -->
        <a href="/" class="text-xl font-semibold dark:text-white">iQprotein</a>

        <!-- Centered Search Bar -->
        <div class="hidden md:flex items-center mx-4 flex-grow">
            <form action="" method="GET" class="flex items-center w-full max-w-md">
                <input type="text" name="query" placeholder="Search..." class="flex-grow py-1 px-3 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none">
                <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded-r-md hover:bg-orange-600">
                    🔍
                </button>
            </form>
        </div>

        <!-- Quick Access Buttons -->
        <div class="flex items-center space-x-4 rtl:space-x-reverse">
            <a href="/cart" class="bg-blue-600 text-white py-1 px-3 rounded-md">🛒 Cart - 0 IQD</a>
            <a href="/login" class="bg-blue-600 text-white py-1 px-3 rounded-md">Login</a>
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

    <!-- Categories Navbar (Visible in Toggle on Mobile) -->
    <div :class="{'hidden': !openMenu, 'block': openMenu}" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:flex md:flex-col" x-show="openMenu || window.innerWidth >= 768" @resize.window="openMenu = window.innerWidth >= 768">
        <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8 py-2">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-6">
                <!-- Standard Links -->
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="/" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Home</a>
                    <a href="/products" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Products</a>
                    <a href="/blog" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Blog</a>
                    <a href="/about" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">About</a>
                </div>

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

                <!-- Search Bar for Mobile -->
                <div class="md:hidden">
                    <form action="" method="GET" class="flex items-center w-full">
                        <input type="text" name="query" placeholder="Search..." class="flex-grow py-1 px-3 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:outline-none">
                        <button type="submit" class="bg-orange-500 text-white px-3 py-1 rounded-r-md hover:bg-orange-600">
                            🔍
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Third Navbar: Categories Section (Visible in Toggle on Mobile) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-2">
            <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8">
                <div class="flex flex-wrap gap-4">
                    @foreach($categories as $category)
                        <div x-data="{ openSub: false }" class="relative group">
                            <!-- Main Category Link with Subcategory Toggle -->
                            <a @mouseenter="openSub = true" @mouseleave="openSub = false" @click.prevent="openSub = !openSub" href="" class="font-medium text-gray-600 dark:text-gray-300 hover:text-blue-500">
                                {{ $category->getTranslatedName(app()->getLocale()) }}
                                @if($category->children->isNotEmpty())
                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                                    </svg>
                                @endif
                            </a>

                            <!-- Subcategories Dropdown -->
                            @if($category->children->isNotEmpty())
                                <div x-show="openSub" @mouseenter="openSub = true" @mouseleave="openSub = false" class="absolute left-0 mt-2 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 py-2">
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
    </div>
</header>
