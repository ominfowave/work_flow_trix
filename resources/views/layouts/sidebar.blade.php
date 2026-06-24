<div id="left_sidebar_details" class="sidebar-left">
    <div class="sidebar-details"> 
        @php
            $user = auth()->guard('admin')->user();
        @endphp
        <ul>
            <li><a href="{{route('admin_dashboard')}}" id="dashboard_id" class="{{ request()->routeIs('admin_dashboard') ? 'active' : '' }}"><img src="{{asset('/images/dashboard-icon.svg')}}" alt=""><span>Dashboard</span></a></li>
            @if ($user->hasAnyPermission(['project-add', 'project-edit','project-delete', 'project-view']))
                <li>
                    <a href="{{route('project.index')}}" class="{{ request()->routeIs('project.*') ? 'active' : '' }}" id=""><img src="{{asset('/images/projects-icon.svg')}}" alt=""><span>Projects</span></a>
                </li>
            @endif

            @if ($user->hasAnyPermission(['client-add', 'client-edit','client-delete', 'client-view']))
                <li>
                    <a href="{{route('client.index')}}" id="" class="{{ request()->routeIs('client.*') ? 'active' : '' }}"><img src="{{asset('/images/clients-icon.svg')}}" alt=""><span>Clients</span></a>
                </li>
            @endif

            <li><a href="{{route('message.index')}}" id="" class="{{ request()->routeIs('message.*') ? 'active' : '' }}"><img src="{{asset('/images/message-icon.svg')}}" alt=""><span>Inbox</span></a></li>

            @if ($user->hasAnyPermission(['user-add', 'user-edit','user-delete', 'user-view']))
                <li>
                    <a href="{{route('admin.index')}}" id="" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}"><img src="{{asset('/images/users-icon.svg')}}" alt=""><span>Users</span></a>
                </li>
            @endif

            @if ($user->hasRole('Super-admin'))
                <li>
                    <a href="{{route('tech.index')}}" class="{{ request()->routeIs('tech.*') ? 'active' : '' }}"><img src="{{asset('/images/tech-icon.svg')}}" alt=""><span>Tech</span></a>
                </li>
            @endif

            @if ($user->hasRole('Super-admin'))
                <li>
                    <a href="{{route('role.index')}}" class="{{ request()->routeIs('role.*') ? 'active' : '' }}"><img src="{{asset('/images/role-icon.svg')}}" alt=""><span>Roles</span></a>
                </li>
            @endif
        </ul>
    </div>
</div>