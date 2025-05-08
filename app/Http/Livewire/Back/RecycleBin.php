<?php

namespace App\Http\Livewire\Back;

use App\Models\CeremonialEvent;
use App\Models\Event;
use App\Models\Weddings;
use App\Models\Decorations;
use App\Models\LiveMusic;
use App\Models\SoundSystem;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class RecycleBin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $search = '';
    public $type = 'all';
    public $startDate = null;
    public $endDate = null;
    protected $listeners = ['forceDeleteAction', 'forceDeleteWeddingAction', 'forceDeleteDecorationAction', 'forceDeleteSoundSystemAction', 'forceDeleteLiveMusicAction', 'forceDeleteCeremonialEventAction'];


    public function resetDates()
    {
        $this->startDate = null;
        $this->endDate = null;
    }
    public function mount()
    {
        $this->type = 'all';
    }
    public function updatingType()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        $event = Event::withTrashed()->find($id);

        if ($event) {
            $event->restore();
            flash()->addSuccess('Event has been restored successfully!');
        }
    }

    public function restoreWedding($id)
    {
        $wedding = Weddings::withTrashed()->find($id);

        if ($wedding) {
            $wedding->restore();
            flash()->addSuccess('Wedding has been restored successfully!');
        }
    }

    public function restoreDecoration($id)
    {
        $decoration = Decorations::withTrashed()->find($id);

        if ($decoration) {
            $decoration->restore();
            flash()->addSuccess('Decoration has been restored successfully!');
        }
    }

    public function restoreSoundSystem($id)
    {
        $soundSystem = SoundSystem::withTrashed()->find($id);

        if ($soundSystem) {
            $soundSystem->restore();
            flash()->addSuccess('Sound System has been restored successfully!');
        }
    }
    public function restoreLiveMusic($id)
    {
        $liveMusic = LiveMusic::withTrashed()->find($id);

        if ($liveMusic) {
            $liveMusic->restore();
            flash()->addSuccess('Live Music has been restored successfully!');
        }
    }
    public function restoreCeremonialEvent($id)
    {
        $ceremonialEvent = CeremonialEvent::withTrashed()->find($id);

        if ($ceremonialEvent) {
            $ceremonialEvent->restore();
            flash()->addSuccess('Ceremonial Event has been restored successfully!');
        }
    }
    public function forceDelete($id)
    {
        $event = Event::withTrashed()->find($id);
        if ($event) {
            $this->dispatchBrowserEvent('forceDelete', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this event permanently? ',
                'id' => $id,
            ]);
        }
    }

    public function forceDeleteDecoration($id)
    {
        $decoration = Decorations::withTrashed()->find($id);
        if ($decoration) {
            $this->dispatchBrowserEvent('forceDeleteDecoration', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this decoration permanently? ',
                'id' => $id,
            ]);
        }
    }

    public function forceDeleteWedding($id)
    {
        $wedding = Weddings::withTrashed()->find($id);
        if ($wedding) {
            $this->dispatchBrowserEvent('forceDeleteWedding', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this wedding permanently? ',
                'id' => $id,
            ]);
        }
    }
    public function forceDeleteSoundSystem($id)
    {
        $soundSystem = SoundSystem::withTrashed()->find($id);
        if ($soundSystem) {
            $this->dispatchBrowserEvent('forceDeleteSoundSystem', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this sound system permanently? ',
                'id' => $id,
            ]);
        }
    }

    public function forceDeleteLiveMusic($id)
    {
        $liveMusic = LiveMusic::withTrashed()->find($id);
        if ($liveMusic) {
            $this->dispatchBrowserEvent('forceDeleteLiveMusic', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this live music permanently? ',
                'id' => $id,
            ]);
        }
    }
    public function forceDeleteCeremonialEvent($id)
    {
        $ceremonialEvent = CeremonialEvent::withTrashed()->find($id);
        if ($ceremonialEvent) {
            $this->dispatchBrowserEvent('forceDeleteCeremonialEvent', [
                'title' => 'Are you sure?',
                'html' => 'Are you sure you want to delete this ceremonial event permanently? ',
                'id' => $id,
            ]);
        }
    }

    public function forceDeleteAction($id)
    {
        $event = Event::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/event/eventmakeup/';
        $image = $event->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_event = $event->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_event) {
            flash()->addSuccess('Event has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function forceDeleteWeddingAction($id)
    {
        $wedding = Weddings::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/wedding/weddingmakeup/';
        $image = $wedding->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_wedding = $wedding->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_wedding) {
            flash()->addSuccess('Wedding has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }
    public function forceDeleteDecorationAction($id)
    {
        $decoration = Decorations::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/decoration/';
        $image = $decoration->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_decoration = $decoration->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_decoration) {
            flash()->addSuccess('Decoration has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }

    public function forceDeleteSoundSystemAction($id)
    {
        $soundSystem = SoundSystem::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/soundSystem/';
        $image = $soundSystem->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_soundSystem = $soundSystem->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_soundSystem) {
            flash()->addSuccess('Sound System has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }
    public function forceDeleteLiveMusicAction($id)
    {
        $liveMusic = LiveMusic::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/liveMusic/';
        $image = $liveMusic->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_liveMusic = $liveMusic->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_liveMusic) {
            flash()->addSuccess('Live Music has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }
    public function forceDeleteCeremonialEventAction($id)
    {
        $ceremonialEvent = CeremonialEvent::withTrashed()->find($id);  // Use withTrashed() to find soft deleted records
        $path = 'back/images/ceremonial/';
        $image = $ceremonialEvent->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // delete resize image
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_75_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_75_' . $image);
            }
            // delete thumbnails
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_271_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_271_' . $image);
            }
            if (Storage::disk('public')->exists($path . 'thumbnails/thumb_' . $image)) {
                Storage::disk('public')->delete($path . 'thumbnails/thumb_' . $image);
            }


            // delete post featured image
            Storage::disk('public')->delete($path . $image);
        }

        $delete_ceremonialEvent = $ceremonialEvent->forceDelete();  // Use forceDelete() instead of delete()

        if ($delete_ceremonialEvent) {
            flash()->addSuccess('Ceremonial Event has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }


    public function render()
    {
        $queryBuilder = function ($query) {
            // Search filter
            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            }

            // Date filter
            if ($this->startDate && $this->endDate) {
                $query->whereDate('deleted_at', '>=', $this->startDate)
                    ->whereDate('deleted_at', '<=', $this->endDate);
            } elseif ($this->startDate) {
                $query->whereDate('deleted_at', '>=', $this->startDate);
            } elseif ($this->endDate) {
                $query->whereDate('deleted_at', '<=', $this->endDate);
            }
        };

        $events = Event::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'events', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'events', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);

        $weddings = Weddings::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'weddings', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'weddings', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);

        $decorations = Decorations::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'decorations', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'decorations', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);

        $soundSystems = SoundSystem::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'soundSystems', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'soundSystems', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);

        $liveMusic = LiveMusic::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'liveMusic', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'liveMusic', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);
        $ceremonialEvents = CeremonialEvent::onlyTrashed()
            ->when($this->type === 'all' || $this->type === 'ceremonialEvents', $queryBuilder)
            ->when($this->type === 'all' || $this->type === 'ceremonialEvents', function ($query) {
                return $query;
            }, function ($query) {
                return $query->whereRaw('1 = 0');
            })
            ->paginate($this->perPage);

        return view('livewire.back.recycle-bin', [
            'events' => $events,
            'weddings' => $weddings,
            'decorations' => $decorations,
            'soundSystems' => $soundSystems,
            'liveMusic' => $liveMusic,
            'ceremonialEvents' => $ceremonialEvents
        ]);
    }
}
