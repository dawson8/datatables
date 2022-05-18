<div>
    <!-- Filters -->
    {{-- <div class="mb-2 w-full">
        <div class="flex space-x-2 -ml-2">
            <label for="paginate" class="sr-only">Per Page</label>
            <div class="w-24">
                <select wire:model="paginate" class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            @if(count($checked))
                <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="flex bg-white whitespace-nowrap border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5">
                            <span>With selected</span>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link wire:click="deleteChecked">
                            {{ __('Delete') }} {{ count($checked) }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            @endif

            <label for="search" class="sr-only">Search</label>
            <div class="relative sm:w-64 xl:w-96">
                <input type="search"
                    wire:model.debounce.500ms="query"
                    class="border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5"
                    placeholder="Search">
            </div>

            <div class="flex items-center sm:justify-end w-full">
                <button type="button"
                    class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:ring-sky-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -ml-1 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Record
                </button>
            </div>
        </div>
    </div> --}}

    <!-- Table -->
    <div class='overflow-x-auto w-full'>
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm text-gray-500">
                    <th></th>
                    @foreach ($columns as $column)
                        <th class="p-2">{{ Str::replace('_', ' ', Str::title($column)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($this->records() as $record)
                    <tr class="hover:bg-gray-200">
                        <td class="p-2 w-4">
                            <div class="flex items-center">
                                <input type="checkbox"
                                    wire:model="checked"
                                    value="{{ $record->id }}"
                                    class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-sky-200 h-4 w-4 rounded">
                            </div>
                        </td>
                        @foreach ($columns as $column)
                            <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">
                                {{ $record->{$column} }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    {{-- <div class="py-2">
        {{ $this->records()->links() }}
    </div> --}}
</div>
