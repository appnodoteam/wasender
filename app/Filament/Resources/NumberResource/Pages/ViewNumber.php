<?php

namespace App\Filament\Resources\NumberResource\Pages;

use App\Filament\Resources\NumberResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNumber extends ViewRecord
{
    protected static string $resource = NumberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
