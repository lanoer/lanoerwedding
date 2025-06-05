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

    public $selectedInboxes = [];

    public $selectAll = false;

    public $listeners = [
        'resetModalForm',
        'deleteInboxAction',
        'deleteSelectedInboxAction'
    ];
    public function mount()
    {
        if (!auth()->user()->can('read contact')) {
            abort(403);
        }
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedInboxes = Contact::pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedInboxes = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selectedInboxes)) {
            $this->showToastr('Please select items to delete.', 'warning');
            return;
        }

        $this->dispatchBrowserEvent('deleteSelectedInbox', [
            'title' => 'Are you sure?',
            'html' => 'You want to delete ' . count($this->selectedInboxes) . ' selected items',
        ]);
    }

    public function deleteSelectedInboxAction()
    {
        Contact::whereIn('id', $this->selectedInboxes)->delete();
        $this->selectedInboxes = [];
        $this->selectAll = false;
        $this->showToastr('Selected inboxes have been successfully deleted.', 'info');
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
        activity()
            ->causedBy(auth()->user())
            ->log('Deleted inbox ' . $inbox->name);
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
