
<nova-sidebar>
    <template>
        <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
            <path fill="var(--sidebar-icon)" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
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
