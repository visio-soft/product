<?php

namespace Visio\Product\Filament\Resources\IdeaResource\Pages;

use Filament\Actions;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Visio\Product\Filament\Resources\IdeaResource;
use Visio\Product\Models\IdeaComment;

class ViewIdea extends ViewRecord
{
    protected static string $resource = IdeaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('react')
                ->label('Add Reaction')
                ->icon('heroicon-o-heart')
                ->color('danger')
                ->action(function ($record) {
                    $record->incrementReactions();
                    
                    Notification::make()
                        ->title('Reaction added!')
                        ->success()
                        ->send();
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Idea Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('importance')
                            ->badge(),

                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Submitted by'),

                        Infolists\Components\TextEntry::make('reactions_count')
                            ->label('Reactions')
                            ->icon('heroicon-o-heart'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->dateTime(),
                    ])
                    ->columns(3),

                Infolists\Components\Section::make('Context')
                    ->schema([
                        Infolists\Components\TextEntry::make('context')
                            ->label('Why is this needed?')
                            ->default('No context provided')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => ! empty($record->context)),

                Infolists\Components\Section::make('Comments')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('comments')
                            ->hiddenLabel()
                            ->schema([
                                Infolists\Components\TextEntry::make('user.name')
                                    ->label('User')
                                    ->weight('bold'),
                                
                                Infolists\Components\TextEntry::make('comment')
                                    ->label('Comment')
                                    ->columnSpanFull(),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->dateTime()
                                    ->label('Posted'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->headerActions([
                        Infolists\Components\Actions\Action::make('add_comment')
                            ->label('Add Comment')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->form([
                                Forms\Components\Textarea::make('comment')
                                    ->required()
                                    ->rows(3)
                                    ->label('Your comment'),
                            ])
                            ->action(function (array $data, $record) {
                                IdeaComment::create([
                                    'idea_id' => $record->id,
                                    'user_id' => auth()->id(),
                                    'comment' => $data['comment'],
                                ]);

                                Notification::make()
                                    ->title('Comment added!')
                                    ->success()
                                    ->send();

                                $this->refreshFormData(['comments']);
                            }),
                    ]),
            ]);
    }
}
