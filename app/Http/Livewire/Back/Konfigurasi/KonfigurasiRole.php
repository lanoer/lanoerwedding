<?php

namespace App\Http\Livewire\Back\Konfigurasi;

use App\Models\Role;
use Livewire\Component;

class KonfigurasiRole extends Component
{
    public $name;

    public $guard_name;

    public $selected_role_id;

    public $updateRoleMode = false;

    public $searchRole = '';

    public $listeners = [
        'resetModalForm',
        'deleteRoleAction',
    ];

    public function resetModalForm()
    {
        $this->resetErrorBag();
        $this->name = null;
        $this->guard_name = null;
    }

    public function addRole()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
            'guard_name' => 'required',
        ], [
            'name.required' => 'Role name wajib diisi',
            'guard_name.required' => 'Guard name wajib diisi',
            'name.unique' => 'Role name sudah ada',
        ]);
        $role = new Role();
        $role->name = $this->name;
        $role->guard_name = $this->guard_name;
        $saved = $role->save();

        if ($saved) {

            $this->dispatchBrowserEvent('hideRoleModal');
            $this->resetModalForm();
            flash()->addSuccess('New Role has been successfuly added.');
            activity()
                ->causedBy(auth()->user())
                ->log('Created role ' . $this->name);
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->selected_role_id = $role->id;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->updateRoleMode = true;
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('showroleModal');
    }

    public function updateRole()
    {
        if ($this->selected_role_id) {
            $this->validate([
                'name' => 'required|unique:roles,name,' . $this->selected_role_id,
                'guard_name' => 'required',
            ]);

            $role = Role::findOrFail($this->selected_role_id);
            $role->name = $this->name;
            $role->guard_name = $this->guard_name;
            $updated = $role->save();
            if ($updated) {
                $this->dispatchBrowserEvent('hideRoleModal');
                $this->updateRoleMode = false;
                flash()->addSuccess('Role has been successfuly updated.');
                activity()
                    ->causedBy(auth()->user())
                    ->log('Updated role ' . $this->name);
            } else {
                flash()->addError('Something went wrong!');
            }
        }
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        $this->dispatchBrowserEvent('deleteRole', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $role->name . '</b> role',
            'id' => $id,
        ]);
    }

    public function deleteRoleAction($id)
    {
        $role = Role::where('id', $id)->first();

        $role->delete();
        flash()->addInfo('Role has been successfuly deleted.');
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted role ' . $role->name);
    }

    public function render()
    {

        $roles = Role::when($this->searchRole, function ($query) {
            $query->where('name', 'like', '%' . $this->searchRole . '%');
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.back.konfigurasi.konfigurasi-role', compact('roles'));
    }
}
