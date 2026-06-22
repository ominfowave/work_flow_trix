@extends('layouts.main')
@section('title', 'Clients')

@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create client -->
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <h2>Clients</h2>
                    @if (auth()->guard('admin')->user()->can('client-add'))
                        <a href="{{route('client.create')}}">
                            <button type="button" class="create-project-btn">
                                <img src="{{asset('/images/plus-icon.svg')}}" alt="">Create Client
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
                    @if (count($clients))
                        @foreach ($clients as $item)
                            <div class="projectsdetails">
                                <div class="project-desc client_project-desc">
                                    <div class="project-name-dt cient_project-name-dt">
                                        <div class="project-name"><p>{{$item->name ?? ''}}</p></div>
                                        <div class="client_edit_remove_details">
                                            <div class="toggle-container">
                                                <label class="cust_switch">
                                                    <input type="checkbox" class="jsStatus" data-title="Client" data-id="{{$item->id ?? ''}}" data-href="{{route('clientStatus')}}" {{$item->status == 'active' ? 'checked' : ''}} />
                                                    <span class="cust_slider"></span>
                                                </label>
                                            </div>
                                            <div class="edit-delete-btn">
                                                @if (auth()->guard('admin')->user()->can('client-edit'))
                                                    <a href="{{route('client.edit', $item->id)}}">
                                                        <button class="edit-profile-btn"><img src="{{asset('/images/edit-icon.svg')}}" alt="">Edit Profile</button>
                                                    </a>
                                                @endif

                                                {{-- @if (auth()->guard('admin')->user()->can('client-delete'))
                                                    <button class="delete-profile-btn jsDelete" data-title="Client" data-id="{{$item->id}}" data-href="{{route('client.destroy', $item->id)}}"><img src="{{asset('/images/delete-icon.svg')}}" alt="">Delete</button>
                                                @endif --}}
                                                    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="client_email_mobile">
                                        <p>{{$item->email ?? ''}}</p>
                                        <p>{{$item->phone ?? ''}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                </div>
            </div>
        <!-- end create client -->
    </div>
    <!-- end New Message -->

@endsection