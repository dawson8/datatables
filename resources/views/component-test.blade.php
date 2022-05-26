<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Component Test') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <span>Alerts</span>
                    Info
                    <x-alert>
                        Your subscription is expiring in 19 days.
                        <a href="#">Renew now</a>
                    </x-alert>
                    Error
                    <x-alert
                        type="error">
                        You do not have permission to upload files
                    </x-alert>
                    Warning
                    <x-alert
                        type="warning">
                        Well, this is your first warning. Do that again and I'll wipe your hard disk
                    </x-alert>
                    Success
                    <x-alert
                        type="success">
                        Files were successfully uploaded
                    </x-alert>
                    <span>Button</span>
                    <x-button>Click Me</x-button>
                    <x-button
                        type="secondary">
                        subscribe now
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
