<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
     @yield("style")

    <title>User Deshboard</title>
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
     @yield("script")

@include('layouts.script') 
</body>
</html>