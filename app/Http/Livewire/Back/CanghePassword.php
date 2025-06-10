<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CanghePassword extends Component
{
    public $current_password;
    public $new_password;
    public $confirm_password;

    public function ChangePassword()
    {
        $this->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth('web')->user()->password)) {
                        return $fail(__('Password lama salah'));
                    }
                },
            ],
            'new_password' => 'required|min:5|max:25',
            'confirm_password' => 'same:new_password',
        ], [
            'current_password.required' => 'Masukkan password lama',
            'new_password.required' => 'Masukkan password baru',
            'confirm_password.same' => 'Konfirmasi password harus sama dengan password baru',
        ]);

        $updated = User::find(auth('web')->id())->update([
            'password' => Hash::make($this->new_password),
        ]);

        if ($updated) {
            activity()->causedBy(auth()->user())->log('Updated password');

            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            $this->dispatchBrowserEvent('passwordChanged');
        } else {
            $this->dispatchBrowserEvent('showToast', [
                'type' => 'danger',
                'message' => 'Gagal mengubah password.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.back.canghe-password');
    }
}
