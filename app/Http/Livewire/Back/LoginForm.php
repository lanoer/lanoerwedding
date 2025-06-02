<?php

namespace App\Http\Livewire\Back;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginForm extends Component
{
    public $login_id;

    public $password;

    public $returnUrl;

    public function mount()
    {
        $this->returnUrl = request()->returnUrl;
    }

    public function LoginHandler()
    {
        $fieldType = filter_var($this->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $rules = [
            'login_id' => 'required|exists:users,' . $fieldType,
            'password' => 'required|min:5',
        ];
        $messages = [
            'login_id.required' => 'Email or Username is required',
            'login_id.exists' => 'This ' . $fieldType . ' is not registered',
            'password.required' => 'Enter your password',
        ];

        if ($fieldType == 'email') {
            $rules['login_id'] .= '|email';
            $messages['login_id.email'] = 'Invalid email address';
        }

        $this->validate($rules, $messages);

        $creds = [$fieldType => $this->login_id, 'password' => $this->password];

        if (Auth::guard('web')->attempt($creds)) {
            $checkUser = User::where($fieldType, $this->login_id)->first();
            if ($checkUser->blocked == 1) {
                Auth::guard('web')->logout();
                return redirect()->route('auth.login')->with('fail', 'Your account has been blocked!');
            } elseif ($checkUser->verified == 0) {
                Auth::guard('web')->logout();
                return redirect()->route('auth.login')->with('fail', 'Akun anda belum diverifikasi, silahkan cek email anda');
            } elseif ($checkUser->isActive == 0) {
                Auth::guard('web')->logout();
                return redirect()->route('auth.login')->with('fail', 'Akun anda tidak aktif, silahkan hubungi administrator');
            } else {
                if ($this->returnUrl != null) {
                    return redirect()->to($this->returnUrl);
                } else {
                    activity()
                        ->causedBy(auth()->user())
                        ->log('Login success');
                    return redirect()->route('home');
                }
            }
        } else {
            session()->flash('fail', 'Incorrect Email/Username or Password');
            activity()
                ->causedBy(auth()->user())
                ->log('Failed login');
        }
    }

    public function render()
    {
        return view('livewire.back.login-form');
    }
}
