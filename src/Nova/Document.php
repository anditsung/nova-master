<?php

namespace Tsung\NovaMaster\Nova;


use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Tsung\NovaHumanResource\Models\Person;
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
    public function title()
    {
        if ($this->documents instanceof Person) return $this->documents->name;
    }


    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'original_name'
    ];

    public static $with = [
        'documents',
    ];

    public static $group = "Master";

    public static $globallySearchable = false;

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
//            $this->when($request instanceof ResourceDetailRequest, function() {
//                return new Panel(
//                    class_basename($this->documents), [
//                        Text::make("Name", function() {
//                            // check function ada atau tidak jika tidak ada baru panggil variable
//                            $resource = Nova::resourceForModel($this->resource->documents);
//                            $url = config('nova.path') . "/resources/{$resource::uriKey()}/{$this->documents->id}";
//                            return "<a href='{$url}' class='no-underline font-bold dim text-primary'>{$this->documents->name}</a>";
//                        })->asHtml(),
//                    ]
//                );
//            }),

            $this->when( !$request->viaResource, function() {
                return MorphTo::make(__('Documents'), 'documents')
                    ->searchable()
                    ->types(config('novamaster.document.morph'));
            }),

            Text::make(__('Filename'))
                ->displayUsing(function() {
                    return $this->original_name;
                })->exceptOnForms(),

            Text::make(__('Mime Type'), function() {
                return $this->mimeType;
            })->onlyOnDetail()->canSee(function() use ($request) {
                return $request->user()->administrator();
            }),

            File::make(__('File'), 'file')
                ->rules('required')
                ->prunable()
                ->store( function ( Request $request, $model ) {

                    $savePath = "";

                    if($request->viaResource) {
                        $savePath = class_basename($request->viaResource()) . '/' . $request->viaResourceId;
                    } else {
                        $savePath = class_basename($this->documents) . '/' . $this->documents->id;
                    }

                    return [
                        'file' => $request->file->store($savePath, 'public'),
                        'original_name' => $request->file->getClientOriginalName(),
                        'original_size' => $request->file->getSize(),
                    ];
                })
                ->download(function () {
                    return Storage::disk('public')->download($this->file, $this->original_name);
                })
                ->onlyOnForms(),

            Image::make(__('File'), 'file')
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

                })
                ->onlyOnDetail(),

            Hidden::make('user_id')
                ->default($request->user()->id),

            DateTime::make(__('Created At'), 'created_at')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

            DateTime::make(__('Updated At'), 'updated_at')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

            BelongsTo::make(__("Created By"), 'user', User::class)
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

    public function authorizedToDelete(Request $request)
    {
        if ($request instanceof ResourceDetailRequest) {
            return false;
        }

        return $this->hasOwnPermission($request, 'delete ' . parent::uriKey());
    }

}
