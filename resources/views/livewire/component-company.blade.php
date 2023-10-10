<div class="p-6">
    @if ($activity == 'create')
        <x-form-section submit="store">
            <x-slot name="title">
                {{ __('Company Registration') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You must enter the basic information of your company.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-2">
                    <label for="logo"
                        class="flex flex-col items-center justify-center w-full h-52 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-48 object-cover">
                            @else
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click
                                        to upload</span></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG</p>
                            @endif
                        </div>
                        <input id="logo" type="file" class="hidden" wire:model='logo' />
                    </label>
                    <x-input-error for="logo" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="nit" value="{{ __('NIT') }}" />
                        <x-input id="nit" type="text" class="mt-1 block w-full" wire:model="nit" />
                        <x-input-error for="nit" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="description" value="{{ __('Description') }}" />
                        <x-input id="description" type="text" class="mt-1 block w-full" wire:model="description" />
                        <x-input-error for="description" class="mt-2" />
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
                {{ __('Company Edition') }}
            </x-slot>

            <x-slot name="description">
                {{ __('You must enter the basic information of your company.') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-2">
                    <label for="logo"
                        class="flex flex-col items-center justify-center w-full h-52 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @if ($logo)
                                <img src="{{ $logo->temporaryUrl() }}" class="w-full h-48 object-cover">
                            @else
                                <img src="{{ Storage::url($logoBefore) }}" class="w-full h-48 object-cover">
                            @endif
                        </div>
                        <input id="logo" type="file" class="hidden" wire:model='logo' />
                    </label>
                    <x-input-error for="logo" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="nit" value="{{ __('NIT') }}" />
                        <x-input id="nit" type="text" class="mt-1 block w-full" wire:model="nit" />
                        <x-input-error for="nit" class="mt-2" />
                    </div>

                    <div>
                        <x-label for="description" value="{{ __('Description') }}" />
                        <x-input id="description" type="text" class="mt-1 block w-full" wire:model="description" />
                        <x-input-error for="description" class="mt-2" />
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
                        {{ __('Company') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('NIT') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Addresses') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Phones') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="{{ Storage::url($company->logo) }}">
                            <div class="pl-3">
                                <div class="text-base font-semibold">{{ $company->name }}</div>
                                <div class="font-normal text-gray-500">{{ $company->description }}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{ $company->nit }}
                        </td>
                        <td class="px-6 py-4">

                        </td>
                        <td class="px-6 py-4">

                        </td>
                        <td class="px-6 py-4">
                            <a wire:click='edit({{ $company->id }})'
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">{{ __('Edit') }}</a>
                            <a wire:click='destroy({{ $company->id }})'
                                class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">{{ __('Delete') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-2 p-2 w-full bg-gray-50 dark:bg-gray-900">
            {{ $companies->links() }}
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
