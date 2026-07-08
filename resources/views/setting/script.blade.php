<script>
    $(document).ready(function(){
        function generateLink(moduletype){
            $.ajax({
                url: "{{route('generateLink')}}",
                type: "POST",
                data: {"_token":"{{csrf_token()}}", "moduletype":moduletype},
                success: function(response){
                   
                    if(response.link){
                        $("."+moduletype).text(response.link);
                        $("."+moduletype+"_date").text("Last generated : "+response.last_generate_date);
                    }
                }
            })
        }
    
        $(document).on("click", ".jsUserRegisLink", function(){
            $(".jsUserRegisCon").addClass("show").css("height","253px");
            // console.log($(this).attr("data-isgen") == '0');
            
            if($(this).attr("data-isgen") == '0'){
                console.log("is_user");
                
                generateLink("users");
                $(this).attr("data-isgen", "1");
            }
        });
    
        $(document).on("click", ".jsGenClientLink", function(){
            $(".jsClientRegesContent").addClass("show").css("height","253px");
            
            if($(this).attr("data-isgen") == '0'){
                generateLink("clients");
                $(this).attr("data-isgen", "1");
            }
        });

        function copied(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text)
                    .done(function () {
                        console.log("Copied");
                    })
                    .fail(function (err) {
                        console.log("Copy failed:", err);
                    });
            } else {
                var $temp = $("<textarea>");
                $("body").append($temp);

                $temp.val(text).select();
                document.execCommand("copy");

                $temp.remove();
            }
        }
        
        $(document).on("click", ".jsUserCopy", function(){
            var url = $(this).closest(".registration-url-box").find(".jsurl").text();

            $(this).append('<img class="jsCopyUrl" src="{{asset("/images/true-icon.svg")}}" alt="">');

            copied(url);
             setTimeout(() => {
                $(".jsCopyUrl").remove();
            }, 3000);
        });

        $(document).on("click", ".jsClientCopy", function(){
            var url = $(this).closest(".registration-url-box").find(".jsurl").text();

            $(this).append('<img class="jsCopyUrl" src="{{asset("/images/true-icon.svg")}}" alt="">');

            copied(url);
            setTimeout(() => {
                $(".jsCopyUrl").remove();
            }, 3000);
        });

    })
</script>