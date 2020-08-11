<?php

namespace Tsung\NovaMaster\Nova;


use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Nova;
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
        'original_name'
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
            $this->when($request instanceof ResourceDetailRequest, function() {
                return new Panel(
                    class_basename($this->documents), [
                        Text::make("Name", function() {
                            // check function ada atau tidak jika tidak ada baru panggil variable
                            $resource = Nova::resourceForModel($this->resource->documents);
                            $url = config('nova.path') . "/resources/{$resource::uriKey()}/{$this->documents->id}";
                            return "<a href='{$url}' class='no-underline font-bold dim text-primary'>{$this->documents->name}</a>";
                        })->asHtml(),
                    ]
                );
            }),

            Text::make('Filename')
                ->displayUsing(function() {
                    return $this->original_name;
                }),

            Text::make('Mime Type', function() {
                return $this->mimeType;
            })->onlyOnDetail()->canSee(function() use ($request) {
                return $request->user()->administrator();
            }),

            Image::make('File')
                ->hideFromIndex()
                ->prunable()
                ->storeOriginalName('original_name')
                ->storeSize('original_size')
                ->preview( function () {

                    // jika file mime tidak termasuk yang dibawah maka tampilkan gambar no image
                    // pada firefox dan chrome tidak bisa menampikan file pdf
                    // pada safari tidak ada masalah seperti ini.. mungkin safari ada extension khusus!
                    $acceptedType = config('novamaster.document.accepted_type');

                    if( in_array($this->mimeType, $acceptedType) ) {

                        return $this->value;

                    }

                    return $this->noImage;

                }),

            DateTime::make('Created At')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

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
