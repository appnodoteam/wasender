<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\NumberResource;
use Filament\Resources\Pages\Page;

class SendMessage extends Page
{
    protected static string $resource = NumberResource::class;

    protected static string $view = 'filament.resources.number-resource.pages.send-message';
}
