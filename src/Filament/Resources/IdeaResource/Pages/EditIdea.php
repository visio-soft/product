<?php

namespace Visio\Product\Filament\Resources\IdeaResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Visio\Product\Filament\Resources\IdeaResource;

class EditIdea extends EditRecord
{
    protected static string $resource = IdeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\ViewAction::make(),
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
        ];
    }
}
