@extends('filament::page')

@section('content')
    <div>
        <form wire:submit.prevent="save" class="space-y-6">
            {{ $this->form }}

            <div class="mt-4">
                <x-filament::button type="submit">
                    Save Environment
                </x-filament::button>
            </div>
        </form>
    </div>
@endsection
