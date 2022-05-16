<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:datatable 
                model="App\Models\Student" 
                include="name, email, address, class.name|Class, section.name|Section" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:datatable 
                model="App\Models\User" 
                exclude="id, updated_at" />
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:datatable 
                model="App\Models\Section" />
        </div>
    </div>
</x-app-layout>
