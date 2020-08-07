<?php

namespace Tsung\NovaMaster\Nova;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tsung\NovaUserManagement\Traits\ResourceAuthorization;
use Tsung\NovaUserManagement\Traits\ResourceRedirectIndex;

class Document extends Resource
{
    use ResourceRedirectIndex,
        ResourceAuthorization;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Tsung\NovaMaster\Models\Document::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [

    ];

    public static $group = "Master";

    public static $globallySearchable = false;

    public static $displayInNavigation = false;

    public function fieldsForCreate(Request $request)
    {
        $model = $request->findParentModel();

        return [

            /**
             * jika path menggunakan identity akan bermaslaah dengan identity warga negara asing karena ada karakter /
             */
//            Image::make('File')
//                ->acceptedTypes('image/*,application/pdf,application/zip')
//                ->rules('required')
//                ->hideFromIndex()
//                ->prunable()
//                ->storeOriginalName('original_name')
//                ->storeSize('original_size')
//                ->path(class_basename($model) . '/' . $model->identity),
            File::make('File')
                ->hideFromIndex()
                ->prunable()
                ->storeOriginalName('original_name')
                ->storeSize('original_size')
                ->rules('required')
                ->path(class_basename($model) . '/' . $model->id),

            Hidden::make('user_id')
                ->default($request->user()->id),

            BelongsTo::make("Created By", 'user', User::class)
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Name')
                ->rules('required'),

            Text::make('Filename')
                ->displayUsing(function() {
                    return $this->original_name;
                }),

            Image::make('File')
                ->hideFromIndex()
                ->prunable()
                ->storeOriginalName('original_name')
                ->storeSize('original_size')
                ->preview( function ($value) {

                    // jika file mime tidak termasuk yang dibawah maka tampilkan gambar no image
                    $acceptedType = [
                        'image/apng',
                        'image/bmp',
                        'image/gif',
                        'image/x-icon',
                        'image/jpeg',
                        'image/png',
                        'image/svg+xml',
                        'image/tiff',
                        'image/webp',
                        'application/pdf',
                    ];

                    $fileMimeType = mime_content_type(storage_path("app/public/") . $value);

                    if( in_array($fileMimeType, $acceptedType) ) {

                        return $this->value;

                    }

                    return "/nova-vendor/nova-master/no-image";

                }),

            BelongsTo::make("Created By", 'user', User::class)
                ->onlyOnDetail(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

}
