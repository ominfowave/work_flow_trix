@extends('layouts.main')
@section('title', 'Techs')

@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create tech -->
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <h2>Tech</h2>
                    <a href="{{route('tech.create')}}">
                        <button type="button" class="create-project-btn">
                            <img src="{{asset('/images/plus-icon.svg')}}" alt="">Create Tech
                        </button>
                    </a>
                </div>
                @if(session('success'))
                    <div class="custom-alert success-alert" style="margin-top: 55px;">
                        <span>{{ session('success') ?? '' }}</span>
                    </div>
                @endif
                <div class="-projectsmain">
                    <div class="admin-tech-main">
                        @if (count($techs) > 0)
                            @foreach ($techs as $tech)
                                <div class="admin-tech">
                                    <div class="language-description">
                                        @if (isset($tech->tech_icon))
                                            <img src="{{asset('/tech_image/'.$tech->tech_icon)}}" alt="" class="tech_icon">
                                        @endif
                                        <p>{{$tech->tech_name ?? ''}}</p>
                                    </div>
                                    <div class="language-edit-details">
                                        <div class="toggle-container">
                                            <label class="cust_switch">
                                                <input type="checkbox" class="jsStatus" data-title="Tech" data-id="{{$tech->id ?? ''}}" data-href="{{route('techStatus')}}" {{$tech->status == 'active' ? 'checked' : ''}} />
                                                <span class="cust_slider"></span>
                                            </label>
                                        </div>
                                        <div class="edit-delete-btn">
                                            <a href="{{route('tech.edit', $tech->id)}}">
                                                <button class="edit-profile-btn"><img src="{{asset('/images/edit-icon.svg')}}" alt="">Edit</button>
                                            </a>
                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        <!-- end create tech -->
    </div>
    <!-- end New Message -->
@endsection