<?php

namespace App\Http\Livewire\Back;

use App\Models\CateringPackages;
use Livewire\Component;

class CateringList extends Component
{
    public $caterings;

    public function mount()
    {
        // Fetch all catering packages and include the count for both 'premiumCaterings' and 'mediumCaterings'
        $this->caterings = CateringPackages::withCount(['premiumCaterings', 'mediumCaterings'])->get();
    }

    // Method to delete a catering package
    public function delete($id)
    {
        $cateringPackage = CateringPackages::findOrFail($id);

        // Check if the catering package has any related records and if they are soft deleted
        if ($cateringPackage->premiumCaterings()->whereNull('deleted_at')->count() > 0 || $cateringPackage->mediumCaterings()->whereNull('deleted_at')->count() > 0) {
            // If related records exist and are not soft deleted, show an error message
            flash()->addError('Cannot delete Catering Package. Please delete the related premium or medium catering first.');
        } else {
            // If no related records or all related records are soft deleted, proceed with deletion
            $cateringPackage->delete();
            flash()->addSuccess('Catering Package deleted successfully.');
        }

        // Reload the list after deletion attempt
        $this->caterings = CateringPackages::withCount(['premiumCaterings', 'mediumCaterings'])->get();
    }

    public function render()
    {
        return view('livewire.back.catering-list');
    }
}
