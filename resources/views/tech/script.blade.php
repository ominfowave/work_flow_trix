<script>
    $(".techForm").validate({
        rules: {
            tech_name: {
                required: true,
                minlength: 3
            },
            tech_icon: {
                accept: "image/jpeg,image/png,image/jpg"
            }
        },

        messages: {
            name: {
                required: "Name is required",
                minlength: "Minimum 3 characters required"
            },
            tech_icon: {
                accept: "Only JPG, JPEG and PNG files allowed"
            }
        },

        submitHandler: function(form) {
            // alert("Form submitted successfully");
            form.submit();
        }
    });

    $(document).on("click", ".jsSubmit", function(){
         var fileInput = $(".tech_icon")[0];
        $(".tech_icon_error").remove();
        $(".tech_icon_edit").remove();

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            var fileType = file.type;
            
            if (fileType !== "image/jpeg" &&  fileType !== "image/png" && fileType !== "image/jpg") {
                if(!$(".tech_icon_error").length){
                    $(".tech_icon").closest(".form-input").append('<label style="font-size:12px;" id="tech_icon-error" class="error tech_icon_error" for="tech_icon">Only JPG, JPEG and PNG files allowed.</label>');
                }
                return false;
            }
        } else {
            // console.log("No file selected");
        }
    });

    $(document).on("change", "input[type=file]", function () {
        var fileInput = $(".tech_icon")[0];
        $(".tech_icon_error").remove();
        $(".tech_icon_edit").remove();

        if (fileInput.files.length > 0) {
            var file = fileInput.files[0];
            $(".attachment-text").text("").text(file.name);
        }
    });

</script>