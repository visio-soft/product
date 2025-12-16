<?php

namespace Visio\Product\Filament\Resources\IdeaResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Visio\Product\Filament\Resources\IdeaResource;

class ListIdeas extends ListRecords
{
    protected static string $resource = IdeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
