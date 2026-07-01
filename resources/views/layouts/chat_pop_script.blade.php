<script>
    function getFileIcon(ext) {
        ext = ext.toLowerCase();

        const icons = {
            pdf: "./images/pdf-file-icon.svg",
            doc: "./images/word-file-icon.svg",
            docx: "./images/word-file-icon.svg",
            xls: "./images/excell-file-icon.svg",
            xlsx: "./images/excell-file-icon.svg",
            jpg: "./images/jpg-file-icon.svg",
            jpeg: "./images/jpg-file-icon.svg",
            png: "./images/jpg-file-icon.svg",
            gif: "./images/jpg-file-icon.svg",
            webp: "./images/jpg-file-icon.svg"
        };

        return icons[ext]
            ? `<img src="${icons[ext]}" alt="">`
            : '<i class="fa-regular fa-file file-icon"></i>';
    }

    var selectedFiles = [];

    $('#fileInput').change(function () {

        $.each(this.files, function (_, file) {

            const ext = file.name.split('.').pop();
                selectedFiles.push(file);

            $('#fileList').append(`
                <div class="file-card" data-index="${selectedFiles.length - 1}">
                    <div class="file-left">
                        ${getFileIcon(ext)}
                        <div class="file-info">
                            <div class="file-name">${file.name}</div>
                            <div class="file-size">${(file.size / 1024).toFixed(0)} KB</div>
                        </div>
                    </div>
                    <span class="remove">
                        <img src="./images/close.svg" alt="">
                    </span>
                </div>
            `);
        });

        $(this).val('');
    });

    $(document).on('click', '.remove', function () {
        $(this).closest('.file-card').remove();
    });


    const $chatDetails = $("#chat-details-pop");
    const $messageMain = $(".message-main-pop");
    const $messageBody = $(".message-body");
    const $downBtn = $(".double-down-btn");

    // Scroll to bottom
    $downBtn.on("click", function () {
        $messageBody.animate({
            scrollTop: $messageBody[0].scrollHeight
        }, 500);
    });

    // Show/Hide down button
    $messageBody.on("scroll", function () {
        const isBottom =
            this.scrollTop + this.clientHeight >= this.scrollHeight - 5;

        if (isBottom) {
            $downBtn.hide();
        } else {
            $downBtn.show();
        }
    });

    // Open chat list
    $(document).find("#chat-btn").on("click", function () {
        
        $.ajax({
            url: '{{route("message.index")}}',
            type: 'get',
            data: {"ispopmsg":true},
            success: function(response){

                $(document).find(".chat-users-details").html(response.html);
                $chatDetails.addClass("show");
            }
        });
    });

    // Close chat list
    $(".message-close-btn").on("click", function () {
        $chatDetails.removeClass("show");
    });


    // Open message
    $(document).ready(function(){
        $(document).on("click", ".chat-user-details-pop", function () {
            
            $chatDetails.removeClass("show");
            $messageMain.addClass("show");
        });

        var $messageBody = $(".message-body");


        function scrollToBottom() {
            if ($messageBody.length) {
                $messageBody.animate({
                    scrollTop: $messageBody[0].scrollHeight
                }, 300);
            }
        }
        
        $(document).on('click', '.jsPopSendMsg', function () {
            var message = $('.custeditor').val();
            if(message !== '' || selectedFiles.length > 0){
                // var receiver_id = $(".jsreceiver_id").data('receiver_id');
                var receiver_id = $(document).find(".jsmsgContent").attr("data-receiver_id");
        
                var formData = new FormData();
                var is_pop_user = true;
        
                formData.append('receiver_id', receiver_id);
                formData.append('message', message);
                formData.append('is_pop_user', is_pop_user);

                
        
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
                        $(document).find(".message-inner").append(response.html);
        
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
            $('.custeditor').val('').css('max-height', '80px');
            $(".custfile-list-pop").html("");
        });

        $(document).on('click', '.jsShowMore', function () {
            var btn = $(this);
            var offset = btn.attr('data-offset');
            var receiver_id = btn.data('receiver_id');
            var is_pop_user = true;
            
            $.ajax({
                url: '{{route("message.index")}}',
                type: 'GET',
                data: {
                    receiver_active_id: receiver_id,
                    offset: offset,
                    is_pop_user:is_pop_user
                },
                success: function(response) {
                    if(!response.showMore){
                        btn.closest('.jsshowmoreEle').remove();
                    }
                    $('.message-inner').prepend(response.html);
                    offset = Number(offset) + 10;
                    btn.attr('data-offset', offset);
                }
            });
        });

        $(document).on("click", ".jsUserDetailsPop", function(){
            $(".jsShowMore").remove();
            
            var currentEle = $(this);
            var receiver_active_id = currentEle.attr("data-userid");

            $(document).find(".jsUserDetailsPop").removeClass("active");
            currentEle.addClass("active");

            var url = '{{route("message.index")}}';
            var receiverName = currentEle.find(".jspopUsername").text();
            var user_role = currentEle.find(".jspopUsername").attr("data-userrole");
            // $(document).find(".jsshowmoreEle").remove();
            $(".jsuserpopName").html(receiverName);
            $(".jsuserpopRole").html(user_role);

            $.ajax({
                url: url,
                type: "get",
                data: {receiver_active_id:receiver_active_id,"is_pop_user": true},
                success: function(response){
                    
                    $(".message-user-heading-pop, .message-send-file-pop").css("display","block");
                    if(response.html){
                        if(response.showMore){

                            if(!$(document).find(".jsshowmoreEle").length){
                                var showmore = `<div class="text-center jsshowmoreEle">
                                                    <button class="btn btn-primary jsShowMore" data-offset="10" data-receiver_id="${receiver_active_id}">
                                                        Show More
                                                    </button>
                                                </div>`;
                                $(".message-inner").before(showmore);   
                            }
                        }
                                     
                        $(".message-inner").html(response.html);
                    }else{
                        $(".message-body").find(".jsshowmoreEle").remove();
                        $(".message-inner").html('<p class="jsNoMsg" style="text-align:center">No messages found.</p>');
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
    });

    // Back to chat list
    $(".close-chat").on("click", function () {
        $messageMain.removeClass("show");
        $chatDetails.addClass("show");
    });
</script>