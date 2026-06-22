<script>
    $(".adminForm").validate({
        rules: {
            full_name: {
                required: true,
                minlength: 3
            },

            name: {
                required: true,
                minlength: 3
            },

            role_id: {
                required: true
            },

            tech_id: {
                required: true
            },

            password: {
                minlength: 6
            }
        },

        messages: {
                full_name: {
                    required: "Full Name is required",
                    minlength: "Minimum 3 characters required"
                },
                name: {
                    required: "User Name is required",
                    minlength: "Minimum 3 characters required"
                },

                role_id: {
                    required: "Role is required"
                },

                tech_id: {
                    required: "Tech is required"
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