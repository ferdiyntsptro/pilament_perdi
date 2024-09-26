<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_produk')
                    ->label('Nama Produk')
                    ->required()
                    ->maxLength(255),
    
                Forms\Components\TextInput::make('harga')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->maxLength(10)
                    ->step(0.01),
    
                Forms\Components\TextInput::make('stok')
                    ->label('Stok')
                    ->required()
                    ->integer()
                    ->maxLength(11),
            ]);
    }
    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            Tables\Columns\TextColumn::make('nama_produk')
                ->label('Nama Produk')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('harga')
                ->label('Harga')
                ->sortable()
                ->money('idr', true), // Adjust currency if needed

            Tables\Columns\TextColumn::make('stok')
                ->label('Stok')
                ->sortable(),
        ])
        ->filters([
            // Add any filters if needed
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])
        ->headerActions([
            // Aksi ekspor ke Excel
            Tables\Actions\Action::make('exportExcel')
                ->label('Export to Excel')
                ->action(function () {
                    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ProdukExport, 'produk.xlsx');
                }),
                
            // Aksi ekspor ke PDF
            Tables\Actions\Action::make('exportPdf')
                ->label('Export to PDF')
                ->action(function () {
                    $produks = Produk::all();
                    $pdf = \PDF::loadView('exports.produk_pdf', ['produks' => $produks]);
                    return $pdf->download('produk.pdf');
                }),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}