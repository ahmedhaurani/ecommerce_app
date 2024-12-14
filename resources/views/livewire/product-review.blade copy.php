<div class="mt-6">
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-200">
            {{ __('product.review_submitted') }}
        </div>
    @endif

    <!-- Review Form -->
    <form wire:submit.prevent="submitReview" class="bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <!-- Rating Field -->
        <div class="mb-6">
            <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('product.rating') }}</label>
            <select wire:model="rating" id="rating" class="block w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-2.5 focus:ring focus:ring-yellow-500 focus:border-yellow-500 dark:focus:ring-yellow-400">
                <option value="">{{ __('product.select_rating') }}</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} {{ __('product.star') }}</option>
                @endfor
            </select>
            @error('rating')
                <span class="text-sm text-red-500 mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Review Field -->
        <div class="mb-6">
            <label for="review" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('product.review') }}</label>
            <textarea wire:model="review" id="review" rows="4" class="block w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-2.5 focus:ring focus:ring-yellow-500 focus:border-yellow-500 dark:focus:ring-yellow-400"></textarea>
            @error('review')
                <span class="text-sm text-red-500 mt-2">{{ $message }}</span>
            @enderror
        </div>

        <!-- Name Field for Guests -->
        @guest
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('product.your_name') }}</label>
            <input type="text" wire:model="name" id="name" class="block w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-2.5 focus:ring focus:ring-yellow-500 focus:border-yellow-500 dark:focus:ring-yellow-400">
            @error('name')
                <span class="text-sm text-red-500 mt-2">{{ $message }}</span>
            @enderror
        </div>
        @endguest

        <!-- Submit Button -->
        <button type="submit" class="w-full py-3 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring focus:ring-yellow-400 focus:ring-opacity-50 transition duration-200">
            {{ __('product.submit_review') }}
        </button>
    </form>




</div>




