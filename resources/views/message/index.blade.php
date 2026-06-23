@extends('layouts.main')
@section('title', 'Messages')

@section('style')
  <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.emojipicker.tw.css">

@endsection
@section("content")
    <!-- chatbox -->
    
    <div class="main-chat-details">
        <div class="chat-details">
            <div class="chart-search-box">
                <input type="text" class="jsUserSearch" placeholder="Search.....">
                <img class="chatsearchicon" src="{{asset('/images/search-icon.svg')}}" alt="">
            </div>
            <div class="chat-users-details">

                @if (count($userList))
                    @foreach ($userList as $user_list)
                        <div class="chat-user-details jsUserDetails" data-userid="{{$user_list->id}}" id="user_click">
                            <div class="chat-user">
                                <img src="{{asset('/images/dp-img.png')}}" alt="">
                                
                                @if (!empty($user_list->read_count))
                                    <div class="chat-notification">{{$user_list->read_count}}</div>
                                @endif
                            </div>
                            <div class="chat-and-duration">
                                <div class="chatuser-name-details">
                                    <h3 class="jsRecName">{{$user_list->full_name ?? ''}}</h3>
                                    <p>{{$user_list->last_message ?? ''}}</p>
                                </div>
                                @if ($user_list->last_message)
                                    
                                <div class="chatduration">
                                    @php
                                       $getDate = \Carbon\Carbon::parse($user_list->last_message_date);
                                       $diffDate = $getDate->diff(now());
                                        
                                       if($diffDate->days >= 7){
                                           $last_date = $getDate->format('d/m/Y');
                                        }else if($diffDate->days == 0){
                                           $last_date = 'Today';
                                        }else{
                                           $last_date = now()->subDays($diffDate->days)->format('D');
                                        }
                                    @endphp
                                    <p>{{ $last_date ?? ''}}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        
        <div class="message-main">
            <div class="messagedetails-details jsmsgContent" data-receiver_id="">

                <div class="message-user-heading" style="display: none;">
                    <div class="message-user-title">
                        <button type="button" id="backBtnInner"><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                        <h2 class="jsActiveUser" data-receiver_id=""></h2>
                    </div>
                </div>
                
                <div class="message-body">
                    <div class="empty-chat jsEmptyChat">
                        <h2>Welcome to Chat</h2>
                        <p>Select a conversation from the left to start messaging.</p>
                    </div>
                    <div class="message-inner jsMessageInner"></div>
                </div>

                <div class="message-send-file" style="display: none">

                    <div class="chatbox-inputbox">
                        <div class="chatbox-msg">
                            <div class="chatbox-sub">
                                <div class="textareawithsharebtn">
                                   
                                    <textarea class="editor chat-input emojiable-question" id="text-custom-trigger" placeholder="Enter discussion..."></textarea>
                                    <button type="submit" id="sendBtn" class="jssendBtn" onclick="sendMessage()"><img src="{{asset('/images/chat-shar-icon.svg')}}" alt=""></button>
                                    <div class="">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="file-list jsfileList"></div>                                        
                        </div>
                        
                        <div class="toolbar">
                            <label class="attach-btn-msg">
                                <input type="file" class="jsFileInput" style="display: none;" multiple>
                                <img src="{{asset('/images/file-attach-icon.svg')}}" alt="">
                            </label>
                            <button class="smiley-btn" id="create">
                                <img src="{{asset('/images/smiley-icon.svg')}}" alt="">
                            </button>

                        </div>
                        <button class="double-down-btn"><img src="{{asset('/images/double-down-arow.svg')}}" alt=""></button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- end chatbox -->
@endsection
@section('script')
<script src="{{ asset('js/pusher.min.js') }}?v={{ filemtime(public_path('js/pusher.min.js')) }}"></script>
<script type="text/javascript" src="js/jquery.emojipicker.js" defer></script>
<script type="text/javascript" src="js/jquery.emojis.js" defer></script>

<script>
    $(function () {
        Pusher.logToConsole = true;
        var receiver_id = '{{auth()->guard("admin")->id()}}';
        var pusher_app_key = '{{ ENV('PUSHER_APP_KEY') }}';

        const pusher = new Pusher(pusher_app_key, {
            cluster: 'mt1'
        });

        const USER_ID = receiver_id;
        const channel = pusher.subscribe('chat.' + USER_ID);
        
        channel.bind('new-message', function(data) {
            var currentMsgActive = $(document).find(".jsmsgContent").attr("data-receiver_id");
            
            if(data.message.sender_id == currentMsgActive){
                let chatBox = $(document).find('.jsMessageInner');

                var filesHtml = '';

                if (data.message.message_file && data.message.message_file.length > 0) {

                    $.each(data.message.message_file, function(index, file) {

                        var fileName = file.file_name;
                        var extension = fileName.split('.').pop().toLowerCase();
                        var fileUrl = '/chat-files/' + fileName;

                        let extraClass = extension === 'pdf' ? 'imagepopupPdf' : 'jsIsNotPdf';

                        if ($.inArray(extension, ['jpg', 'jpeg', 'png']) !== -1) {

                            if (data.message.message_file.length == 1) {

                                filesHtml += `
                                    <div class="chatinner-images single-image">
                                        <div class="sub-chatiner-img cust-sub-chatiner-img">
                                            <img class="imagepopup"
                                                data-file="${fileName}"
                                                src="${fileUrl}" alt="">

                                            <a href="${fileUrl}" download>
                                                <div class="signle-image-download-arrow">
                                                    <img class="img_down" src="/images/download-icon.svg" alt="">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                `;
                            } else {

                                filesHtml += `
                                    <div class="file-card">
                                        <div class="file-left cust-file-left ${extraClass}">
                                            <img class="imagepopup"
                                                src="${fileUrl}" alt="">

                                            <div class="file-info">
                                                <div class="file-name">
                                                    <div class="file-name cust-file-name">
                                                        ${fileName}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="${fileUrl}" download>
                                            <div class="file-download-arrow">
                                                <img class="img_down" src="/images/download-icon.svg" alt="">
                                            </div>
                                        </a>
                                    </div>
                                `;
                            }

                        } else {

                            let icon = '/images/file-icon.svg';

                            if (extension === 'pdf') {
                                icon = '/images/pdf-file-icon.svg';
                            } else if (extension === 'doc' || extension === 'docx') {
                                icon = '/images/word-file-icon.svg';
                            } else if (extension === 'xls' || extension === 'xlsx') {
                                icon = '/images/excell-file-icon.svg';
                            }

                            filesHtml += `
                                <div class="file-card">
                                    <div class="file-left cust-file-left ${extraClass}"
                                        data-filesrc="${fileUrl}">
                                        <img src="${icon}" alt="">

                                        <div class="file-info">
                                            <div class="file-name">
                                                <div class="file-name cust-file-name">
                                                    ${fileName}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="${fileUrl}" download>
                                        <div class="file-download-arrow">
                                            <img class="img_down" src="/images/download-icon.svg" alt="">
                                        </div>
                                    </a>
                                </div>
                            `;
                        }
                    });
                }

                $('.jsMessageInner').append(`
                    <div class="message-row left">
                        <div class="messanger-name">
                            <img src="/images/dp-img.png" alt="">
                        </div>

                        <div class="message-text ${data.message.message_file?.length == 1 ? 'cust-message-text' : ''}">
                            <p>${data.message.message ?? ''}</p>

                            ${filesHtml ? `<div class="chatinner-files">${filesHtml}</div>` : ''}

                            <span>Just now</span>
                        </div>
                    </div>
                `);

                $('.jsMessageInner').scrollTop($('.jsMessageInner')[0].scrollHeight);
            }
        });

    });

    var selectedFiles = [];

    function sendMessage()
    {
        var message = $('.chat-input').val();
        if(message !== ''){
            // var receiver_id = $(".jsreceiver_id").data('receiver_id');
            var receiver_id = $(document).find(".jsmsgContent").attr("data-receiver_id");
    
    
            var formData = new FormData();
    
            formData.append('receiver_id', receiver_id);
            formData.append('message', message);
    
            let contentCount = selectedFiles.length;
            let filesHtml = '';
    
            selectedFiles.forEach(function(file) {
                if(file){
                    formData.append('files[]', file);
                }
            });
    
            $.ajax({
                url: '/send-message',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response){
                    $(document).find(".jsNoMsg").remove();
                    // $(document).find('.jsUserDetails.active').trigger('click');
                    $(document).find(".jsMessageInner").append(response.html);
    
                    $('.chat-input').val('');
                    $('.jsfileList').html('');
    
                    selectedFiles = [];
    
                    var $messageBody = $(".message-body");
    
                    $messageBody.animate({
                        scrollTop: $messageBody[0].scrollHeight
                    }, 300);
                }   
            });
        }
    }

    $(document).on('click', '.jsShowMore', function () {
        var btn = $(this);
        var offset = btn.attr('data-offset');
        var receiver_id = btn.data('receiver_id');
        
         $.ajax({
            url: '{{route("message.index")}}',
            type: 'GET',
            data: {
                receiver_active_id: receiver_id,
                offset: offset
            },
            success: function(response) {
                if(!response.showMore){
                    btn.closest('.jsshowmoreEle').remove();
                }
                $('.jsMessageInner').prepend(response.html);
                offset = Number(offset) + 10;
                btn.attr('data-offset', offset);
            }
        });
    });

    $(document).ready(function () {
        $(document).find('#create').click(function(e) {
            $(document).find("#text-custom-trigger").emojiPicker('toggle');
        });

        var $users = $(".chat-user-details");
        var $messageMain = $(".message-main");
        var $chatDetails = $(".chat-details");
        var $messageBody = $(".message-body");

        var $backBtn = $("#backBtn");
        var $backBtnInner = $("#backBtnInner");

        var $downBtn = $(".double-down-btn");

        var $chatInput = $("#chatInput");

        function scrollToBottom() {
            if ($messageBody.length) {
                $messageBody.animate({
                    scrollTop: $messageBody[0].scrollHeight
                }, 300);
            }
        }

        function openChat() {
            setTimeout(scrollToBottom, 100);

            if ($(window).width() <= 767) {
                $messageMain.addClass("show-chat");
                $chatDetails.addClass("hide-list");
            }
        }

        function goBack() {
            if ($(window).width() <= 767) {
                $messageMain.removeClass("show-chat");
                $chatDetails.removeClass("hide-list");
            }
        }

        if ($chatInput.length) {

            function autoResize() {
                $chatInput.css("height", "auto");
                $chatInput.css("height", $chatInput[0].scrollHeight + "px");
            }

            $chatInput.on("input", autoResize);

            // Initial resize
            autoResize();
        }

        scrollToBottom();

        if ($messageBody.length && $downBtn.length) {

            // Initial hide
            $downBtn.hide();

            $messageBody.on("scroll", function () {

                var scrollBottom =
                    this.scrollHeight -
                    this.scrollTop -
                    this.clientHeight;

                if (scrollBottom > 100) {
                    $downBtn.show();
                } else {
                    $downBtn.hide();
                }
            });

            $downBtn.on("click", function () {
                scrollToBottom();
            });
        }

        $users.on("click", function () {
            openChat();
        });

        $backBtn.on("click", function () {
            goBack();
        });

        $backBtnInner.on("click", function () {
            goBack();
        });

        $(window).on("resize", function () {
            if ($(window).width() > 767) {
                $messageMain.removeClass("show-chat");
                $chatDetails.removeClass("hide-list");
            }
        });

        $(document).on("click", ".jsUserDetails", function(){
            var currentEle = $(this);
            var receiver_active_id = currentEle.attr("data-userid");

            $(document).find(".jsUserDetails").removeClass("active");
            currentEle.addClass("active");

            var url = '{{route("message.index")}}';
            var receiverName = currentEle.find(".jsRecName").text();
            $(document).find(".jsshowmoreEle").remove();

            $.ajax({
                url: url,
                type: "get",
                data: {receiver_active_id:receiver_active_id},
                success: function(response){
                    $(".jsActiveUser").html(receiverName);
                    $(".message-user-heading, .message-send-file").css("display","block");
                    if(response.html){
                        if(response.showMore){

                            if(!$(document).find(".jsshowmoreEle").length){
                                var showmore = `<div class="text-center jsshowmoreEle">
                                                    <button class="btn btn-primary jsShowMore" data-offset="10" data-receiver_id="${receiver_active_id}">
                                                        Show More
                                                    </button>
                                                </div>`;
                                $(".jsMessageInner").before(showmore);   
                            }
                        }
                                     
                        $(".jsMessageInner").html(response.html);
                    }else{
                        $(".message-body").find(".jsshowmoreEle").remove();
                        $(".jsMessageInner").html('<p class="jsNoMsg" style="text-align:center">No messages found.</p>');
                    }
                    $(".jsEmptyChat").css("display","none");
                    scrollToBottom();

                    $(document).find(".jsmsgContent").attr("data-receiver_id", receiver_active_id);

                     $(document).find('#text-custom-trigger').emojiPicker({
                        button: false
                    });
                }
            });
        });

        function getFileIcon(ext){
            ext = ext.toLowerCase();
            
            if(ext === 'pdf'){        return '<img class="" src="{{asset('/images/pdf-file-icon.svg')}}" alt="">';    }
            if(['doc','docx'].includes(ext)){        return '<img src="{{asset('/images/word-file-icon.svg')}}" alt="">';    }
            if(['xls','xlsx'].includes(ext)){        return '<img src="{{asset('/images/excell-file-icon.svg')}}" alt="">';    }
            // if(['ppt','pptx'].includes(ext)){        return '<i class="fa-regular fa-file-powerpoint file-icon" style="color:#d24726"></i>';    }
            if(['jpg','jpeg','png','gif','webp'].includes(ext)){        return '<img src="{{asset('/images/jpg-file-icon.svg')}}" alt="">';    }
            return '<i class="fa-regular fa-file file-icon" style="color:#666"></i>';
            
        }

        $(document).on('change', '.jsFileInput', function () {
            $.each(this.files, function (index, file) {
                selectedFiles.push(file);

                let ext = file.name.split('.').pop().toLowerCase();

                let card = $(`
                    <div class="file-card" data-index="${selectedFiles.length - 1}">
                        <div class="file-left">
                            ${getFileIcon(ext)}
                            <div class="file-info">
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${(file.size / 1024).toFixed(0)} KB</div>
                            </div>
                        </div>
                        <span class="remove">
                            <img src="{{ asset('/images/close.svg') }}" alt="">
                        </span>
                    </div>
                `);

                $('.jsfileList').append(card);
            });

            $(this).val('');
        });

        $(document).on('click', '.remove', function () {

            let card = $(this).closest('.file-card');
            let index = card.data('index');

            selectedFiles[index] = null;

            card.remove();
        });

        
        $(document).on('click', '.file-card, .message-text', function () {
            $(".jsChatPreview").show();
        });

        
        $(document).on('keyup', '.jsUserSearch', function () {
            var search_input = $(this).val().toLowerCase();
            var ismatchUser = false;    
            $(".jsNoUserFount").remove();

            $(".jsRecName").each(function () {
                var userName = $(this).text().toLowerCase();

                if(userName.includes(search_input)){
                    ismatchUser = true;    

                    $(this).closest('.jsUserDetails').show();
                }else{
                    $(this).closest('.jsUserDetails').hide();
                }
            });
            
            if(!ismatchUser){
                $(".chat-users-details").append(`<div class="chat-user-details jsUserDetails jsNoUserFount" data-userid="2" id="user_click" style="display: flex;">
                                                    <h4>No Users found.</h4>
                                                </div>`);
            }
        });

        $(document).on('click', '.imagepopup, .imagepopupPdf', function () {
            
            var imgSrc = $(this).attr('src');
            var file_name = $(this).attr("data-file");
            var pdfFile = $(this).attr("data-filesrc");
            
            $(document).find('.chatimagepopup img').attr('src', '');
            $(document).find('.chatimagepopup-details iframe').remove();
            $(document).find(".jsChatDownFile").show();

            if(pdfFile){
                $(document).find(".jsChatDownFile").hide();
                $(document).find('.chatimagepopup-details').prepend(`<iframe src="${pdfFile}" width="100%" height="600px"></iframe>`);
            }else{
                $(document).find('.chatimagepopup img').attr('src', imgSrc);
                $(document).find(".jsChatDownFile").attr('href', imgSrc);
            }
            
            $(document).find('.chatimagepopup-main').addClass('active');

            $(document).find(".jsChatFile").text("").text(file_name);
        });

        $(document).on('click', '.closeicon', function(e){
            e.preventDefault();
            e.stopPropagation();
            $('.chatimagepopup-main').removeClass('active');
        });

        $(document).on('click', '.chatimagepopup-details', function (e) {
            if($(e.target).hasClass('chatimagepopup-details')){
                $('.chatimagepopup-main').removeClass('active');
            }
        });

        $(document).on('click', '.jsIsNotPdf', function () {
            var fileUrl = $(this).attr('data-filesrc');

            var link = document.createElement('a');
            link.href = fileUrl;
            link.download = fileUrl.split('/').pop();
            link.click();
        });
    });
</script>
         
 @endsection