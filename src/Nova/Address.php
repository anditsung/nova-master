<?php

namespace Tsung\NovaMaster\Nova;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Tsung\NovaUserManagement\Traits\ResourceAuthorization;
use Tsung\NovaUserManagement\Traits\ResourceRedirectIndex;

class Address extends Resource
{
    use ResourceAuthorization;
    use ResourceRedirectIndex;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Tsung\NovaMaster\Models\Address::class;

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
        'type',
        'address',
    ];

    public static $group = "Master";

    public static $displayInNavigation = false;

    public static $globallySearchable = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            //ID::make(__('ID'), 'id')->sortable(),

//            $this->when($request instanceof ResourceDetailRequest, function() {
//                return new Panel(
//                    class_basename($this->addresses), [
//                        Text::make('Name', function() {
//                            $resource = Nova::resourceForModel($this->resource->addresses);
//                            $url = config('nova.path') . "/resources/{$resource::uriKey()}/{$this->addresses->id}";
//                            return "<a href='{$url}' class='no-underline font-bold dim text-primary'>{$this->addresses->name}</a>";
//                        })->asHtml(),
//                    ]
//                );
//            }),

            $this->when( !$request->viaResource, function() {
                return MorphTo::make('Addresses')
                    ->searchable()
                    ->types(config('novamaster.address.morph'));
            }),

            Select::make(__('Type'))
                ->rules('required')
                ->options(config('novamaster.address.types'))
                ->displayUsingLabels(),

            Textarea::make('Address')
                ->displayUsing( function($value) use ($request) {
                    if ($request instanceof ResourceIndexRequest) {
                        return Str::limit($value, 40);
                    }
                    return $value;
                })
                ->showOnIndex()
                ->alwaysShow()
                ->rules('required'),

            Hidden::make('user_id')
                ->default($request->user()->id),

            DateTime::make('Created At')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->format('DD MMMM Y, hh:mm:ss A')
                ->onlyOnDetail(),

            BelongsTo::make('Created By', 'user', User::class)
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

//    public function authorizedToView(Request $request)
//    {
//        if ($request->viaResource) {
//            return false;
//        }
//
//        return $this->hasPermission($request, 'view ' . parent::uriKey());
//    }
//
//    public function authorizedToUpdate(Request $request)
//    {
//        if ($request->viaResource) {
//            return false;
//        }
//
//        return $this->hasOwnPermission($request, 'update ' . parent::uriKey());
//    }
//
//    public function authorizedToDelete(Request $request)
//    {
//        if ($request->viaResource) {
//            return false;
//        }
//
//        return $this->hasOwnPermission($request, 'delete ' . parent::uriKey());
//    }
}
