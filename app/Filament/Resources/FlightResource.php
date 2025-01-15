<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlightResource\Pages;
use App\Filament\Resources\FlightResource\RelationManagers;
use App\Filament\Resources\FlightResource\RelationManagers\PassengersRelationManager;
use App\Models\Flight;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class FlightResource extends Resource
{
    protected static ?string $model = Flight::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('number')->required(),
                Forms\Components\Select::make('airplane_id')->relationship('airplane', 'typ'),
                Forms\Components\Select::make('start_airport_id')->relationship('start', 'short_name'),
                Forms\Components\Select::make('end_airport_id')->relationship('end', 'short_name'),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('start.short_name'),
                Tables\Columns\TextColumn::make('end.short_name'),
                Tables\Columns\TextColumn::make('Status '),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            ->actions([
                Tables\Actions\EditAction::make(), // Standard "Bearbeiten" Aktion
                Action::make('changeStatus')       // Deine benutzerdefinierte Aktion
                    ->label('Status ändern')
                    ->icon('heroicon-o-refresh')
                    ->action(function (Flight $flight) {
                        try {
                            // Beispiel: Wechsle den Status auf 'boarding'
                            $flight->changeStatus('boarding');
                            alert()->success('Status erfolgreich geändert');
                        } catch (\Exception $e) {
                            alert()->error($e->getMessage());
                        }
                    })
                    ->color('primary'),
                ]);
    }

    public static function getRelations(): array
    {
        return [
            PassengersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFlights::route('/'),
            'create' => Pages\CreateFlight::route('/create'),
            'edit' => Pages\EditFlight::route('/{record}/edit'),
        ];
    }
}
