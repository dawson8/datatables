
    <div class="relative table-cell h-12 overflow-hidden align-top" @include('livewire.datatables.style-width')>

            <div class="w-full h-full px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider flex items-center focus:outline-none @if($column['headerAlign'] === 'right') justify-end @elseif($column['headerAlign'] === 'center') justify-center @endif">
                <span class="inline ">{{ str_replace('_', ' ', $column['label']) }}</span>
            </div>
    </div>

