<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Rules\Cpf;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome Completo')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Endereço')
                    ->required(),
                Forms\Components\TextInput::make('cpf')
                    ->label('CPF')
                    ->required()
                    ->maxLength(14)
                    ->mask('999.999.999-99')
                    ->placeholder('000.000.000-00')
                    ->rules([new Cpf])
                    ->dehydrateStateUsing(fn ($state) => preg_replace('/[^0-9]/', '', $state)),
                Forms\Components\TextInput::make('phone')
                    ->label('Telefone para Contato')
                    ->placeholder('(00) 00000-0000')
                    ->mask('(99) 99999-9999')
                    ->tel()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('cpf')->label('CPF')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telefone'),
                Tables\Columns\TextColumn::make('created_at')->label('Cadastrado em')->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
