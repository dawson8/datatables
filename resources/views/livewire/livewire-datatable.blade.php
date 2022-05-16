<div>
    <div class="relative">
        <div wire:loading.class="opacity-50" class="rounded-lg shadow-lg bg-white max-w-screen overflow-x-scroll border-2 border-transparent ">
            <div class="table min-w-full align-middle">
                <div class="table-row divide-x divide-gray-200">
                    @foreach($this->columns as $index => $column)
                        <div class="relative table-cell h-12 overflow-hidden align-top">
                            <div class="w-full h-full px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider flex items-center focus:outline-none">
                                <span class="inline ">{{ str_replace('_', ' ', $column['label']) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @foreach($this->results as $row)
                    <div class="table-row p-1 ">
                        @foreach($this->columns as $column)
                            <div class="table-cell px-6 py-2 text-left ">
                                {!! $row->{$column['name']} !!}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            @if($this->results->isEmpty())
                <p class="p-3 text-lg text-center">
                    {{ __("There's Nothing to show at the moment") }}
                </p>
            @endif
        </div>

        <div class="max-w-screen bg-white border-4 border-t-0 border-b-0 border-transparent">
            {{ $this->results->links() }}
        </div>
    </div>
</div>
