<script>
    $(".clientForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },

            email: {
                required: true,
                email: true
            },

            password: {
                minlength: 6
            },

            phone: {
                required: true,
                minlength: 10
            }
        },

        messages: {
            name: {
                required: "Name is required",
                minlength: "Minimum 3 characters required"
            },

            email: {
                required: "Email is required",
                email: "Enter valid email"
            },

            password: {
                required: "Password is required",
                minlength: "Minimum 6 characters required"
            },

            phone: {
                required: "Contact No is required"
            }
        },

        submitHandler: function(form) {
            // alert("Form submitted successfully");
            form.submit();
        }
    });

    // $(document).on("click", ".jsPassword", function(){
    //     $(this).attr("type", "text");
    // });
</script>