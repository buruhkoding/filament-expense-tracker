<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('category_id')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('type', 'expense')
                    )
                    ->required()
                    ->native(false),
                Select::make('wallet_id')
                    ->relationship(name: 'wallet', titleAttribute: 'name')
                    ->required()
                    ->native(false),
                DatePicker::make('date')
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->prefixIcon('heroicon-m-calendar')
                    ->native(false),
                MoneyInput::make('amount')
                    ->required()
                    ->minValue(0)
                    ->step(500),
                Textarea::make('description')
                    ->rows(5)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('wallet.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->searchable()
                    ->sortable(),
                MoneyColumn::make('amount')
            ])
            ->filters([
                SelectFilter::make('category.name')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn(Builder $query) => $query->where('type', 'expense')
                    )
                    ->native(false),
                SelectFilter::make('wallet.name')
                    ->relationship(
                        name: 'wallet',
                        titleAttribute: 'name'
                    )
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
