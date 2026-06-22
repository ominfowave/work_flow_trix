@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create users -->
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <h2>Users</h2>
                    @if (auth()->guard('admin')->user()->can('user-add'))
                        <a href="{{route('admin.create')}}">
                            <button type="button" class="create-project-btn">
                                <img src="{{asset('/images/plus-icon.svg')}}" alt="">Create Users
                            </button>
                        </a>
                    @endif
                </div>
                <div class="projectsmain">
                    @if(session('success'))
                        <div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>{{ session('success') ?? '' }}</span>
                        </div>
                    @endif
                    @if (count($admins))
                        @foreach ($admins as $admin)
                            <div class="projectsdetails">
                                <div class="client_project-desc">
                                    <div class="admin-clients-left admin-users">
                                        <div class="project-name-dt cient_project-name-dt">
                                            <div class="project-name"><p>{{ $admin->name ?? ''}} - {{$admin->role->name ?? ''}}</p></div>
                                        </div>
                                    </div>

                                    <div class="admin-clients-right">
                                        <div class="client_edit_remove_details">
                                            <div class="toggle-container">
                                                <label class="cust_switch">
                                                    <input type="checkbox" class="jsStatus" data-title="User" data-id="{{$admin->id ?? ''}}" data-href="{{route('adminStatus')}}" {{$admin->status == 'active' ? 'checked' : ''}} />
                                                    <span class="cust_slider"></span>
                                                </label>
                                            </div>
                                            <div class="edit-delete-btn">
                                                
                                                @if (auth()->guard('admin')->user()->can('user-edit'))
                                                    <a href="{{route('admin.edit', $admin->id)}}">
                                                        <button class="edit-profile-btn"><img src="{{asset('/images/edit-icon.svg')}}" alt="">Edit Profile</button>
                                                    </a>
                                                @endif

                                                @if (auth()->guard('admin')->user()->can('user-delete'))
                                                    <button class="delete-profile-btn jsDelete" data-title="User" data-id="{{$admin->id}}" data-href="{{route('admin.destroy', $admin->id)}}"><img src="{{asset('/images/delete-icon.svg')}}" alt="">Delete</button>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        <!-- end create users -->
    </div>
    <!-- end New Message -->
@endsection