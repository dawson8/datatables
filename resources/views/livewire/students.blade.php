<div>
    <!-- Filters -->
    <div class="mb-2 w-full">
        <div class="block sm:flex items-center md:divide-x md:divide-gray-100">
            <label for="paginate" class="sr-only">Per Page</label>
            <div class="relative w-24">
                <select wire:model="paginate" name="paginate" id="paginate" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5">
                    <option value="10">10</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            <label for="paginate" class="sr-only">Filter By Class</label>
            <div class="ml-2 relative w-48">
                <select class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5" wire:model="selectedClass">
                    <option value="">All Classes</option>
                    @foreach ($classes as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <label for="search" class="sr-only">Search</label>
            <div class="ml-2 relative sm:w-64 xl:w-96">
                <input wire:model.debounce.500ms="search" type="search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-sky-600 focus:border-sky-600 block w-full p-2.5" placeholder="Search for students">
            </div>

            <div class="flex items-center sm:justify-end w-full">
                <div class="md:flex pl-2 space-x-1">
                    @if ($checked)
                    {{-- TODO: Fix this mess!!! use a dialogmodal --}}
                        <button class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded inline-flex justify-center" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImediatePropagation()" wire:click="deleteRecords()">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ count($checked) }}
                        </button>
                        <button class="text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded inline-flex justify-center" onclick="confirm('Are you sure you want to export these Records?') || event.stopImediatePropagation()" wire:click="exportSelected()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </button>

                        @if($selectPage)
                            <span class="text-gray-500">
                                @if($selectAll)
                                    You have selected all <strong>{{ $students->total() }}</strong> items
                                @else
                                    You have selected <strong>{{ count($checked) }}</strong> items, Do you want to select all <strong>{{ $students->total() }}</strong>?
                                    <button wire:click="selectAll" class="ml-1 text-sky-600 hover:text-sky-700">Select All</button>
                                @endif
                            </span>
                        @endif
                    @endif
                </div>

                <button wire:click="confirmingProductAdd"
                    type="button"
                    class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:ring-sky-200 font-medium inline-flex items-center rounded-lg text-sm px-3 py-2 text-center sm:ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -ml-1 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add product
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-200">
                <tr class="text-left text-sm text-gray-500">
                    <th class="p-2">
                        <div class="flex items-center">
                            <input type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-sky-200 h-4 w-4 rounded" wire:model="selectPage">
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('name')" class="font-bold">Student's Name</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="name" />
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('class_id')" class="font-bold">Class</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="class_id" />
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('section_id')" class="font-bold">Section</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="section_id" />
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('email')" class="font-bold">Email</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="email" />
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('address')" class="font-bold">Address</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="address" />
                        </div>
                    </th>
                    <th class="p-2">
                        <div class="flex">
                            <button wire:click="sortBy('phone_number')" class="font-bold">Phone</button>
                            <x-sort-icon :sortBy="$sortBy" :sortAsc="$sortAsc" sortField="phone_number" />
                        </div>
                    </th>
                    <th class="p-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($students as $student)
                    <tr class="hover:bg-gray-200 @if($this->isChecked($student->id)) bg-sky-100 hover:bg-sky-200 @endif">
                        <td class="p-2 w-4">
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    value="{{ $student->id }}"
                                    class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-sky-200 h-4 w-4 rounded"
                                    wire:model="checked">
                            </div>
                        </td>
                        <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">{{ $student->name }}</td>
                        <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">{{ $student->class->name }}</td>
                        <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">{{ $student->section->name }}</td>
                        <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">{{ $student->email }}</td>
                        <td class="p-2 text-base font-medium text-gray-900">{{ $student->address }}</td>
                        <td class="p-2 whitespace-nowrap text-base font-medium text-gray-900">{{ $student->phone_number }}</td>
                        <td class="p-2 whitespace-nowrap">
                            <button
                                onclick="confirm('Are you sure you want to delete this record?') || event.stopImediatePropagation()" wire:click="deleteSingleRecord({{ $student->id }})"
                                wire:loading.attr="disabled"
                                type="button"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-3 py-2 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class=" w-full border-t border-gray-200 py-4">
        {{ $students->links() }}
    </div>
</div>
