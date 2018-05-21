<nav id="sidebar" class="bg-dark text-light d-flex flex-column @if(Session::get('sidebar','true') == 'true') show @endif">
    <!-- Sidebar Header -->
    <h3 class="mb-4 mt-4" style="display:none">
        AcmEv
    </h3>

    <!-- Sidebar Links -->
    <ul class="list-unstyled">
        <li>
            <a class="text-light nav-link" href="{{URL::to('')}}"><i class="fa fa- fa-home d-block text-primary"></i><span>{{__('menu.home')}}</span></a>
        </li>
        @guest()
        <li>
            <a class="text-light nav-link" href="{{URL::to('degree/all')}}"><i class="fa fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.degrees')}}</span></a>
        </li>
        <li>
            <a class="text-light nav-link" href="{{URL::to('department/all')}}"><i class="fas fa- fa-address-book d-block text-primary"></i><span>{{__('menu.departments')}}</span></a>
        </li>
        @endguest
        @can('have_appointments')
            <li>
                <a class="text-light nav-link" href="{{URL::to('administration/calendar')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.calendar')}}</span></a>
            </li>
            <li>
                <a class="text-light nav-link" href="{{URL::to('administration/appointment-info')}}"><i class="fas fa- fa-info d-block text-primary"></i><span>{{__('menu.appointments-info')}}</span></a>
            </li>
        @endcan
        @if(!Auth::check() or Auth::user()->can('current'))
            <li>
                <a class="text-light nav-link" href="{{URL::to('calendar')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.calendar')}}</span></a>
            </li>
        @endif
        @role('admin')
        <li>
            <a class="text-light nav-link" href="{{URL::to('admin/systemconfig/edit')}}"><i class="fas fa- fa-cogs d-block text-primary"></i><span>{{__('menu.systemconfig')}}</span></a>
        </li>
        @endrole
        @role('pas')
        <li>
            <a class="text-light nav-link" href="{{URL::to('administration')}}"><i class="fas fa- fa-cogs d-block text-primary"></i><span>{{__('menu.administration')}}</span></a>
        </li>
        @endrole
        @can('teach')
            <li>
                <a class="text-light nav-link" href="{{URL::to('pdi/subject/list')}}"><i class="fas fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.subjects')}}</span></a>
            </li>
        @endcan
    </ul>

    <ul class="list-unstyled mt-auto">
        <hr class="border-light">

        <li class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               @if(App::isLocale('en')) <span class="full">English</span><span class="short">en</span> @else <span class="full">Español</span><span class="short">es</span> @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                @if(App::isLocale('en'))
                <a class="dropdown-item" href="{{URL::to('lang')}}/es"><span class="full">Español</span><span class="short">es</span></a>
                @else
                <a class="dropdown-item" href="{{URL::to('lang')}}/en"><span class="full">English</span><span class="short">en</span></a>
                @endif
            </div>
        </li>

        <hr class="border-light">

        @if(Auth::check())
            <li>
                <a class="text-light nav-link" href="{{route('logout')}}"><i class="fas fa-2x fa-sign-out-alt d-block text-warning"></i><span>{{__('auth.logout')}}</span></a>
            </li>
        @else
            <li>
                <a class="text-light nav-link" href="javascript:void(0)" data-toggle="modal" data-target="#loginModal"><i class="fas fa-2x fa-sign-in-alt d-block text-success"></i><span>{{__('auth.login')}}</span></a>
            </li>
        @endif

    </ul>
</nav>
<div class="sidebar-btn @if(Session::get('sidebar','true') == 'true') show @endif" onClick="toggleSidebar()">
    <i class="fas fa-chevron-left left"></i>
    <i class="fas fa-chevron-right right"></i>
</div>
