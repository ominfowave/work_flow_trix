<script>
     // logout
    $(document).on("click", ".jsLogout", function() {
        var token = "{{ csrf_token() }}";
        var route = $(this).attr("data-href");

        $.ajax({
            url: route,
            type: "POST",
            data: {_token: token},
            success: function(response) {
                window.location = "{{ route('admin_login') }}";
            }
        });
    });

    var selectedData = {};

    $(document).on("change", ".jsStatus", function () {

        var currentElement = $(this);
        var id = currentElement.data("id");
        var route = currentElement.data("href");
        var title = currentElement.data("title");
        var isform = currentElement.attr("data-isform");

        var oldValue = currentElement.data("old-value") || "";
        var status;

        if (currentElement.is("select")) {
            status = currentElement.val();
        } else {
            status = currentElement.prop("checked")
                ? "active"
                : "inactive";
        }

        selectedData = {
            id: id,
            route: route,
            status: status,
            element: currentElement,
            oldValue: oldValue
        };

        $(".jsStatusPopMsg").text(
            "Are you sure you want to change the status of this " +
            title +
            "?"
        );

        if(!isform){
            $(".admintogglepopup-main").show();
        }
    });

    $(document).ready(function () {
        $(".jsStatus").each(function () {
            $(this).data("old-value", $(this).val());
        });
    });

    $(document).on("click", ".jsYesBtn", function () {

        $.ajax({
            url: selectedData.route,
            type: "POST",
            data: {
                id: selectedData.id,
                status: selectedData.status,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {

                $(".admintogglepopup-main").hide();

                if (response.success) {

                    if (selectedData.element.is("select")) {
                        selectedData.element.data(
                            "old-value",
                            selectedData.status
                        );
                    }

                    // console.log("Status updated");
                }
            }
        });
    });

    $(document).on("click", ".jsNoBtn", function () {

        if (selectedData.element.is("select")) {
            selectedData.element.val(selectedData.oldValue);
        } else {
            selectedData.element.prop(
                "checked",
                selectedData.status !== "active"
            );
        }

        $(".admintogglepopup-main").hide();
    });
    
    $(document).on("click", ".jspopClose", function () {
        selectedData.element.prop(
            "checked",
            selectedData.status !== "active"
        );
        
        $(".admintogglepopup-main").hide();
    });

    // delete record
    var deleteData = {};

    // Open popup
    $(document).on("click", ".jsDelete", function () {

        var element = $(this);

        deleteData = {
            element: element,
            route: element.data("href"),
            id: element.data("id")
        };

        $(".jsDeletePopupMsg").text(
            "Are you sure you want to delete this " +
            element.data("title") +
            "?"
        );

        $(".jsDeletePopup").show();
    });


    // Yes button
    $(document).on("click", ".jsYesBtnDlt", function () {
    $(document).find(".custom-alert").remove();

        if (!deleteData.route) {
            return;
        }

        $.ajax({
            url: deleteData.route,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}",
                id: deleteData.id
            },
            success: function (response) {

                $(".jsDeletePopup").hide();

                if (response.success) {
                    deleteData.element
                        .closest(".projectsdetails, .project-assigned-main, .timeline-card")
                        .remove();
                        $(".vertical-dotts-" + deleteData.id).remove();

                        var html = `<div class="custom-alert success-alert" style="margin-top: 55px;">
                                        <span>${response.success}</span>
                                    </div>`;
                        $(document).find(".projectsmain").prepend(html);            

                }else if(response.error){
                     var html = `<div class="custom-alert" style="margin-top: 55px;">
                                        <span>${response.error}</span>
                                    </div>`;
                        $(document).find(".projectsmain").prepend(html);   
                }

                deleteData = {};

                setTimeout(() => {
                    $(document).find(".custom-alert").remove();
                }, 3000);
            }
        });
    });

    // No button
    $(document).on("click", ".jsNoBtnDlt, .jspopCloseDlt", function () {
        deleteData = {};
        $(".jsDeletePopup").hide();
    });

    var unapproved_project_count = '{{$unapproved_project_count ?? 0}}';
    var unapproved_client_count = '{{$unapproved_client_count ?? 0}}';

    $(document).on("click", ".jstab", function () {
        var currentEle = $(this);
        var tabClass = currentEle.attr('data-tab');

        $(".jstab, .tabs-details").removeClass('active');
        
        currentEle.addClass('active');
        $("."+tabClass + '_content').addClass('active');

        
        if(tabClass == 'unapproved_project' && Number(unapproved_project_count) !== Number(0)){
            dashboardRead(tabClass);
        }

         if(tabClass == 'unapproved_client' && Number(unapproved_client_count) !== Number(0)){
            dashboardRead(tabClass);
        }

        $('.jsSearch').trigger('keyup');
    });

    var is_admin_dashboard = '{{$is_admin_dashboard ?? false}}';
    var is_latest_pro = '{{$is_latest_pro ?? false}}';

    var latest_project_count = '{{$latest_project_count ?? 0}}';

    
    if(is_admin_dashboard && is_latest_pro && Number(latest_project_count) > Number(0)){
        var tab_type_daynamic = 'latest_project';
        
        dashboardRead(tab_type_daynamic);
    }

    function dashboardRead(tab_type_daynamic){
        $.ajax({
            url: '{{route("dashboardRead")}}',
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                tab_type: tab_type_daynamic
            },
            success: function (response) {
                if (response.success) {
                    $("." + response.success + " span").remove();
                }
            }
        });
    }

    
    $(document).on("click", ".jsProReqAccept", function () {
        var element = $(this);
        var project_id = element.attr("data-projectid");
        console.log(project_id);
        
        $.ajax({
            url: '{{route("acceptProReq")}}',
            type: 'POST',
            data: {_token: '{{csrf_token()}}',project_id:project_id},
            success: function(response){
                var html = `<div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>${response.success}</span>
                        </div>`;
                $(document).find(".newmessage-details").prepend(html);   

                element.closest(".projectacceptreject").find(".accept-reject-btn").hide();
                setTimeout(() => {
                    $(document).find(".custom-alert").remove();
                }, 3000);
            }
        });
    });

    $(document).on("click", ".jsClientReqAccept", function () {
        var element = $(this);
        var project_id = element.attr("data-projectid");
        
        $.ajax({
            url: '{{route("acceptClientReq")}}',
            type: 'POST',
            data: {_token: '{{csrf_token()}}',project_id:project_id},
            success: function(response){
                var html = `<div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>${response.success}</span>
                        </div>`;
                $(document).find(".newmessage-details").prepend(html);   

                element.closest(".unapproving-client-desc").find(".accept-reject-btn").hide();
                setTimeout(() => {
                    $(document).find(".custom-alert").remove();
                }, 3000);
            }
        });
    });

    $(document).on("click", ".jsProReqReject", function () {
        var rejectElement = $(this).closest(".projectacceptreject").find(".reject-reason-details");
        var rejectBtnEle = $(this).closest(".projectacceptreject").find(".reject-down-arrow-btn");

        if(rejectElement.hasClass('show')){
            rejectElement.removeClass('show');
            rejectBtnEle.removeClass('active');
        }else{
            rejectElement.addClass('show');
            rejectBtnEle.addClass('active');
        }
    });

    $(document).on("click", ".jsClientReqReject", function () {
        var rejectElement = $(this).closest(".project-desc").find(".unapprove-reject-reason-details");
        var rejectBtnEle = $(this).closest(".project-desc").find(".reject-down-arrow-btn");

        if(rejectElement.hasClass('show')){
            rejectElement.removeClass('show');
            rejectBtnEle.removeClass('active');
        }else{
            rejectElement.addClass('show');
            rejectBtnEle.addClass('active');
        }
    });

    $(document).on("click", ".jsReajectBtn", function () {
        var element = $(this);
        var project_id = element.closest(".reject-reason-details").find(".jsproIdReReason").val();
        var reason = element.closest(".reject-reason-details").find(".jsRejectRea").val();

        if(reason !== '' && project_id){
            $.ajax({
               url: '{{route("rejectReasonPro")}}',
               type: 'POST',
               data: {_token: '{{csrf_token()}}',project_id:project_id, reason: reason},
               success: function(response){
                   var html = `<div class="custom-alert success-alert" style="margin-top: 55px;">
                               <span>${response.success}</span>
                           </div>`;
                   $(document).find(".newmessage-details").prepend(html);   
   
                   element.closest(".projectacceptreject").find(".accept-reject-btn").hide();
                   element.closest(".projectacceptreject").find(".reject-reason-details").hide();
                   setTimeout(() => {
                       $(document).find(".custom-alert").remove();
                   }, 3000);
               }
           });
        }
    });

    
    $(document).on("click", ".jsClientRejectBtn", function () {
        var element = $(this);
        var project_id = element.closest(".unapprove-reject-reason-details").find(".jsclientIdReject").val();
        var reason = element.closest(".unapprove-reject-reason-details").find(".jsClientRejectInput").val();

        if(reason !== '' && project_id){
            $.ajax({
               url: '{{route("rejectReasonClient")}}',
               type: 'POST',
               data: {_token: '{{csrf_token()}}',project_id:project_id, reason: reason},
               success: function(response){
                   var html = `<div class="custom-alert success-alert" style="margin-top: 55px;">
                               <span>${response.success}</span>
                           </div>`;
                   $(document).find(".newmessage-details").prepend(html);   
   
                   element.closest(".project-desc").find(".accept-reject-btn").hide();
                   element.closest(".project-desc").find(".unapprove-reject-reason-details").hide();
                   setTimeout(() => {
                       $(document).find(".custom-alert").remove();
                   }, 3000);
               }
           });
        }
    });

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

    $('#fileInput').change(function () {

        $.each(this.files, function (_, file) {

            const ext = file.name.split('.').pop();

            $('#fileList').append(`
                <div class="file-card">
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

    });

    $(document).on('click', '.remove', function () {
        $(this).closest('.file-card').remove();
    });

    $('#sendBtn').click(function () {

        const message = $.trim($('#editor').val());

        if (!message) return;

        alert("Message Sent: " + message);

        $('#editor').val('').css('height', '80px');
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
    });

    // Back to chat list
    $(".close-chat").on("click", function () {
        $messageMain.removeClass("show");
        $chatDetails.addClass("show");
    });

</script>