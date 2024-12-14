<div x-data="{ open: [] }" class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 sm:gap-6">
            @foreach ($categories as $category)
                <div>
                    <a @click="open.includes({{ $category->id }}) ? open = open.filter(id => id !== {{ $category->id }}) : open.push({{ $category->id }})" class="group flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-900 dark:border-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                        <div class="p-4 md:p-5">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <img class="h-[5rem] w-[5rem]" src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->getTranslatedName(app()->getLocale()) }}">
                                    <div class="ms-3">
                                        <h3 class="group-hover:text-blue-600 text-2xl font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                                            {{ $category->getTranslatedName(app()->getLocale()) }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="ps-3">
                                    <svg class="flex-shrink-0 w-5 h-5 {{ in_array($category->id, $expandedCategories) ? 'transform rotate-90' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18l6-6-6-6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div x-show="open.includes({{ $category->id }})" x-transition class="ml-6 overflow-hidden transition-all duration-300 ease-in-out">
                        @foreach ($category->children as $subCategory)
                            <a @click="open.includes({{ $subCategory->id }}) ? open = open.filter(id => id !== {{ $subCategory->id }}) : open.push({{ $subCategory->id }})" class="group flex flex-col bg-gray-100 border shadow-sm rounded-xl hover:shadow-md transition dark:bg-slate-800 dark:border-gray-700 cursor-pointer mt-2">
                                <div class="p-4 md:p-5">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <img class="h-[4rem] w-[4rem]" src="{{ asset('storage/' . $subCategory->image) }}" alt="{{ $subCategory->getTranslatedName(app()->getLocale()) }}">
                                            <div class="ms-3">
                                                <h3 class="group-hover:text-blue-600 text-xl font-semibold text-gray-800 dark:group-hover:text-gray-400 dark:text-gray-200">
                                                    {{ $subCategory->getTranslatedName(app()->getLocale()) }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="ps-3">
                                            <svg class="flex-shrink-0 w-5 h-5 {{ in_array($subCategory->id, $expandedCategories) ? 'transform rotate-90' : '' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18l6-6-6-6" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div x-show="open.includes({{ $subCategory->id }})" x-transition class="ml-6">
                                @foreach ($subCategory->children as $subSubCategory)
                                    <div class="text-gray-600 mt-2">
                                        {{ $subSubCategory->getTranslatedName(app()->getLocale()) }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
