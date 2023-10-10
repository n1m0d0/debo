<div class="p-6">
    @if ($activity == 'create')
        <x-form-section submit="store">
            <x-slot name="title">
                {{ __('User Registration') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You must enter the basic information of your user.') }}
            </x-slot>

            <x-slot name="form">              
                <div class="col-span-6 sm:col-span-4">
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="text" class="mt-1 block w-full" wire:model="email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-danger-button wire:click='clear' class="mr-2">
                    {{ __('Cancel') }}
                </x-danger-button>

                <x-button wire:loading.attr="disabled" wire:target="store">
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        </x-form-section>
    @endif

    @if ($activity == 'edit')
        <x-form-section submit="update">
            <x-slot name="title">
                {{ __('User Edition') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You must enter the basic information of your user.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="text" class="mt-1 block w-full" wire:model="email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-danger-button wire:click='clear' class="mr-2">
                    {{ __('Cancel') }}
                </x-danger-button>

                <x-button wire:loading.attr="disabled" wire:target="update">
                    {{ __('Save') }}
                </x-button>
            </x-slot>
        </x-form-section>
    @endif

    <x-section-border />

    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
        <input type="search" id="default-search" wire:model.live='search'
            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-600 dark:focus:border-indigo-600"
            placeholder="">

        @if ($search != null)
            <a wire:click='resetSearch'
                class="text-white absolute right-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer">
                X
            </a>
        @endif
    </div>

    <x-section-border />

    <div class="mt-2 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        {{ __('User') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="pl-3">
                                <div class="text-base font-semibold">{{ $user->name }}</div>
                                <div class="font-normal text-gray-500">{{ $user->email }}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            <a wire:click='edit({{ $user->id }})'
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">{{ __('Edit') }}</a>
                            <a wire:click='destroy({{ $user->id }})'
                                class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">{{ __('Delete') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 p-2 w-full bg-gray-50 dark:bg-gray-900">
            {{ $users->links() }}
        </div>
    </div>

    <x-section-border />

    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-alert-triangle class="h-10 w-10 text-red-500 mr-2" />

                {{ __('Delete') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                <x-feathericon-trash class="h-20 w-20 text-red-500 mr-2" />

                <p>
                    {{ __('Once deleted, the record cannot be recovered.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-danger-button wire:click="$set('deleteModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-danger-button>

            <x-secondary-button class="ml-2" wire:click='delete' wire:loading.attr="disabled">
                {{ __('Accept') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
