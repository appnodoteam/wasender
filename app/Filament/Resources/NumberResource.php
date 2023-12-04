<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\RelationManagers\MessageRelationManager;
use App\Filament\Resources\NumberResource\Pages;
use App\Filament\Resources\NumberResource\RelationManagers;
use App\Filament\Resources\NumberResource\RelationManagers\MessagesRelationManager;
use App\Filament\Resources\NumberResource\RelationManagers\UserRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\NumberRelationManager;
use App\Models\V1\Number;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NumberResource extends Resource
{
    protected static ?string $model = Number::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->autofocus()
                    ->required()
                    ->hiddenOn(['edit'])
                    ->unique()
                    ->label(__('Número'))
                    ->placeholder(__('Número')),

                Forms\Components\TextInput::make('name')
                    ->label(__('Nombre'))
                    ->hint(__('Opcional, Nombre del número'))
                    ->placeholder(__('Nombre')),

                Forms\Components\Select::make('status')
                    ->required()
                    ->label(__('Estado'))
                    ->options([
                        'active' => __('Activo'),
                        'inactive' => __('Inactivo'),
                        'test' => __('Prueba'),
                    ])
                    ->placeholder(__('Status')),

                Forms\Components\TextInput::make('number_id')
                    ->label(__('Número ID'))
                    ->placeholder(__('Número ID generado por CloudAPI'))
                    ->placeholder(__('Número Meta ID')),

                Forms\Components\TextInput::make('waba_id')
                    ->label(__('WhatsApp Business ID'))
                    ->placeholder(__('WhatsApp Business ID')),

                Forms\Components\Select::make('user_id')
                    ->label(__('Usuario'))
                    ->helperText(__('Asignar a un usuario'))
                    ->searchable()
                    ->relationship('user', 'name')
                    ->placeholder(__('User ID')),

                Forms\Components\TextInput::make('api_version')
                    ->label(__('API Version'))
                    ->default('v1')
                    ->placeholder(__('API Version')),

                Forms\Components\Toggle::make('save_messages')
                    ->label(__('Guardar mensajes'))
                    ->default(false),

                Forms\Components\Toggle::make('save_media')
                    ->label(__('Guardar multimedia/archivos'))
                    ->default(false),


                Forms\Components\Textarea::make('token')
                    ->columnSpan(3)
                    ->label(__('Token Permanente'))
                    ->placeholder(__('Permanent Token')),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label(__('Nombre'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('id')
                    ->searchable()
                    ->label(__('Número'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->label(__('Estado'))
                    ->sortable(),


                Tables\Columns\ToggleColumn::make('save_messages')
                    ->label(__('Guardar mensajes'))
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('save_media')
                    ->label(__('Guardar archivos'))
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
            MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNumbers::route('/'),
            'create' => Pages\CreateNumber::route('/create'),
            'view' => Pages\ViewNumber::route('/{record}'),
            'edit' => Pages\EditNumber::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
