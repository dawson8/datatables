<div>
    <div class="flex justify-between mb-4">
        <label for="search" class="sr-only">Search</label>
        <div class="ml-2 relative sm:w-64 xl:w-96">
            <input wire:model.debounce.500ms="query" type="search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5" placeholder="Search for students">
        </div>
        <div class="flex">
            <div class="flex">
                <label for="paginate" class="whitespace-nowrap mr-2">Per page</label>
                <div class="relative w-24">
                    <select wire:model="paginate" name="paginate" id="paginate" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5">
                        <option value="10">10</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>

            @if(count($checked))
                <div class="relative inline-block text-left">
                    <div>
                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                            With Checked
                            <!-- Heroicon name: solid/chevron-down -->
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                            <a href="#" wire:click="deleteChecked" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Delete {{ count($checked) }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class='overflow-x-auto w-full'>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm text-gray-500">
                    <th></th>
                    @foreach ($columns as $column)
                        <th scope="col" class="p-2">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($this->records() as $record)
                    <tr class="hover:bg-gray-200 @if($this->isChecked($record)) bg-sky-100 hover:bg-sky-200 @endif">
                        <td class="p-2 w-4">
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    value="{{ $record->id }}"
                                    class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-sky-200 h-4 w-4 rounded"
                                    wire:model="checked">
                            </div>
                        </td>
                        @foreach ($columns as $column)
                            <td scope="row" class="p-2 whitespace-nowrap text-base font-medium text-gray-900">
                                {{ $record->{$column} }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="py-4">
        {{ $this->records()->links() }}
    </div>
</div>
