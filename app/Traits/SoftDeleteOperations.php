<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SoftDeleteOperations
{
    public function handleImageDeletion($model, $path)
    {
        $image = $model->image;
        if ($image != null && Storage::disk('public')->exists($path . $image)) {
            // Delete thumbnails
            $thumbnailSizes = ['75', '271', ''];
            foreach ($thumbnailSizes as $size) {
                $thumbnailPath = $path . 'thumbnails/thumb_' . ($size ? $size . '_' : '') . $image;
                if (Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
            }

            // Delete main image
            Storage::disk('public')->delete($path . $image);
        }
    }

    public function handleForceDelete($model, $path, $type)
    {
        $this->handleImageDeletion($model, $path);
        $deleted = $model->forceDelete();

        if ($deleted) {
            flash()->addSuccess(ucfirst($type) . ' has been successfully deleted!');
        } else {
            flash()->addError('Something went wrong!');
        }
    }
}
