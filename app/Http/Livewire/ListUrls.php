<?php

namespace App\Http\Livewire;

use App\Models\Url;
use Filament\Tables;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class ListUrls extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected $listeners = ['$refresh'];

    protected function getTableQuery(): Builder
    {
        return Url::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('destination')
                ->url(fn (Url $record): string => $record->destination)
                ->openUrlInNewTab()
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->description(fn (Url $record): string => route('short-url.show', $record))
                ->url(fn (Url $record): string => route('short-url.show', $record))
                ->openUrlInNewTab()
                ->searchable(),
            Tables\Columns\TextColumn::make('views')
                ->searchable(),
            Tables\Columns\ToggleColumn::make('enforce_https'),
            Tables\Columns\ToggleColumn::make('enable_tracking'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->toggleable(true, true),
            Tables\Columns\TextColumn::make('last_updated_at')->dateTime()->toggleable(true, true),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('enforce_https')
                ->query(fn (Builder $query): Builder => $query->where('enforce_https', true))
                ->toggle(),
            Filter::make('enable_tracking')
                ->query(fn (Builder $query): Builder => $query->where('enable_tracking', true))
                ->toggle(),
            Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->indicateUsing(function (array $data): array {
                    $indicators = [];

                    if ($data['from'] ?? null) {
                        $indicators['from'] = 'Created from ' . Carbon::parse($data['from'])->toFormattedDateString();
                    }

                    if ($data['until'] ?? null) {
                        $indicators['until'] = 'Created until ' . Carbon::parse($data['until'])->toFormattedDateString();
                    }

                    return $indicators;
                })
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
        ];
    }

    protected function getTableActions(): array
    {
        return [];
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('delete')
                ->action(fn (Collection $records) => $records->each->delete())
                ->deselectRecordsAfterCompletion()
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
        ];
    }

    public function render(): View
    {
        return view('livewire.list-urls');
    }
}
