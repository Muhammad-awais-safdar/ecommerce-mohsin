{{-- filament/resources/login-activity/view.blade.php --}}
<x-filament::page>
    <x-filament::modal :opened="true">
        <x-slot name="heading">
            Login Activity Details
        </x-slot>

        <x-filament::form wire:submit.prevent="save">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-filament::form-field :label="__('User Name')">
                    <x-filament::input :value="$record->user->name" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('IP Address')">
                    <x-filament::input :value="$record->ip_address" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Location')">
                    <x-filament::input :value="$record->location" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('ISP')">
                    <x-filament::input :value="$record->isp" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Platform')">
                    <x-filament::input :value="$record->platform" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Device Type')">
                    <x-filament::input :value="$record->device_type" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Browser')">
                    <x-filament::input :value="$record->browser" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Session Hash')">
                    <x-filament::input :value="$record->session_hash" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('User Agent')">
                    <x-filament::textarea :value="$record->user_agent" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Notified')">
                    <x-filament::toggle :checked="$record->is_notified" disabled />
                </x-filament::form-field>

                <x-filament::form-field :label="__('Logged At')">
                    <x-filament::input :value="$record->created_at->format('Y-m-d H:i:s')" disabled />
                </x-filament::form-field>
            </div>

            <x-slot name="footer">
                <x-filament::button wire:click="closeModal" class="w-full sm:w-auto">
                    Close
                </x-filament::button>
            </x-slot>
        </x-filament::form>
    </x-filament::modal>
</x-filament::page>