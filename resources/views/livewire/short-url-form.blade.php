<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-button target="submit" wire:click="submit" class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 mt-5">
            {{ __('Save') }}
        </x-button>

    </form>

</div>
