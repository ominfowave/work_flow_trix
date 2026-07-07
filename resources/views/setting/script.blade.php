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
            }
        });
    
        $(document).on("click", ".jsGenClientLink", function(){
            $(".jsClientRegesContent").addClass("show").css("height","253px");
            
            if($(this).attr("data-isgen") == '0'){
                generateLink("clients");
            }
        });

        function copied(text) {
            navigator.clipboard.writeText(text);
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