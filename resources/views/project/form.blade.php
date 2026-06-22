@if(session('error'))
<div class="custom-alert" style="margin-top: 55px;">
    <ul style="margin:0; padding-left:18px;">
        @foreach(session('error') as $field => $messages)
                    <li>{{ $messages }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $project_name = $assigned_team_members = $client_id = $status = $description = '';

    if(old('!project_name') !== null){
        $project_name = old('project_name');
    }elseif (isset($project->project_name)) {
        $project_name = $project->project_name;
    }

    if(old('client_id') !== null){
        $client_id = old('client_id');
    }elseif (isset($project->client_id)) {
        $client_id = $project->client_id;
    }

    if(old('assigned_team_members') !== null){
        $assigned_team_members = old('assigned_team_members');
    }elseif (isset($project->assigned_team_members)) {
        $assigned_team_members = $project->assigned_team_members;
    }

    if(old('status') !== null){
        $status = old('status');
    }elseif (isset($project->status)) {
        $status = $project->status;
    }

    if(old('description') !== null){
        $description = old('description');
    }elseif (isset($project->description)) {
        $description = $project->description;
    }
@endphp 

 <div class="create-form-main createprojectmain">
    <div class="createform-details ">
        <div class="form-input">
            <input type="text" placeholder="Project Name" name="project_name" value="{{$project_name}}">
        </div>
        <div class="form-input">
            <div class="select-project-ddl">
                <select name="assigned_team_members">
                    <option disabled selected>Assigned Team Members</option>
                    @if (count($users) > 0)
                        @foreach ($users as $item)
                            <option value="{{$item->id}}" {{$assigned_team_members == $item->id ? 'selected' : ''}}>{{$item->name ?? ''}}</option>
                        @endforeach
                    @endif
                </select>
                <img src="{{ asset('/images/down-arrow.svg')}}" alt="">
            </div>
        </div>
        <div class="form-input">
            <div class="select-project-ddl">
                <select name="client_id">
                    <option disabled selected>Select Client</option>
                    @if (count($clients) > 0)
                        @foreach ($clients as $item)
                            <option value="{{$item->id}}" {{$client_id == $item->id ? 'selected' : ''}}>{{$item->name ?? ''}}</option>
                        @endforeach
                    @endif
                </select>
                <img src="{{ asset('/images/down-arrow.svg')}}" alt="">
            </div>
        </div>
        <div class="form-input">
            <div class="select-project-ddl">
                <select id="action" name="status" required>
                    <option selected disabled>Status</option>

                    <option value="inquire" {{$status == 'inquire' ? 'selected' : ''}}>Inquire</option>
                    <option value="in_discussion" {{$status == 'in_discussion' ? 'selected' : ''}}>In Discussion</option>
                    <option value="in_negotion" {{$status == 'in_negotion' ? 'selected' : ''}}>In Negotion</option>
                    <option value="client_approved" {{$status == 'client_approved' ? 'selected' : ''}}>Client Approved</option>
                    <option value="in_progress" {{$status == 'in_progress' ? 'selected' : ''}}>In Progress</option>
                    <option value="completed" {{$status == 'completed' ? 'selected' : ''}}>Completed</option>
                </select>
                <img src="{{ asset('/images/down-arrow.svg')}}" alt="">
            </div>
        </div>
        <div class="form-input">
            <textarea class="project-textarea" placeholder="Project Description" name="description">{{$description}}</textarea>
        </div>
    </div>

    <div class="uploadfile-details">
        <div class="form-input">
            <label class="attachment-box attachment-file">
                <div class="attachment-text">Upload Files</div>
                <div class="upload-btn file-uploaded"><img src="{{ asset('/images/file-upload.svg')}}" alt=""></div>
                <input type="file" name="images[]" class="project_file" multiple />
                @if (isset($project->id))
                    <input type="hidden" name="delete_file" class="jsDltFileInput">
                @endif
            </label>
            <div><p>You can upload multiple files.</p></div>
        </div>
        <div class="uploadfile-main">
            @if (isset($project->productFile) && count($project->productFile) > 0)
                @php
                    $isImgPdf = false;
                @endphp
                @foreach ($project->productFile as $item)
                    @php
                        $icon = '';
                        $fileName = explode(".",$item->file_name);
                        $fileType = $fileName[1];
                        // Image
                        if (
                            $fileType === "jpeg" ||
                            $fileType === "png" ||
                            $fileType === "jpg"
                        ) {
                            $isImgPdf = true;
                            $icon = asset('/images/jpg-file-icon.svg');
                        }
                        
                        // PDF
                        else if ($fileType === "pdf") {
                            $isImgPdf = true;
                            $icon = asset('/images/pdf-file-icon.svg');
                        }
                        
                        // Word
                        else if (
                            $fileType === "doc" ||
                            $fileType === "docx"
                        ) {
                            $icon = asset('/images/word-file-icon.svg');
                        }
                        
                        // Excel
                        else if (
                            $fileType === "xls" ||
                            $fileType === "xlsx"
                        ) {
                            $icon = asset('/images/excell-file-icon.svg');
                        }

                    @endphp

                    <div class="uploadfile-desc">
                        <img src="{{$icon}}" alt="">
                        <p>{{$fileName[0] ?? ''}}</p>
                        @if($isImgPdf)
                            <img class="previewFilebtn" data-filesrc="{{asset('project_file/'.$item->file_name)}}" style="cursor:pointer;" src="{{ asset('/images/eye-icon.svg') }}" alt="">
                        @endif 
                        <div class="recent-close-icon jsRemoveFile" data-id="{{$item->id}}">
                            <img src="{{ asset('/images/close.svg') }}" alt="">
                        </div>
                    </div>
                    
                @endforeach
               
            @endif
        </div>
    </div>
    </div>

<script src="{{asset('./js/jquery.min.js')}}"></script>    
<script src="{{asset('./js/jquery.validate.js')}}"></script>    

@include('project.script')
    