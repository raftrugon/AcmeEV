<nav id="sidebar" class="bg-dark text-light d-flex flex-column">
    <!-- Sidebar Header -->
    <h3 class="mb-4 mt-4">
        AcmEv
    </h3>

    <!-- Sidebar Links -->
    <ul class="list-unstyled">
        <li>
            <a class="text-light nav-link" href="#"><i class="fa fa-2x fa-home d-block text-primary"></i>{{__('menu.home')}}</a>
        </li>
        <li>
            <a class="text-light nav-link" href="#"><i class="fa fa-2x fa-graduation-cap d-block text-primary"></i>{{__('menu.degrees')}}</a>
        </li>
        <li>
            <a class="text-light nav-link" href="#"><i class="fas fa-2x fa-address-book d-block text-primary"></i>{{__('menu.departments')}}</a>
        </li>
    </ul>

    <ul class="list-unstyled mt-auto">
        <hr class="border-light">

        <li class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               @if(App::isLocale('en')) English @else Español @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                @if(App::isLocale('en'))
                <a class="dropdown-item" href="{{URL::to('lang')}}/es">Español</a>
                @else
                <a class="dropdown-item" href="{{URL::to('lang')}}/en">English</a>
                @endif
            </div>
        </li>

        <hr class="border-light">

        @if(Auth::check())
            <li>
                <a class="text-light nav-link" href="{{route('logout')}}"><i class="fas fa-2x fa-sign-out-alt d-block text-warning"></i>{{__('auth.logout')}}</a>
            </li>
        @else
            <li>
                <a class="text-light nav-link" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><i class="fas fa-2x fa-sign-in-alt d-block text-success"></i>{{__('auth.login')}}</a>
            </li>
        @endif

    </ul>
</nav>
