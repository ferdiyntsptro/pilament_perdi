<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function beforeSave(): void
    {
        $user = auth()->user();
        $oldPassword = $this->data['old_password'] ?? null;

        // Validasi password lama
        if (!Hash::check($oldPassword, $this->record->password)) {
            Notification::make()
                ->title('Password lama tidak cocok.')
                ->danger()
                ->send();

            $this->halt(); // Hentikan proses simpan jika password lama tidak cocok
        }

        // Update password jika ada password baru yang diinput dan konfirmasi cocok
        if (!empty($this->data['new_password']) && $this->data['new_password'] === $this->data['new_password_confirmation']) {
            $this->record->password = Hash::make($this->data['new_password']);
            $this->record->save();

            // Logout setelah password berhasil diubah
            Auth::logout();

            Notification::make()
                ->title('Password berhasil diubah. Silakan login kembali.')
                ->success()
                ->send();

            // Redirect ke halaman login setelah proses disimpan
            session()->flash('redirect', 'http://127.0.0.1:8000/admin');
        }
    }

    protected function afterSave(): void
    {
        if (session()->has('redirect')) {
            redirect()->to(session('redirect'));
        }
    }
}
