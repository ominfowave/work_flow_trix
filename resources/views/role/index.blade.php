@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create role -->
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <h2>Roles</h2>
                    <a href="{{route('role.create')}}">
                        <button type="button" class="create-project-btn">
                            <img src="{{asset('/images/plus-icon.svg')}}" alt="">Create Role
                        </button>
                    </a>
                </div>
                <div class="projectsmain">
                    @if(session('success'))
                        <div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>{{ session('success') ?? '' }}</span>
                        </div>
                    @endif
                    @if(count($roles) > 0)
                        @foreach($roles as $role)
                            <div class="projectsdetails">
                                <div class="client_project-desc">
                                    <div class="admin-role-left admin-users">
                                        <div class="project-name-dt cient_project-name-dt">
                                            <div class="project-name"><p>{{ $role->name }}</p></div>
                                        </div>
                                    </div>

                                    <div class="admin-role-right">
                                        <div class="client_edit_remove_details">
                                            <div class="toggle-container">
                                                <label class="cust_switch">
                                                    <input type="checkbox" class="jsStatus" data-title="Role" data-id="{{$role->id ?? ''}}" data-href="{{route('roleStatus')}}" {{$role->status == 'active' ? 'checked' : ''}} />
                                                    <span class="cust_slider"></span>
                                                </label>
                                            </div>
                                            <div class="edit-delete-btn">
                                                <a href="{{route('role.edit', $role->id)}}">
                                                    <button class="edit-profile-btn"><img src="{{asset('/images/edit-icon.svg')}}" alt="">Edit</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        <!-- end create role -->
    </div>
    <!-- end New Message -->
@endsection