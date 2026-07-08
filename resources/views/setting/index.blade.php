@extends('layouts.main')
@section('title', 'Setting')

@section("content")


<div id="new_message" class="newmessage-details">
    <div class="productlist">
        <h2>Settings</h2>
    </div>

    <div class="-projectsmain">
        <div class="addmin-settings-main">   
            <div class="addmin-settings-user">
                <div class="user-registration-details">
                        <img src="{{asset('/images/user-reg-img.png')}}" alt="">
                    <div class="addmin-settings-user-txt">
                        <h3>Generate User Registration Link</h3>
                        <p>Create a secure registration link and share it with new users</p>
                    </div>
                </div>
                 @php
                    $userLink = "";
                    $isUserGen = 0;
                    $last_gen = "";
                    if(count($link)){
                        foreach ($link as $linkData) {
                            if($linkData->link_type == 'users'){
                                $userLink = route('register.users', $linkData->link);
                                // dd($linkData->created_at);
                                if($linkData->created_at->isToday()){
                                    $isUserGen = 1;
                                    $last_gen = $linkData->created_at->format("M d, Y H:i A");
                                }
                            }
                        }
                    }
                @endphp
                <button class="link-registration-btn jsUserRegisLink" data-isgen="{{$isUserGen}}" id="generate-usr-link"><img src="{{asset('/images/link-icon.svg')}}" alt="">Generate Registration Link</button>
            </div>

            <div class="registration-link-details jsUserRegisCon">
                <h3>Registration Link</h3>
                
                <div class="registration-url-box">
                    <div class="url-content">
                        <span class="web-icon"><img src="{{asset('/images/web-icon.svg')}}" alt=""></span>
                       
                        <span class="users jsurl">{{ $userLink }}</span>
                    </div>

                    <button class="copy-url-btn jsUserCopy"><img src="{{asset('/images/copy-icon.svg')}}" alt=""> Copy</button>
                </div>

                <div class="link-generate-duration">
                    <div class="link-generate">
                        <img src="{{asset('/images/true-icon.svg')}}" alt="">
                        <p>Link generated successfully!</p>
                    </div>
                    <div class="link-generate time-generate">
                        <img src="{{asset('/images/last-generate-clock-icon.svg')}}" alt="">
                        <p class="users_date">Last generated : {{$last_gen}}</p>
                    </div>
                </div>


                <div class="link-generate-securely">
                    <img src="{{asset('/images/securely-icon.svg')}}" alt="">
                    <p>This link allows new user to create an account Share it securely. </p>
                </div>

            </div>
        </div>                            


        <div class="addmin-settings-main">   
            <div class="addmin-settings-user">
                <div class="user-registration-details">
                        <img src="{{asset('/images/user-reg-img.png')}}" alt="">
                    <div class="addmin-settings-user-txt">
                        <h3>Generate Client Registration Link</h3>
                        <p>Create a secure registration link and share it with new clients</p>
                    </div>
                </div>
                @php
                    $clientLink = "";
                    $isClientGen = 0;
                    if(count($link)){
                        foreach ($link as $linkData) {
                            if($linkData->link_type == 'clients'){
                                $clientLink = route('register.clients', $linkData->link);

                                if($linkData->created_at->isToday()){
                                    $isClientGen = 1;
                                }
                            }
                        }
                    }
                @endphp
                <button class="link-registration-btn jsGenClientLink" data-isgen="{{$isClientGen}}" id="generate-client-link"><img src="{{asset('/images/link-icon.svg')}}" alt="">Generate Registration Link</button>
            </div>

             <div class="registration-link-details jsClientRegesContent">
                <h3>Registration Link</h3>
                
                <div class="registration-url-box">
                    <div class="url-content">
                        <span class="web-icon"><img src="{{asset('/images/web-icon.svg')}}" alt=""></span>
                        <span class="clients jsurl">{{ $clientLink }}</span>
                    </div>

                    <button class="copy-url-btn jsClientCopy"><img src="{{asset('/images/copy-icon.svg')}}" alt=""> Copy</button>
                </div>

                <div class="link-generate-duration">
                    <div class="link-generate">
                        <img src="{{asset('/images/true-icon.svg')}}" alt="">
                        <p>Link generated successfully!</p>
                    </div>
                    <div class="link-generate time-generate">
                        <img src="{{asset('/images/last-generate-clock-icon.svg')}}" alt="">
                        <p class="clients_date">Last generated : June 25, 2026 11:30 AM</p>
                    </div>
                </div>


                <div class="link-generate-securely">
                    <img src="{{asset('/images/securely-icon.svg')}}" alt="">
                    <p>This link allows new user to create an account Share it securely. </p>
                </div>

            </div>
        </div>                            
    </div>
</div>
<script src="{{asset('./js/jquery.min.js')}}"></script>    

@include('setting.script')
@endsection
