<?php


namespace Tsung\NovaMaster\Helpers;


use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class SpatieMediaCustomDirectory implements PathGenerator
{

    public function getPath(Media $media): string
    {
        return $this->getModelName($media) . "/{$media->model->identity}/";
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getModelName($media) . "/{$media->model->identity}/conversions/";
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getModelName($media) . "/{$media->model->identity}/responsive-images/";
    }

    private function getModelName($media)
    {
        return class_basename($media->model);
    }
}
