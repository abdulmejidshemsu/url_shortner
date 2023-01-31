<?php

namespace App\Http\Livewire;

use App\Models\Url;
use Filament\Forms;
use Livewire\Component;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class ShortUrlForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $destination;
    public $enforceHttps = false;
    public $enableTracking = true;

    public function mount(): void
    {
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Fieldset::make('Url Shortener')
                ->schema([
                    Forms\Components\TextInput::make('destination')
                        ->rules(['required', 'url', 'max:2048'])
                        ->columnSpan('full'),

                    Forms\Components\Toggle::make('enforceHttps'),
                    Forms\Components\Toggle::make('enableTracking'),
                ])


        ];
    }

    public function submit()
    {
        $data = $this->form->getState();

        // Generate Slug an check in database
        // if exist: generate another slug
        // else: Create URL
        do {
            $slug = Str::random(5);
        } while (Url::where('slug', $slug)->exists());

        Url::create([
            'user_id' => auth()->id(),
            'destination' => $data['destination'],
            'enforce_https' => $data['enforceHttps'],
            'enable_tracking' => $data['enableTracking'],
            'slug' => $slug
        ]);

        $this->reset();
        $this->emitTo('list-urls', '$refresh');

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.short-url-form');
    }
}
