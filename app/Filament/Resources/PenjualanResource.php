<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pelanggan_id')
                    ->label('Pilih Pelanggan')
                    ->options(Pelanggan::all()->pluck('nama', 'id')) // Menampilkan nama pelanggan di form
                    ->required(),
                
                Forms\Components\DatePicker::make('tanggal_penjualan')
                    ->label('Tanggal Penjualan')
                    ->required(),
                
                Forms\Components\TextInput::make('total_harga')
                    ->label('Total Harga')
                    ->numeric()
                    ->required(),
                
                Forms\Components\TextInput::make('dibuat_oleh')
                    ->label('Dibuat Oleh')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pelanggan.nama') // Menggunakan relasi untuk menampilkan nama pelanggan
                    ->label('Nama Pelanggan'),
                
                Tables\Columns\TextColumn::make('tanggal_penjualan')
                    ->label('Tanggal Penjualan'),
                
                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga'),

                Tables\Columns\TextColumn::make('dibuat_oleh')
                    ->label('Dibuat Oleh'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportExcel')
                    ->label('Export to Excel')
                    ->action(function () {
                        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PenjualanExport, 'penjualan.xlsx');
                    }),

                Tables\Actions\Action::make('exportPdf')
                    ->label('Export to PDF')
                    ->action(function () {
                        $penjualans = Penjualan::with('pelanggan')->get(); // Mengambil data penjualan dengan relasi pelanggan
                        $pdf = \PDF::loadView('exports.penjualan_pdf', ['penjualans' => $penjualans]);
                        return $pdf->download('penjualan.pdf');
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
