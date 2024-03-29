<nav id="sidebar" class="bg-dark text-light d-flex flex-column @if(Session::get('sidebar','true') == 'true') show @endif">
    <!-- Sidebar Header -->
    <img class="menu-logo mx-auto my-3" src="{{URL::to(\App\SystemConfig::first()->getIcon())}}" alt="">

    <!-- Sidebar Links -->
    <div style="overflow-y:auto;direction:rtl">
    <ul class="list-unstyled" style="direction:ltr;overflow-x:hidden;">

        <!------------------------- TODOS ------------------------->
        <li>
            <a class="text-light nav-link" href="{{URL::to('')}}"><i class="fa fa- fa-home d-block text-primary"></i><span>{{__('menu.home')}}</span></a>
        </li>




        <!------------------------- NO LOGUEADOS ------------------------->
        @guest()
        <li>
            <a class="text-light nav-link" href="{{URL::to('degree/all')}}"><i class="fa fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.degrees')}}</span></a>
        </li>
        <li>
            <a class="text-light nav-link" href="{{URL::to('department/all')}}"><i class="fas fa- fa-address-book d-block text-primary"></i><span>{{__('menu.departments')}}</span></a>
        </li>
        @endguest




        <!------------------------- ROLES ------------------------->
        @role('admin')
        <li>
            <a class="text-light nav-link" href="{{URL::to('degree/all')}}"><i class="fa fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.degrees')}}</span></a>
        </li>
        <li>
            <a class="text-light nav-link" href="{{URL::to('admin/systemconfig/edit')}}"><i class="fas fa- fa-cogs d-block text-primary"></i><span>{{__('menu.systemconfig')}}</span></a>
        </li>
        <li>
            <a class="text-light nav-link" href="{{URL::to('users')}}"><i class="fas fa- fa-users d-block text-primary"></i><span>{{__('menu.users')}}</span></a>
        </li>
        @endrole
        @role('pas')
            @if($actual_state == 1 || $actual_state == 2)
            <li>
                <a href="#" class="text-light nav-link print-inscriptions"><i class="fas fa-address-book d-block text-primary"></i><span>{{__('menu.inscriptions.select')}}</span></a>
            </li>
            <a id="download_link" href="#" download="inscriptions" style="visibility:hidden"></a>
            @endif
        @endrole

        @role('student')
            @can('current')
                @if($actual_state > 2 && $actual_state < 10)
                    <li>
                        <a class="text-light nav-link" href="{{URL::to('student/my-subjects')}}"><i class="fas fa-book d-block text-primary"></i><span>{{__('menu.my.subjects')}}</span></a>
                    </li>
                @endif
                @if($actual_state > 4 && $actual_state < 10)
                    <li>
                        <a class="text-light nav-link" href="{{URL::to('group/student/schedule')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.student.schedule')}}</span></a>
                    </li>
                @endif
                <li>
                    <a class="text-light nav-link" href="{{URL::to('student/enrollment/my-enrollments')}}"><i class="fas fa-address-card d-block text-primary"></i><span>{{__('menu.enrollments')}}</span></a>
                </li>
                <li>
                    <a class="text-light nav-link" href="{{URL::to('student/minute/my-minutes')}}"><i class="fas fa-graduation-cap d-block text-primary"></i><span>{{__('menu.minutes')}}</span></a>
                </li>
            @endcan
        @endrole

        @role('pdi')
        <li>
            <a class="text-light nav-link" href="{{URL::to('department/all')}}"><i class="fas fa- fa-address-book d-block text-primary"></i><span>{{__('menu.departments')}}</span></a>
        </li>
        @endrole




        <!------------------------- PERMISOS ------------------------->
        @can('have_appointments')
            <li>
                <a class="text-light nav-link" href="{{URL::to('administration/calendar')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.calendar')}}</span></a>
            </li>
            <li>
                <a class="text-light nav-link" href="{{URL::to('administration/appointment-info')}}"><i class="fas fa- fa-info d-block text-primary"></i><span>{{__('menu.appointments-info')}}</span></a>
            </li>
        @endcan
        @can('teach')
            <li>
                <a class="text-light nav-link" href="{{URL::to('pdi/subject/list')}}"><i class="fas fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.subjects')}}</span></a>
            </li>
        @endcan
        @can('manage')
            <li>
                <a class="text-light nav-link" href="{{URL::to('degree/all')}}"><i class="fa fa- fa-graduation-cap d-block text-primary"></i><span>{{__('menu.degrees')}}</span></a>
            </li>
            @if($actual_state == 7 || $actual_state == 9)
                <li>
                    <a class="text-light nav-link" href="{{URL::to('management/student/list')}}"><i class="fas fa-file-alt d-block text-primary"></i><span>{{__('menu.minutes.edit')}}</span></a>
                </li>
            @endif
            @if($actual_state == 4)
                <li>
                    <a class="text-light nav-link" href="{{URL::to('group/manage/timetable')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.group.timetable')}}</span></a>
                </li>
            @endif
        @endcan



    <!------------------------- CALENDAR ------------------------->
        @if(!Auth::check() or Auth::user()->can('current'))
            <li>
                <a class="text-light nav-link" href="{{URL::to('calendar')}}"><i class="fas fa- fa-calendar d-block text-primary"></i><span>{{__('menu.calendar')}}</span></a>
            </li>
        @endif



    </ul>
    </div>


    {{------------------- PICKER DE IDIOMA -------------------}}

    <ul class="list-unstyled mt-auto">
        <hr class="border-light">

        <li class="btn-group" role="group">
            <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               @if(App::isLocale('en')) <span class="full">English</span><span class="short">en</span> @else <span class="full">Español</span><span class="short">es</span> @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="min-width: 100%!important;text-align:center;">
                @if(App::isLocale('en'))
                <a class="dropdown-item" href="{{URL::to('lang')}}/es"><span class="full">Español</span><span class="short">es</span></a>
                @else
                <a class="dropdown-item" href="{{URL::to('lang')}}/en"><span class="full">English</span><span class="short">en</span></a>
                @endif
            </div>
        </li>

        {{-----------------T&C & privacidad -------------}}
        <div class="tycprivacy-div">
        <hr class="border-light">

        <a class="menu-modal-link" data-izimodal-open="#tyc_modal">T&C</a>
        |
        <a class="menu-modal-link" data-izimodal-open="#privacy_modal">Cookies</a>
        </div>
        {{------------------- LOGIN -------------------}}

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

{{------------------- TOGGLE -------------------}}

<div class="sidebar-btn @if(Session::get('sidebar','true') == 'true') show @endif" onClick="toggleSidebar()">
    <i class="fas fa-chevron-left left"></i>
    <i class="fas fa-chevron-right right"></i>
</div>


@if($actual_state == 1 || $actual_state == 2)
    @section('scripts')
        <script>

            $(function(){
                $('.print-inscriptions').click(function(){
                    iziToast.question({
                        timeout: false,
                        zindex: 999,
                        title: '@lang('menu.inscriptions.select.title')',
                        message: '',
                        position: 'center',
                        color: '#17a2b8',
                        titleColor: 'white',
                        iconColor: 'white',
                        inputs:[
                            ['<select class="selectpicker" multiple data-style="btn-light" data-width="auto">  @foreach(\App\Degree::all() as $degree) <option value="{{$degree->getId()}}">{{$degree->getName()}}</option> @endforeach  </select>',true]
                        ],
                        buttons: [
                            ['<button style="color:white">@lang('global.go')</button>', function(instance,toast){
                                document.getElementById('download_link').click();
                                return true;
                            }],
                        ],
                        onOpened: function(){
                            $('.selectpicker').selectpicker('render');
                            $('.selectpicker').on('changed.bs.select',function(e){
                                $('#download_link').attr('href','{{URL::to('administration/inscription-list')}}?degree_ids='+$('.selectpicker').selectpicker('val'));
                            });
                        }
                    });
                });
            });

        </script>
    @endsection
@endif
