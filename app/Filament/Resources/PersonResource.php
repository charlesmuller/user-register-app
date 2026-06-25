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
                // Bloco 1: Mantém e organiza os Dados Pessoais existentes
                Forms\Components\Section::make('Dados Pessoais')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome Completo')
                            ->required(),

                        Forms\Components\TextInput::make('cpf')
                            ->label('CPF')
                            ->required()
                            ->maxLength(14)
                            ->mask('999.999.999-99')
                            ->placeholder('000.000.000-00')
                            ->rules([new Cpf])
                            ->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state)),

                        Forms\Components\TextInput::make('phone')
                            ->label('Telefone para Contato')
                            ->placeholder('(00) 00000-0000')
                            ->mask('(99) 99999-9999')
                            ->tel()
                            ->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state))
                            ->required(),
                    ])->columns(3), // Deixa Nome, CPF e Telefone na mesma linha em telas grandes

                // Bloco 2: Novo endereço estruturado que substitui o campo 'address' antigo
                Forms\Components\Section::make('Endereço')
                    ->relationship('address') // Faz a mágica de salvar os dados na tabela 'addresses'
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('cep')
                                ->label('CEP')
                                ->mask('99999-999')
                                ->placeholder('00000-000'),

                            Forms\Components\TextInput::make('street')
                                ->label('Rua/Avenida')
                                ->required(),

                            Forms\Components\TextInput::make('number')
                                ->label('Número')
                                ->required()
                                ->placeholder('Ex: 123 ou S/N'),
                        ]),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\TextInput::make('complement')
                                ->label('Complemento')
                                ->placeholder('Apt, Bloco, etc.'),

                            Forms\Components\TextInput::make('neighborhood')
                                ->label('Bairro')
                                ->required(),

                            Forms\Components\TextInput::make('city')
                                ->label('Cidade')
                                ->required(),
                        ]),

                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('state')
                                ->label('Estado (UF)')
                                ->maxLength(2)
                                ->placeholder('Ex: SP')
                                ->required(),

                            Forms\Components\TextInput::make('country')
                                ->label('País')
                                ->default('Brasil')
                                ->required(),
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // 1. Força a tabela a abrir SEMPRE do cadastro mais antigo para o mais novo
            ->defaultSort('created_at', 'asc')
            ->columns([
                // 2. Cria a coluna de Posição na Fila
                Tables\Columns\TextColumn::make('index')
                    ->label('Posição')
                    ->rowIndex(), // Essa é a mágica que enumera as linhas!

                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(), // 3. Removi o ->sortable() daqui para ninguém bagunçar a ordem da fila

                Tables\Columns\TextColumn::make('cpf')
                    ->label('CPF')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefone'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Cadastrado em')
                    ->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // DeleteBulkAction continua comentado, garantindo a Regra 1 (Não excluir)
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
