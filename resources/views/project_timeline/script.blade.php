<script>
$(document).on("click", ".projecttimeline-dropdown", function(){
    if($(".projecttimeline-comment").hasClass('show')){
        $(".projecttimeline-comment").removeClass('show');
        $(".projecttimeline-btn").removeClass('active');
    }else{
        $(".projecttimeline-comment").addClass('show');
        $(".projecttimeline-btn").addClass('active');
    }
});


let selectedFiles = [];
let selectedFilesEdit = {};

$(document).on("change", ".jsFile", function () {
    var currentEle = $(this);
    
    $.each(this.files, function (index, file) {
        selectedFiles.push(file);

        var random = Math.random().toString(36).substring(2, 8).toUpperCase();
        var randomIndex = 'index-' + Date.now() + '-' + random;

        file.previewIndex = randomIndex;

        var fileName = file.name;
        var extension = fileName.split('.').pop().toLowerCase();

        var icon = "{{ asset('/images/file-icon.svg') }}";

        if (extension === "pdf") {
            icon = "{{ asset('/images/pdf-file-icon.svg') }}";
        } else if (['jpg','jpeg','png','gif','webp'].includes(extension)) {
            icon = "{{ asset('/images/jpg-file-icon.svg') }}";
        } else if (['doc','docx'].includes(extension)) {
            icon = "{{ asset('/images/word-file-icon.svg') }}";
        } else if (['xls','xlsx','csv'].includes(extension)) {
            icon = "{{ asset('/images/excel-file-icon.svg') }}";
        }

        var preview = `
            <div class="file-card" data-index="${randomIndex}">
                <div class="file-left">
                    <img src="${icon}" alt="">
                    <div class="file-info">
                        <div class="file-name">${fileName}</div>
                    </div>
                </div>
                <span class="remove jsRemoveFile" data-index="${randomIndex}">
                    <img src="{{ asset('/images/close.svg') }}" alt="">
                </span>
            </div>
        `;

        currentEle.closest(".chatbox").find(".jsFilePreview").append(preview);
    });

    updateFileInput();
});

$(document).on("change", ".jsFileEdit", function () {
    var currentEle = $(this);
    var timelineId = currentEle.closest(".timeline-card").attr("data-id");
    
    $.each(this.files, function (index, file) {

        if(timelineId){
            if (!selectedFilesEdit[timelineId]) {
                selectedFilesEdit[timelineId] = [];
            }

            selectedFilesEdit[timelineId].push(file);
        }

        var random = Math.random().toString(36).substring(2, 8).toUpperCase();
        var randomIndex = 'index-' + Date.now() + '-' + random;

        file.previewIndex = randomIndex;

        var fileName = file.name;
        var extension = fileName.split('.').pop().toLowerCase();

        var icon = "{{ asset('/images/file-icon.svg') }}";

        if (extension === "pdf") {
            icon = "{{ asset('/images/pdf-file-icon.svg') }}";
        } else if (['jpg','jpeg','png','gif','webp'].includes(extension)) {
            icon = "{{ asset('/images/jpg-file-icon.svg') }}";
        } else if (['doc','docx'].includes(extension)) {
            icon = "{{ asset('/images/word-file-icon.svg') }}";
        } else if (['xls','xlsx','csv'].includes(extension)) {
            icon = "{{ asset('/images/excel-file-icon.svg') }}";
        }

        var preview = `
            <div class="file-card" data-index="${randomIndex}">
                <div class="file-left">
                    <img src="${icon}" alt="">
                    <div class="file-info">
                        <div class="file-name">${fileName}</div>
                    </div>
                </div>
                <span class="remove jsRemoveFile" data-index="${randomIndex}">
                    <img src="{{ asset('/images/close.svg') }}" alt="">
                </span>
            </div>
        `;

        currentEle.closest(".chatbox").find(".jsFilePreview").append(preview);
    });

    if(timelineId){
        updateFileInputEdit(timelineId);
    }

});

function updateFileInputEdit(timelineId)
{
    let dt = new DataTransfer();

    if (selectedFilesEdit[timelineId]) {

        selectedFilesEdit[timelineId].forEach(function(file){
            dt.items.add(file);
        });
    }

    $('.jstimeline_' + timelineId)
        .find('.jsFileEdit')
        .prop('files', dt.files);
}

$(document).on("click", ".jsRemoveFile", function () {

    var element = $(this);
    var indexRmv = element.data("index");
    var timelineId = element.closest(".timeline-card").data("id");

    element.closest(".file-card").remove();

    if (timelineId) {

        if (selectedFilesEdit[timelineId]) {

            selectedFilesEdit[timelineId] =
                selectedFilesEdit[timelineId].filter(function(file) {
                    return file.previewIndex !== indexRmv;
                });

            updateFileInputEdit(timelineId);
        }

    } else {

        selectedFiles = selectedFiles.filter(function(file) {
            return file.previewIndex !== indexRmv;
        });

        updateFileInput();
    }
});

function updateFileInput() {
    let dt = new DataTransfer();

    selectedFiles.forEach(file => {
        dt.items.add(file);
    });

    $(".jsFile")[0].files = dt.files;
}


$(document).on("click", ".jsRemoveFileEdit", function () {
    var currentElement = $(this);
    var id = currentElement.attr("data-id");
    var delete_file_hidden = currentElement.closest(".chatbox").find(".jsEditDeleteFile");
    var delete_file_data = delete_file_hidden.val(); 


    if(delete_file_data == ''){
        delete_file_hidden.val(id);
    }else{
        delete_file_hidden.val(delete_file_data + "," + id);
    }


   

    currentElement.closest(".file-card").remove();
});

$(document).on("click", ".jsSendBtn", function (e) {

    e.preventDefault();
    var currentElement = $(this);
    var parentEle = currentElement.closest(".chatbox");

    var input_field = parentEle.find(".jsInputMsg").val();
    var project_id = '{{$project->id}}';

    var files = parentEle.find(".jsFile")[0].files;
    var project_name = $(".jsProjectName").text();

    var formData = new FormData();

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('project_id', project_id);
    formData.append('message', input_field);
    formData.append('project_name', project_name);

    // Multiple files
    $.each(files, function (index, file) {
        formData.append('file[]', file);
    });

    $.ajax({
        url: '{{ route("projectTimelineStore") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            
            parentEle.find(".jsInputMsg").val('');
            parentEle.find(".jsFile").val('');
            parentEle.find(".jsFilePreview").html('');

           var html = timelineListCode(response.data.message,response.data.project_timeline_file,response.data.id);

           var data = `
                        <div class="vertical-dotts vertical-dotts-24"><img src="{{asset('images/vertical-dotts.png')}}" alt=""></div>
                        <div class="timeline-card jstimeline_${response.data.id}" data-id="${response.data.id}">
                            ${html}
                        </div>`;

            $(".jsChatBoxContent").before(data);
        },

        error: function (xhr) {
        }
    });

});

function timelineListCode(message,project_timeline_file,timeline_id){
    var editRoute = '{{ route("projectTimelineEdit", ":id") }}';
            editRoute = editRoute.replace(':id', timeline_id);

            var deleteRoute = '{{ route("projectTimelineDelete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', timeline_id);

            var filesHtml = '';

            project_timeline_file.forEach(function(item){

                var file = item.file;
                var extension = file.split('.').pop().toLowerCase();

                var icon = "{{ asset('/images/file-icon.svg') }}";

                if (extension === 'pdf') {
                    icon = "{{ asset('/images/pdf-file-icon.svg') }}";
                } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                    icon = "{{ asset('/images/jpg-file-icon.svg') }}";
                } else if (['doc', 'docx'].includes(extension)) {
                    icon = "{{ asset('/images/word-file-icon.svg') }}";
                } else if (['xls', 'xlsx', 'csv'].includes(extension)) {
                    icon = "{{ asset('/images/excel-file-icon.svg') }}";
                }

                filesHtml += `
                    <div class="timelinefiles-details jstimeline_data_${timeline_id}">
                        <div class="timeline-files">
                            <img src="${icon}" alt="">
                            <p>${file}</p>

                            <a href="{{ asset('project_timeline') }}/${file}" target="_blank">
                                <img src="{{ asset('/images/eye-icon.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                `;
            });

          var html = `
                <div class="timeline-desc jstimeline_data_${timeline_id}">
                    <div class="timeline-text">
                        <p>${message || ''}</p>
                    </div>

                    <div class="timeline-btn">
                        <button type="button"
                            class="jsTimelineEdit"
                            data-id="${timeline_id}"
                            data-route="${editRoute}">
                            <img src="{{ asset('/images/timeline-edit-icon.svg') }}" alt="">
                        </button>

                        <button type="button"
                            class="jsDelete"
                            data-title="Project Timeline"
                            data-id="${timeline_id}"
                            data-href="${deleteRoute}">
                            <img src="{{ asset('/images/timeline-delete-icon.svg') }}" alt="">
                        </button>
                    </div>
                </div>

                ${filesHtml}
            `;

            return html;
}

$(document).on("click", ".jsSendBtnEdit", function (e) {
    e.preventDefault();

    var currentElement = $(this);
    var timeline_id = currentElement.attr("data-id");
    var parentElement = currentElement.closest(".chatbox");

    var input_field = parentElement.find(".jsInputMsg").val();
    var delete_file_ids = parentElement.find(".jsEditDeleteFile").val();
    
    var project_id = '{{$project->id}}';

    var files = parentElement.find(".jsFileEdit")[0].files;

    var formData = new FormData();

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('project_id', project_id);
    formData.append('message', input_field);
    formData.append('delete_file_ids', delete_file_ids);

    // Multiple files
    $.each(files, function (index, file) {
        formData.append('file[]', file);
    });

    var url = '{{ route("projectTimelineUpdate", ":id") }}';
        url = url.replace(':id', timeline_id);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            parentElement.find(".jsInputMsg").val('');
            parentElement.find(".jsFileEdit").val('');
            parentElement.find(".jsFilePreview").html('');

            var editRoute = '{{ route("projectTimelineEdit", ":id") }}';
            editRoute = editRoute.replace(':id', timeline_id);

            var deleteRoute = '{{ route("projectTimelineDelete", ":id") }}';
            deleteRoute = deleteRoute.replace(':id', timeline_id);

            var filesHtml = '';

            response.data.project_timeline_file.forEach(function(item){

                var file = item.file;
                var extension = file.split('.').pop().toLowerCase();

                var icon = "{{ asset('/images/file-icon.svg') }}";

                if (extension === 'pdf') {
                    icon = "{{ asset('/images/pdf-file-icon.svg') }}";
                } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                    icon = "{{ asset('/images/jpg-file-icon.svg') }}";
                } else if (['doc', 'docx'].includes(extension)) {
                    icon = "{{ asset('/images/word-file-icon.svg') }}";
                } else if (['xls', 'xlsx', 'csv'].includes(extension)) {
                    icon = "{{ asset('/images/excel-file-icon.svg') }}";
                }

                filesHtml += `
                    <div class="timelinefiles-details jstimeline_data_${timeline_id}">
                        <div class="timeline-files">
                            <img src="${icon}" alt="">
                            <p>${file}</p>

                            <a href="{{ asset('project_timeline') }}/${file}" target="_blank">
                                <img src="{{ asset('/images/eye-icon.svg') }}" alt="">
                            </a>
                        </div>
                    </div>
                `;
            });

          var html = `
                    <div class="timeline-desc jstimeline_data_${timeline_id}">
                        <div class="timeline-text">
                            <p>${response.data.message || ''}</p>
                        </div>

                        <div class="timeline-btn">
                            <button type="button"
                                class="jsTimelineEdit"
                                data-id="${timeline_id}"
                                data-route="${editRoute}">
                                <img src="{{ asset('/images/timeline-edit-icon.svg') }}" alt="">
                            </button>

                            <button type="button"
                                class="jsDelete"
                                data-title="Project Timeline"
                                data-id="${timeline_id}"
                                data-href="${deleteRoute}">
                                <img src="{{ asset('/images/timeline-delete-icon.svg') }}" alt="">
                            </button>
                        </div>
                    </div>

                    ${filesHtml}
                `;
            
            currentElement.closest(".jstimeline_"+timeline_id).html('').html(html);
            // $(".jstimeline_data_"+timeline_id).remove();
        },
        error: function (xhr) {
        }
    });
});


$(document).on("click", ".jsCancelBtnEdit", function (e) {
    var id = $(this).attr("data-id");
    $(".jstimeline_data_"+id).show();
    $(this).closest(".chatbox").remove();
});


$(document).on("click", ".jsTimelineEdit", function (e) {
    var element = $(this);
    var route = element.attr("data-route");
    var id = element.attr("data-id");

    $.ajax({
        url: route,
        type: 'POST',
        data: {_token: '{{csrf_token()}}'},
        success: function (response) {
            
            let filesHtml = '';

            if (response.project_timeline_file && response.project_timeline_file.length > 0) {

                response.project_timeline_file.forEach(function(item) {

                    let file = item.file;
                    let extension = file.split('.').pop().toLowerCase();

                    let icon = "{{ asset('/images/file-icon.svg') }}";

                    if (extension === 'pdf') {
                        icon = "{{ asset('/images/pdf-file-icon.svg') }}";
                    } else if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                        icon = "{{ asset('/images/jpg-file-icon.svg') }}";
                    } else if (['doc', 'docx'].includes(extension)) {
                        icon = "{{ asset('/images/word-file-icon.svg') }}";
                    } else if (['xls', 'xlsx', 'csv'].includes(extension)) {
                        icon = "{{ asset('/images/excel-file-icon.svg') }}";
                    }

                    filesHtml += `
                        <div class="file-card" data-id="${item.id}">
                            <div class="file-left">
                                <img src="${icon}" alt="">
                                <div class="file-info">
                                    <div class="file-name">${file}</div>
                                </div>
                            </div>

                            <span class="remove jsRemoveFileEdit"
                                data-id="${item.id}"
                                data-file="${file}">
                                <img src="{{ asset('/images/close.svg') }}" alt="">
                            </span>
                        </div>
                    `;
                });
            }

            let html = `
                <div class="chatbox">
                    <div class="textareawithsharebtn">
                        <textarea class="editor jsInputMsg" placeholder="Enter discussion...">${response.message ?? ''}</textarea>
                        <input type="hidden" name="delete_files" class="jsEditDeleteFile" style="display:none;">

                        <div class="toolbar-edit-timeline">
                            <label class="attach-btn">
                                <input type="file" name="file[]" class="jsFileEdit" style="display:none;" multiple>
                                <img src="{{ asset('/images/file-attach-icon.svg') }}" alt="">
                            </label>

                            <button type="submit" class="send-btn-edit jsSendBtnEdit" data-id="${response.id}" >
                                Save
                            </button>
                            <button type="submit" class="cencel-btn jsCancelBtnEdit" data-id="${response.id}" >
                                Cancel
                            </button>
                        </div>
                    </div>

                    <div class="file-list jsFilePreview">
                        ${filesHtml}
                    </div>
                </div>
            `;
            

            $(".jstimeline_data_" + response.id).hide();
            $(".jstimeline_" + response.id).append(html);
        },

        error: function (xhr) {
        }
    });
});

</script>