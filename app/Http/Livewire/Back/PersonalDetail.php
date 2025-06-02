<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
use Livewire\Component;

class PersonalDetail extends Component
{
    public $name;

    public $username;

    public $email;

    public $telp;

    public $bio;

    public $alamat;

    public $tmp_lahir;

    public $tgl_lahir;

    public $jenis_kelamin;

    public function mount()
    {
        $user = User::find(auth()->user()->id);
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->telp = $user->telp;
        $this->bio = $user->bio;
        $this->alamat = $user->alamat;
        $this->tmp_lahir = $user->tmp_lahir;
        $this->tgl_lahir = $user->tgl_lahir;
        $this->jenis_kelamin = $user->jenis_kelamin;
    }

    public function updatePersonalDetail()
    {
        $this->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username,' . auth('web')->id(),
            'email' => 'required|email|unique:users,email,' . auth('web')->id(),
            'telp' => 'required|numeric',
            'bio' => 'required',
            'alamat' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'username.required' => 'Username wajib diisi',
            'email.required' => 'Email wajib diisi',
            'telp.required' => 'No Hp wajib diisi',
            'bio.required' => 'Bio wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'tmp_lahir.required' => 'Tempat Lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'telp.numeric' => 'No Hp harus berisi angka',
            'email.email' => 'Email tidak valid',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib diisi',
        ]);

        User::whereId(auth()->user()->id)->update([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'telp' => $this->telp,
            'bio' => $this->bio,
            'alamat' => $this->alamat,
            'tmp_lahir' => $this->tmp_lahir,
            'tgl_lahir' => $this->tgl_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->log('Updated personal detail');

        $this->emit('updateUserProfile');
        $this->emit('updateTopHeader');
        $this->emit('updateUserProfileSide');
        $this->showToastr('Personal detail successfuly updated', 'success');
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
        return view('livewire.back.personal-detail');
    }
}
