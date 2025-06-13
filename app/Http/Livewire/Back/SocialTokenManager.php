<?php

namespace App\Http\Livewire\Back;

use App\Models\SocialToken;
use Illuminate\Support\Carbon;
use Livewire\Component;

class SocialTokenManager extends Component
{
    public $tokens, $provider, $access_token, $expires_at, $editId = null;

    protected $rules = [
        'provider' => 'required|string',
        'access_token' => 'required|string',
        'expires_at' => 'nullable|date',
    ];

    protected $listeners = ['editToken' => 'edit', 'resetForm' => 'resetForm'];

    public function mount()
    {
        $this->loadTokens();
    }

    public function loadTokens()
    {
        $this->tokens = SocialToken::all();
    }

    public function save()
    {
        $this->validate();

        SocialToken::updateOrCreate(
            ['id' => $this->editId],
            [
                'provider' => $this->provider,
                'access_token' => $this->access_token,
                'expires_at' => $this->expires_at ? Carbon::parse($this->expires_at) : null,
            ]
        );

        flash()->addSuccess('Token berhasil disimpan.');
        $this->resetForm();
        $this->loadTokens();

        $this->dispatchBrowserEvent('close-modal');
    }

    public function edit($id)
    {
        $token = SocialToken::findOrFail($id);
        $this->editId = $token->id;
        $this->provider = $token->provider;
        $this->access_token = $token->access_token;
        $this->expires_at = optional($token->expires_at)->format('Y-m-d\TH:i');

        $this->dispatchBrowserEvent('show-modal');
    }

    public function delete($id)
    {
        SocialToken::findOrFail($id)->delete();
        $this->loadTokens();
        flash()->addSuccess('Token berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->editId = null;
        $this->provider = '';
        $this->access_token = '';
        $this->expires_at = '';
    }
    public function render()
    {
        return view('livewire.back.social-token-manager');
    }
}
