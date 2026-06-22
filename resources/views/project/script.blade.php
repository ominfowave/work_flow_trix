<script>
    $(".projectForm").validate({
        rules: {
            project_name: {
                required: true
            },

            assigned_tema_members: {
                required: true
            },

            client_id: {
                required: true
            }
        },

        messages: {
            project_name: {
                required: "Project Name is required"
            },

            assigned_tema_members: {
                required: "Assigned Team Members is required"
            },

            client_id: {
                required: "Client is required"
            }
        },

        submitHandler: function(form) {
            form.submit();
        }
    });

    $(document).on("change", ".project_file", function () {

        if (!this.files || this.files.length === 0) {
            return;
        }


        Array.from(this.files).forEach(function(file){

            console.log(file);

          
            
            var fileType = file.type;

            let icon = '';

            // Image
            if (
                fileType === "image/jpeg" ||
                fileType === "image/png" ||
                fileType === "image/jpg"
            ) {
                icon = "{{ asset('/images/jpg-file-icon.svg') }}";
            }

            // PDF
            else if (fileType === "application/pdf") {
                icon = "{{ asset('/images/pdf-file-icon.svg') }}";
            }

            // Word
            else if (
                fileType === "application/msword" ||
                fileType === "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            ) {
                icon = "{{ asset('/images/word-file-icon.svg') }}";
            }

            // Excel
            else if (
                fileType === "application/vnd.ms-excel" ||
                fileType === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            ) {
                icon = "{{ asset('/images/excell-file-icon.svg') }}";
            }

            else {
                return;
            }

            var fileUrl = URL.createObjectURL(file);

            var imageElement = `
                <div class="uploadfile-desc">
                    <img src="${icon}" alt="">
                    <p>${file.name}</p>
                    <img class="previewFilebtn" data-filesrc="${fileUrl || ''}" style="cursor:pointer;" src="{{ asset('/images/eye-icon.svg') }}" alt="">
                    <div class="recent-close-icon jsRemoveFile">
                        <img src="{{ asset('/images/close.svg') }}" alt="">
                    </div>
                </div>
            `;

            $(".uploadfile-main").append(imageElement);

        });

    });

    $(document).on('click', '.previewFilebtn', function () {
        var fileUrl = $(this).attr('data-filesrc');

        if (fileUrl) {
            window.open(fileUrl, '_blank');
        } else {
            alert('No file selected');
        }
    });

   $(document).on("click", ".jsRemoveFile", function () {
        var currentElement = $(this);
        var id = currentElement.attr('data-id');
        if(id){
            var currentVal = $(".jsDltFileInput").val();
            if(currentVal == ''){
                $(".jsDltFileInput").val(currentVal + id);
            }else{
                $(".jsDltFileInput").val( currentVal + "," + id);
            }
        }
        currentElement.closest(".uploadfile-desc").remove();
    });
    
</script>