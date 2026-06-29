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

    <div class="comment-chat">
        <button type="button" class="comment-btn" id="chat-btn"><img src="{{asset('/images/comment-icon.svg')}}" alt=""></button>
    </div>

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
                <div class="chat-user-details-pop" id="user_click">
                    <div class="chat-user">
                        <img src="{{asset('/images/dp-img.png')}}" alt="">
                    </div>
                    <div class="chat-and-duration">
                        <div class="chatuser-name-details">
                            <h3>Jeff Marcos</h3>
                            <p>Please sent me details</p>
                        </div>
                        <div class="chatduration">
                            <p>5h</p>
                        </div>
                    </div>
                </div>

                <div class="chat-user-details-pop active">
                    <div class="chat-user">
                        <img src="{{asset('/images/dp-img.png')}}" alt="">
                    </div>
                    <div class="chat-and-duration">
                        <div class="chatuser-name-details">
                            <h3>Charile kyle</h3>
                            <p>Please sent me details</p>
                        </div>
                        <div class="chatduration">
                            <p>2h</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="message-main-pop">
        <div class="messagedetails-details-pop">
            <div class="message-user-heading-pop">
                <div class="message-user-title-pop">
                    <div class="chat-user-details-pop" id="user_click">
                        <div class="chat-user">
                            <img src="{{asset('/images/dp-img.png')}}" alt="">
                        </div>
                        <div class="chat-and-duration">
                            <div class="chatuser-name-details">
                                <h3>Jeff Marcos</h3>
                                <p>Please sent me details</p>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="close-chat 11"><img src="{{asset('/images/close.svg')}}" alt=""></button>
                    
                </div>
            </div>
            
            <div class="message-body">
                <div class="message-inner">
                    <div class="message-row right">
                        <div class="message-text">
                            <p>Hi, How are you ?</p>
                           
                        </div>
                        
                    </div>

                    <div class="chat-date">
                        <span>15 june</span>
                    </div>

                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Hi, How are you ?</p>
                           
                        </div>
                    </div>

                    

                    <div class="message-row right">
                        <div class="message-text">
                            <p>Hi, How are you ?</p>
                           
                        </div>
                        
                    </div>
                    
                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Hi, How are you ?</p>
                           
                        </div>
                    </div>
                    
                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>


                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>
                    <div class="chat-date">
                        <span>15 june</span>
                    </div>
                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>

                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>
                    
                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>


                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>

                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>
                    
                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>

                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>
                    
                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>

                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem</p>
                            <div class="chatinner-files">
                                <div class="file-card">
                                    <div class="file-left cust-file-left">
                                        <img src="{{asset('/images/word-file-icon.svg')}}" alt="">
                                        <div class="file-info">
                                            <div class="file-name cust-file-name">
                                                file-sample_100kB.doc
                                            </div>
                                            <div class="file-size">
                                                98 KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="file-card">
                                    <div class="file-left cust-file-left">
                                        <img src="{{asset('/images/word-file-icon.svg')}}" alt="">
                                        <div class="file-info">
                                            <div class="file-name cust-file-name">
                                                file-sample_100kB.doc
                                            </div>
                                            <div class="file-size">
                                                98 KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="file-card">
                                    <div class="file-left cust-file-left">
                                        <img src="{{asset('/images/word-file-icon.svg')}}" alt="">
                                        <div class="file-info">
                                            <div class="file-name cust-file-name">
                                                file-sample_100kB.doc
                                            </div>
                                            <div class="file-size">
                                                98 KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="file-card">
                                    <div class="file-left cust-file-left">
                                        <img src="{{asset('/images/word-file-icon.svg')}}" alt="">
                                        <div class="file-info">
                                            <div class="file-name cust-file-name">
                                                file-sample_100kB.doc
                                            </div>
                                            <div class="file-size">
                                                98 KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>

                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>
                    
                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                        
                    </div>

                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>
                    
                    <div class="message-row right">
                        <div class="message-text cust-message-text">
                            <p>Hello </p>
                            <div class="chatinner-images">
                                <div class="sub-chatiner-img">
                                    <img src="{{asset('/images/dummy.png')}}" alt="">
                                    <div class="image-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="sub-chatiner-img">
                                    <img src="{{asset('/images/dummy2.png')}}" alt="">
                                    <div class="image-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="sub-chatiner-img">
                                    <img src="{{asset('/images/dummy3.jpg')}}" alt="">
                                    <div class="image-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>

                                <div class="sub-chatiner-img">
                                    <img src="{{asset('/images/dummy4.jpg')}}" alt="">
                                    <div class="image-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>
                            </div>
                           
                        </div>
                        
                    </div>

                    <div class="message-row left">
                        
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           
                        </div>
                    </div>

                    <div class="message-row right">
                        <div class="message-text cust-message-text">
                            <p>Hello </p>
                            <div class="chatinner-images single-image">
                                <div class="sub-chatiner-img cust-sub-chatiner-img">
                                    <img class="imagepopup" src="{{asset('/images/dummy.png')}}" alt="">
                                    <div class="signle-image-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="message-row left">
                        <div class="message-text">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        </div>
                    </div>


                    <div class="message-row right">
                        <div class="message-text">
                            <p>Lorem</p>
                            <div class="chatinner-files">
                                <div class="file-card pdf-file" data-pdf="./images/dummy-pdf.pdf">
                                    <div class="file-left cust-file-left">
                                        <img src="{{asset('/images/pdf-file-icon.svg')}}" alt="">
                                        <div class="file-info">
                                            <div class="file-name cust-file-name">
                                                dummy-pdf.pdf
                                            </div>
                                            <div class="file-size">
                                                98 KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-download-arrow"><img src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="message-send-file-pop">
                <div class="chatbox-inputbox-pop cust-chatbox-inputbox-pop">
                    <div class="chatbox-pop custchatbox-pop">
                        <div class="chatbox-sub-pop">
                            <div class="textareawithsharebtn-pop custtextareawithsharebtn-pop">
                                <textarea class="editor custeditor" id="editor" placeholder="Enter Message"></textarea>
                                <button type="submit" id="sendBtn" class="send-btn msg-send-btn"><img src="{{asset('/images/chat-shar-icon.svg')}}" alt=""></button>
                                <div class="">
                                </div>
                            </div>
                            
                        </div>
                        <div class="file-list-pop custfile-list-pop" id="fileList"></div>                                        
                    </div>
                    <div class="toolbar custtoolbar">
                        <label class="attach-btn custattach-btn">
                            <input type="file" id="fileInput" style="display: none;" multiple>
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
                <img src="{{asset('/images/info-icon.svg')}}')}}" alt="">
                <p class="jsStatusPopMsg"></p>
                <div class="admintogglepopup-btn">
                    <button type="submit" class="yes-btn jsYesBtn">Yes</button>
                    <button type="submit" class="no-btn jsNoBtn">No</button>
                </div>
                <button type="button" class="popup-close-icon jspopClose"><img src="{{asset('/images/close.svg')}}')}}" alt=""></button>
            </div>
        </div>
    </div>

    <div class="admintogglepopup-main-dlt jsDeletePopup">
        <div class="admintogglepopup-details">
            <div class="admintogglepopup-sub">
                <img src="{{asset('/images/info-icon.svg')}}')}}" alt="">
                <p class="jsDeletePopupMsg"></p>
                <div class="admintogglepopup-btn">
                    <button type="submit" class="yes-btn jsYesBtnDlt">Yes</button>
                    <button type="submit" class="no-btn jsNoBtnDlt">No</button>
                </div>
                <button type="button" class="popup-close-icon jspopCloseDlt"><img src="{{asset('/images/close.svg')}}')}}" alt=""></button>
            </div>
        </div>
    </div>

    <div class="chatimagepopup-main">
        <div class="chatimagepopup-details">
            <div class="chatimagepopup">
                <img src="')}}" alt="">
            </div>
            <div class="chatimagepopup-img-name">
                <h5 class="jsChatFile"></h5>
                {{-- <p>Ramshi.kanotara <span>Share in Ramshi.kanotara</span></p> --}}
            </div>
            <div class="chatimagepopup-download-closed">
                <a class="jsChatDownFile" href="" download><img src="{{asset('/images/download-white-icon.svg')}}')}}" alt=""></a>
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
</body>
</html>