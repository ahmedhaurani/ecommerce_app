<div class="w-full max-w-[85rem] py-6 px-4 sm:px-6 lg:px-8 mx-auto rounded-lg">
    <section class="py-8 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-6 mx-auto max-w-7xl lg:py-8 md:px-6">


            @if (session()->has('success'))
            <div class="bg-green-500 text-white p-3 rounded text-center">
                {{ __('profile.success_message') }}
            </div>
            @endif

            <h2 class="text-xl font-semibold text-gray-800 text-center">{{ __('profile.title') }}</h2>

            <form wire:submit.prevent="updateProfile" class="space-y-4">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">{{ __('profile.name') }}</label>
                    <input type="text" id="name" wire:model.defer="name"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Current Password Field -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('profile.current_password') }}</label>
                    <input type="password" id="current_password" wire:model.defer="current_password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- New Password Field -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">{{ __('profile.new_password') }}</label>
                    <input type="password" id="new_password" wire:model.defer="new_password"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm New Password Field -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('profile.confirm_new_password') }}</label>
                    <input type="password" id="new_password_confirmation" wire:model.defer="new_password_confirmation"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        {{ __('profile.update_button') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
