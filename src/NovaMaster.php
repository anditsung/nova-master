<?php

namespace Tsung\NovaMaster;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaMaster extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-master', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-master', __DIR__.'/../dist/css/tool.css');

        Nova::resources( config('novamaster.resources') );
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-master::navigation');
    }
}
