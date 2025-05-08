<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
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
                    if (! Hash::check($value, User::find(auth('web')->id())->password)) {
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

        $query = User::find(auth('web')->id())->update([
            'password' => Hash::make($this->new_password),
        ]);

        if ($query) {
            $this->showToastr('Your password has been successfuly updated.', 'success');
            $this->current_password = $this->new_password = $this->confirm_password = null;
        } else {
            $this->showToastr('Something went wrong', 'error');
        }
    }

    public function showToastr($message, $type)
    {
        return $this->dispatchBrowserEvent('showToastr', [
            'type' => $type,
            'message' => $message,
        ]);
    }

    public function render()
    {
        return view('livewire.back.canghe-password');
    }
}
