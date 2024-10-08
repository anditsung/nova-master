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
use Tsung\NovaUserManagement\Traits\ResourceAuthorization;
use Tsung\NovaUserManagement\Traits\ResourceRedirectIndex;

class Phone extends Resource
{
    use ResourceAuthorization;
    use ResourceRedirectIndex;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Tsung\NovaMaster\Models\Phone::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public function title()
    {
        if ($this->phones) return $this->phones->name;

        return $this->title;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'type',
        'number',
    ];

    public static $with = [
        'phones',
    ];

    public static $globallySearchable = false;

    public static $group = "Master";

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
//                    class_basename($this->phones), [
//                        Text::make('Name', function() {
//                            $resource = Nova::resourceForModel($this->resource->phones);
//                            $url = config('nova.path') . "/resources/{$resource::uriKey()}/{$this->phones->id}";
//                            return "<a href='{$url}' class='no-underline font-bold dim text-primary'>{$this->phones->name}</a>";
//                        })->asHtml(),
//                    ]
//                );
//            }),

            $this->when( !$request->viaResource, function() {
                return MorphTo::make(__('Phones'), 'phones')
                    ->searchable()
                    ->types(config('novamaster.phone.morph'));
            }),

//            Text::make('Name')
//                ->rules('required'),
            Select::make(__('Type'))
                ->rules('required')
                ->options(config('novamaster.phone.types'))
                ->displayUsingLabels(),

            Text::make('Number')
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
}
