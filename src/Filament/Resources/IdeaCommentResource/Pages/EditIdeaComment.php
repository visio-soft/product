<?php

namespace Visio\Product\Filament\Resources\IdeaCommentResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Visio\Product\Filament\Resources\IdeaCommentResource;

class EditIdeaComment extends EditRecord
{
    protected static string $resource = IdeaCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
            \Filament\Actions\ForceDeleteAction::make(),
            \Filament\Actions\RestoreAction::make(),
        ];
    }
}
