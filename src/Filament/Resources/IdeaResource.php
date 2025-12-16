<?php

namespace Visio\Product\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Visio\Product\Enums\ImportanceLevel;
use Visio\Product\Filament\Resources\IdeaResource\Pages;
use Visio\Product\Models\Idea;

class IdeaResource extends Resource
{
    protected static ?string $model = Idea::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $navigationGroup = 'Product';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Idea Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('importance')
                            ->options(ImportanceLevel::class)
                            ->default(ImportanceLevel::NOT_IMPORTANT)
                            ->required()
                            ->native(false)
                            ->label('How important is this to you?'),

                        Forms\Components\Textarea::make('context')
                            ->rows(3)
                            ->columnSpanFull()
                            ->label('Why do you need this?')
                            ->helperText('Any context you provide will help us make this product better for you.'),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->default(fn () => auth()->id())
                            ->required()
                            ->label('Submitted by'),
                    ]),

                Forms\Components\Section::make('Engagement')
                    ->schema([
                        Forms\Components\TextInput::make('reactions_count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->visible(fn ($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->wrap()
                    ->limit(50),

                Tables\Columns\TextColumn::make('importance')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Submitted by'),

                Tables\Columns\TextColumn::make('reactions_count')
                    ->label('Reactions')
                    ->sortable()
                    ->alignCenter()
                    ->icon('heroicon-o-heart'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('importance')
                    ->options(ImportanceLevel::class)
                    ->multiple(),

                Tables\Filters\Filter::make('user_id')
                    ->form([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Submitted by'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['user_id'],
                            fn ($query) => $query->where('user_id', $data['user_id'])
                        );
                    }),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListIdeas::route('/'),
            'create' => Pages\CreateIdea::route('/create'),
            'view' => Pages\ViewIdea::route('/{record}'),
            'edit' => Pages\EditIdea::route('/{record}/edit'),
        ];
    }
}
