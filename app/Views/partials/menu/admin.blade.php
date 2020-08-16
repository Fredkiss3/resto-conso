<!-- BEGIN Left Aside -->
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
           data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ base_url() . '/img/logo.png' }}" style="width: 30px;height: 30px;" alt="SmartAdmin WebApp"
                 aria-roledescription="logo">
            <span class="page-logo-text mr-1">GI-INPHB</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>

    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control"
                       tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off"
                   data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="{{ base_url() . $user->photo }}"
                 class="profile-image rounded-circle"
                 alt="">
            <div class="info-card-text">
                <a href="{{ route_to('index') }}" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                        {{ $user->nom }} {{ $user->prenoms }}
                    </span>
                </a>
            </div>
            <img src="{{ base_url() . '/img/card-backgrounds/cover-2-lg.png' }}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
               data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>

        <ul id="js-nav-menu" class="nav-menu">
            @foreach($menu as $item)
                <li @if($item['active']) class="active open" @endif>
                    <a href="#" title="{{ $item['title'] }}" data-filter-tags="{{ $item['title'] }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="nav-link-text" data-i18n="nav.application_intel">{{ $item['title'] }}</span>
                    </a>
                    @if(!empty($item['sub']))
                        <ul>
                            @foreach($item['sub'] as $child)
                                <li @if($child['active']) class="active" @endif>
                                    <a href="{{ $child['url'] }}" title="{{ $child['title'] }}"
                                       data-filter-tags="{{ $item['title'] }} {{ $child['title'] }}">
                                    <span class="nav-link-text"
                                          data-i18n="nav.application_intel_privacy">{{ $child['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach

                        </ul>
                    @endif
                </li>
            @endforeach


        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify"
           class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="#" data-toggle="tooltip" data-placement="top" title="Paramètres">
                    <i class="fal fa-cog"></i>
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER -->
</aside>
<!-- END Left Aside -->