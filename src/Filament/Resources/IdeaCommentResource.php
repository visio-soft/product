<?php

namespace Visio\Product\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Visio\Product\Filament\Resources\IdeaCommentResource\Pages;
use Visio\Product\Models\IdeaComment;

class IdeaCommentResource extends Resource
{
    protected static ?string $model = IdeaComment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Product';

    protected static ?int $navigationSort = 2;

    protected static ?string $label = 'Comment';

    protected static ?string $pluralLabel = 'Comments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('idea_id')
                            ->relationship('idea', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Idea'),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->required()
                            ->label('User'),

                        Forms\Components\Textarea::make('comment')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('idea.title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('User'),

                Tables\Columns\TextColumn::make('comment')
                    ->searchable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Posted'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('idea_id')
                    ->form([
                        Forms\Components\Select::make('idea_id')
                            ->relationship('idea', 'title')
                            ->searchable()
                            ->preload()
                            ->label('Idea'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['idea_id'],
                            fn ($query) => $query->where('idea_id', $data['idea_id'])
                        );
                    }),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIdeaComments::route('/'),
            'create' => Pages\CreateIdeaComment::route('/create'),
            'edit' => Pages\EditIdeaComment::route('/{record}/edit'),
        ];
    }
}
