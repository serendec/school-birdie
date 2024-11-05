<?php

namespace App\Helpers;

class Helper {
    public static function getImagesPathsArray($model, $category, $schoolId) {
        $images = explode(',', $model->images);
        $imagePaths = [];

        foreach ($images as $image) {
            $imagePaths[] = 'storage/media/' . $category . '/' . $schoolId . '/' . $model->id . '/' . $image;
        }

        return $imagePaths;
    }
}
