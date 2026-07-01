<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="icon" type="image/png" href="{{asset('/images/new_logo.png')}}">
    <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.g.css">
     @yield("style")

    <title>@yield('title', 'Dashboard')</title>
</head>
<body>
    
    <!-- header -->
     @include('layouts.header')
    <!-- end header -->

    <section class="user-details-section">
        <div class="main_container">
            <div class="user-details-main">
                 @include('layouts.sidebar')
                <div id="right_sidebar_details" class="user-right">
                 @yield("content")
                </div>
            </div>
        </div>
    </section>

    @if(request()->path() !== 'message')
        <div class="comment-chat">
            <button type="button" class="comment-btn" id="chat-btn"><img src="{{asset('/images/comment-icon.svg')}}" alt=""></button>
        </div>
    @endif

     <div id="chat-details-pop" class="main-chat-details-pop">
        <div class="chat-details-pop">
            <div class="chat-with-closeicon">
                <h5>Message</h5>
                <button class="message-close-btn"><img src="{{asset('/images/close.svg')}}" alt=""></button>
            </div>
            <div class="chart-search-box">
                <input type="text" placeholder="Search.....">
                <img class="chatsearchicon" src="{{asset('/images/search-icon.svg')}}" alt="">
            </div>

            <div class="chat-users-details">
                
            </div>
        </div>
    </div>

    <div class="message-main-pop">
        <div class="messagedetails-details-pop jsmsgContent" data-receiver_id="">
            <div class="message-user-heading-pop">
                <div class="message-user-title-pop">
                    <div class="chat-user-details-pop" id="user_click">
                        <div class="chat-user">
                            <img src="{{asset('/images/dp-img.png')}}" alt="">
                        </div>
                        <div class="chat-and-duration">
                            <div class="chatuser-name-details">
                                <h3 class="jsuserpopName"></h3>
                                <p class="jsuserpopRole"></p>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close-chat 11"><img src="{{asset('/images/close.svg')}}" alt=""></button>
                    
                </div>
            </div>
            
            <div class="message-body">
                <div class="message-inner">
                  
                </div>
            </div>

            <div class="message-send-file-pop">
                <div class="chatbox-inputbox-pop cust-chatbox-inputbox-pop">
                    <div class="chatbox-pop custchatbox-pop">
                        <div class="chatbox-sub-pop">
                            <div class="textareawithsharebtn-pop custtextareawithsharebtn-pop">
                                <textarea class="editor custeditor" id="editor" placeholder="Enter Message"></textarea>
                                <button type="submit" id="sendBtn" class="send-btn msg-send-btn jsPopSendMsg"><img src="{{asset('/images/chat-shar-icon.svg')}}" alt=""></button>
                                <div class="">
                                </div>
                            </div>
                            
                        </div>
                        <div class="file-list-pop custfile-list-pop" id="fileList"></div>                                        
                    </div>
                    <div class="toolbar custtoolbar">
                        <label class="attach-btn custattach-btn">
                            <input type="file" id="fileInput" class="jsFileInput" style="display: none;" multiple>
                            <img src="{{asset('/images/file-attach-icon.svg')}}" alt="">
                        </label>
                        <button class="smiley-btn"><img src="{{asset('/images/smiley-icon.svg')}}" alt=""></button>
                    </div>
                    <button class="double-down-btn"><img src="{{asset('/images/double-down-arow.svg')}}" alt=""></button>
                </div>
            </div>

        </div>
    </div>

    <div class="admintogglepopup-main">
        <div class="admintogglepopup-details">
            <div class="admintogglepopup-sub">
                <img src="{{asset('/images/info-icon.svg')}}" alt="">
                <p class="jsStatusPopMsg"></p>
                <div class="admintogglepopup-btn">
                    <button type="submit" class="yes-btn jsYesBtn">Yes</button>
                    <button type="submit" class="no-btn jsNoBtn">No</button>
                </div>
                <button type="button" class="popup-close-icon jspopClose"><img src="{{asset('/images/close.svg')}}" alt=""></button>
            </div>
        </div>
    </div>

    <div class="admintogglepopup-main-dlt jsDeletePopup">
        <div class="admintogglepopup-details">
            <div class="admintogglepopup-sub">
                <img src="{{asset('/images/info-icon.svg')}}" alt="">
                <p class="jsDeletePopupMsg"></p>
                <div class="admintogglepopup-btn">
                    <button type="submit" class="yes-btn jsYesBtnDlt">Yes</button>
                    <button type="submit" class="no-btn jsNoBtnDlt">No</button>
                </div>
                <button type="button" class="popup-close-icon jspopCloseDlt"><img src="{{asset('/images/close.svg')}}" alt=""></button>
            </div>
        </div>
    </div>

    <div class="chatimagepopup-main">
        <div class="chatimagepopup-details">
            <div class="chatimagepopup">
                <img src="" alt="">
            </div>
            <div class="chatimagepopup-img-name">
                <h5 class="jsChatFile"></h5>
                {{-- <p>Ramshi.kanotara <span>Share in Ramshi.kanotara</span></p> --}}
            </div>
            <div class="chatimagepopup-download-closed">
                <a class="jsChatDownFile" href="" download><img src="{{asset('/images/download-white-icon.svg')}}" alt=""></a>
                <a href="#" class="closeicon"><img src="{{asset('/images/close-white-icon.svg')}}"  alt=""></a>
            </div>
        </div>
    </div>

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/cust.js')}}"></script>   
<script src="{{asset('js/pusher.min.js')}}"></script>
<script type="text/javascript" src="js/jquery.emojipicker.js"></script>
<script type="text/javascript" src="js/jquery.emojis.js"></script>

     @yield("script")

@include('layouts.script') 

@if(request()->path() !== 'message')
    @include('layouts.chat_pop_script') 
@endif

</body>
</html>