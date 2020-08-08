@canany(collect(config('novamaster.resources'))->map(function ($resource) { return 'viewAny ' . $resource::uriKey();}))
<nova-sidebar>
    <template>
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill="var(--sidebar-icon)" d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
        </svg>
        <span class="sidebar-label">
            {{ __('Master Data') }}
    </span>
    </template>

    <template v-slot:menu>
        @foreach( config('novamaster.resources') as $resource )
            @can( 'viewAny ' . $resource::uriKey() )
                <li class="leading-wide mb-4 text-sm">
                    <router-link
                        :to="{
                            name: 'index',
                            params: {
                                resourceName: '{{ $resource::uriKey() }}'
                            },
                        }"
                        class="text-white ml-8 no-underline dim"
                    >
                        {{ __($resource::label())  }}
                    </router-link>
                </li>
            @endcan
        @endforeach
    </template>

</nova-sidebar>
@endcanany
