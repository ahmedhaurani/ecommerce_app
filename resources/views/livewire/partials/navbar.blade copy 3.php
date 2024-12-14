<header class="bg-white shadow-md dark:bg-gray-800" x-data="{ openMenu: false }">
    <!-- Primary Header: Logo and Cart (Visible on All Screens) -->
    <div class="flex justify-between items-center max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8 py-2">
        <!-- Logo -->
        <a href="/" class="text-xl font-semibold dark:text-white">DCodeMania</a>

        <!-- Cart Link -->
        <div class="flex items-center space-x-4">
            <a href="/cart" class="flex items-center text-gray-500 hover:text-blue-600 dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span>Cart</span> <span class="ml-1 py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">{{$total_count}}</span>
            </a>

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

    <!-- Secondary Navbar: All Links, Language, Search (Hidden by Default on Mobile) -->
    <div :class="{'hidden': !openMenu, 'block': openMenu}" class="bg-gray-100 dark:bg-gray-900 shadow-inner md:flex md:flex-col" x-show="openMenu || window.innerWidth >= 768" @resize.window="openMenu = window.innerWidth >= 768">
        <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8 py-2">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-6">
                <!-- Standard Links -->
                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
                    <a href="/" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Home</a>
                    <a href="/products" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Products</a>
                    @guest
                        <a href="/login" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Login</a>
                        <a href="/register" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">Register</a>
                    @else
                        <a href="/my-orders" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">My Orders</a>
                        <a href="/account" class="font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400">My Account</a>
                    @endguest
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

                <!-- Search Bar -->
                <form action="" method="GET" class="flex items-center mt-4 md:mt-0">
                    <input type="text" name="query" placeholder="Search..." class="py-1 px-2 rounded-l-md border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white w-full md:w-auto">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded-r-md hover:bg-blue-600">Search</button>
                </form>
            </div>
        </div>

        <!-- Third Navbar: Categories Section (Visible in Toggle on Mobile) -->
        <div class="bg-gray-200 dark:bg-gray-700 py-2">
            <div class="max-w-[85rem] mx-auto px-4 md:px-6 lg:px-8">
                <div x-data="{ openCategories: false }" class="relative">
                    <button @click="openCategories = !openCategories" class="flex items-center font-medium text-gray-600 dark:text-gray-300">
                        Browse Categories
                        <svg :class="{'rotate-180': openCategories}" class="w-4 h-4 ml-1 transition-transform transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 9l6 6 6-6" />
                        </svg>
                    </button>

                    <!-- Dropdown for Categories -->
                    <div x-show="openCategories" @click.away="openCategories = false" class="absolute left-0 mt-1 bg-white dark:bg-gray-800 shadow-lg rounded-lg w-48 z-50 py-2">
                        @foreach($categories as $category)
                            <a href="" class="block px-4 py-2 text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ $category->getTranslatedName(app()->getLocale()) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
