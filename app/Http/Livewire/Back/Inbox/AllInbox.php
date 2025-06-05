<?php

namespace App\Http\Livewire\Back\Inbox;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class AllInbox extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;

    public $contact;

    public $listeners = [
        'resetModalForm',
        'deleteInboxAction',
    ];
    public function mount()
    {
        if (!auth()->user()->can('read contact')) {
            abort(403);
        }
    }
    public function deleteInbox($id)
    {
        $inbox = Contact::find($id);
        $this->dispatchBrowserEvent('deleteInbox', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete <b>' . $inbox->name . '</b> name',
            'id' => $id,
        ]);
    }

    public function deleteInboxAction($id)
    {
        $inbox = Contact::where('id', $id)->first();
        $inbox->delete();
        $this->showToastr('Inbox has been successfuly deleted.', 'info');
        // Log aktivitas
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted inbox');
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
        return view('livewire.back.inbox.all-inbox', [
            'inboxes' => Contact::orderBy('created_at', 'desc')->paginate($this->perPage),
        ]);
    }
}
