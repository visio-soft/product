<?php

namespace Visio\Product\Filament\Resources\IdeaCommentResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Visio\Product\Filament\Resources\IdeaCommentResource;

class ListIdeaComments extends ListRecords
{
    protected static string $resource = IdeaCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
