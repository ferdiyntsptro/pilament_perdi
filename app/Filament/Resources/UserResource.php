<?php
namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama'),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email'),

                // Field untuk memasukkan password lama
                Forms\Components\TextInput::make('old_password')
                    ->password()
                    ->label('Password Lama')
                    ->required(fn ($record) => auth()->user()->id === $record->id)
                    ->dehydrated(false), // Tidak menyimpan value ini

                // Field untuk password baru
                Forms\Components\TextInput::make('new_password')
                    ->password()
                    ->label('Password Baru')
                    ->rules(['nullable', Password::default()])
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                    ->nullable(),

                // Konfirmasi password baru
                Forms\Components\TextInput::make('new_password_confirmation')
                    ->password()
                    ->label('Konfirmasi Password Baru')
                    ->same('new_password')
                    ->dehydrated(false), // Jangan simpan ke database

                // Upload foto profil baru
                Forms\Components\FileUpload::make('profile_photo_path')
                    ->label('Ganti Foto Profil')
                    ->image()
                    ->directory('profile-photos')
                    ->maxSize(5120)
                    ->imagePreviewHeight('150')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo_path')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->width(50)
                    ->height(50),
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat pada')->date(),
            ])
            ->actions([
                // Tombol Edit, hanya untuk user biasa (bukan admin)
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->visible(fn ($record) => !auth()->user()->hasRole('admin')), // Hanya tampil untuk user non-admin
    
                // Tombol Reset Password untuk semua user (termasuk non-admin)
                Tables\Actions\Action::make('reset_password')
                    ->label('Reset Password')
                    ->action(function (User $record) {
                        $newPassword = '12345678'; // Password default
                        $record->update(['password' => Hash::make($newPassword)]);
    
                        // Kirim notifikasi saat password direset
                        Notification::make()
                            ->title('Password berhasil direset!')
                            ->body("Password baru untuk {$record->name} adalah: $newPassword")
                            ->send();
                    })
                    ->requiresConfirmation() // Tambahkan konfirmasi sebelum reset
                    ->visible(fn ($record) => true), // Tampil untuk semua user (admin dan non-admin)
    
                // Tombol Hapus hanya untuk admin
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->visible(fn ($record) => auth()->user()->hasRole('admin')),
            ]);
    }
    

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (auth()->user()->hasRole('admin')) {
            return $query;
        } else {
            return $query->where('id', auth()->id());
        }
    }
}
