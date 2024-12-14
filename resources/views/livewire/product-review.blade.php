{{-- <div>
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

    <!-- Confirmation Modal -->
    <div>
        <!-- Button to trigger modal -->
        <button wire:click="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">
            Open Modal
        </button>

        <!-- Modal -->
        <div
            x-data="{ open: @entangle('isOpen') }"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title" role="dialog" aria-modal="true"
        >
            <div class="flex items-end justify-center min-h-screen p-4 text-center sm:block sm:p-0">
                <!-- Modal overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                <!-- Modal content -->
                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <!-- Modal content goes here -->
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                    Modal Title
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Your modal content...
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="open = false; $wire.hideModal()" class="w-full px-4 py-2 mt-3 font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                        <!-- Additional buttons can go here -->
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

 --}}



 <div>
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


@push('scripts')

<script>
   $wire.on('show-verification-modal', () => {

     $('#exampleModal').modal('show');

   });
</script>
@endpush
