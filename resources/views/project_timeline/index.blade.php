@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <div class="leftarrow">
                        <a href="javascript:history.back()">
                            <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                        </a>
                    </div>
                    <h2>Project Timeline</h2>
                </div>
                <div class="projectsmain">
                    @if(session('success'))
                        <div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>{{ session('success') ?? '' }}</span>
                        </div>
                    @endif

                     <div class="projecttimeline-main">
                        <div class="projecttimeline-dropdown" id="project-timeline-dropdown">
                            <div class="projecttimeline-name">
                                <img src="{{asset('/images/projecttimeline-user.png')}}" alt="">
                                <h3>Project <span class="jsProjectName">{{$project->project_name ?? ''}}</span></h3>
                            </div>
                            <button class="projecttimeline-btn"><img src="{{asset('/images/project-time-line-arrow.svg')}}" alt=""></button>
                        </div>

                        <div class="projecttimeline-comment">
                            <p>{{$project->description ?? ''}}</p>
                        </div>
                    </div>    
                            
                    <div class="timeline-details">
                        <h3>Timeline</h3>

                        @if (count($project_timelines) > 0)
                            @foreach ($project_timelines as $key => $item)
                                <div class="timeline-card jstimeline_{{$item->id}}" data-id="{{$item->id}}">

                                    <div class="timeline-desc jstimeline_data_{{$item->id}}">
                                        <div class="timeline-text">
                                            <p>{{$item->message ?? ''}}</p>
                                        </div>
                                        <div class="timeline-btn">
                                            @if ($user_id == $item->sender_id)
                                                <button type="button" class="jsTimelineEdit" data-id="{{$item->id}}" data-route="{{route('projectTimelineEdit', $item->id)}}"><img src="{{asset('/images/timeline-edit-icon.svg')}}" alt=""></button>
                                                
                                                <button type="button" class="jsDelete" data-title="Project Timeline" data-id="{{$item->id}}" data-href="{{route('projectTimelineDelete', $item->id)}}">
                                                    <img src="{{asset('/images/timeline-delete-icon.svg')}}" alt="">
                                                </button>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="timelinefiles-details jstimeline_data_{{$item->id}}">
                                            @if (isset($item->projectTimelineFile) && count($item->projectTimelineFile))

                                                
                                                    @foreach ($item->projectTimelineFile as $projectTimelineFile)
                                                    @php
                                                            $icon = '';
                                                            $files = explode(".", $projectTimelineFile->file);
        
                                                            $fileType = $files[1];
                                                            if ($fileType === "jpeg" || $fileType === "png" || $fileType === "jpg") {
                                                                $icon = asset('/images/jpg-file-icon.svg');
                                                            }else if ($fileType === "pdf") {
                                                                $icon = asset('/images/pdf-file-icon.svg');
                                                            }else if ($fileType === "doc" || $fileType === "docx") {
                                                                $icon = asset('/images/word-file-icon.svg');
                                                            }else if ( $fileType === "xls" || $fileType === "xlsx" ) {
                                                                $icon = asset('/images/excell-file-icon.svg');
                                                            }
        
                                                        @endphp
                                                        <div class="timeline-files">
                                                            <img src="{{$icon ?? ''}}" alt="">
                                                            <p>{{$projectTimelineFile->file ?? ''}}</p>
                                                            <a href="{{asset('project_timeline/'. $projectTimelineFile->file)}}" target="_blank">
                                                                <img src="{{asset('/images/eye-icon.svg')}}" alt="">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                            @endif
                                          
                                    </div>
                                </div>

                                @if (array_key_last($project_timelines->toArray()) !== $key)
                                    <div class="vertical-dotts vertical-dotts-{{$item->id}}"><img src="{{asset('/images/vertical-dotts.png')}}" alt=""></div>
                                @endif

                            @endforeach
                        @endif

                        <div class="jsChatBoxContent">

                            <div class="chatbox" data-id="">
                                <div class="textareawithsharebtn">
                                    <textarea id="editor" class="editor jsInputMsg" placeholder="Enter discussion..."></textarea>
                                    <div class="toolbar-edit-timeline">
                                        <label class="attach-btn">
                                            <input type="file" name="file[]" id="fileInput" class="jsFile" style="display: none;" multiple>
                                            <img src="{{asset('/images/file-attach-icon.svg')}}" alt="">
                                        </label>
                                        <button type="submit" id="sendBtn" class="send-btn jsSendBtn"><img src="{{asset('/images/chat-shar-icon.svg')}}" alt=""></button>
                                    </div>
                                </div>
                                <div class="file-list jsFilePreview" id="fileList"></div>                                        
                            </div>

                        </div>
                    </div>
                 
                </div>
            </div>
    </div>

    <div class="admintogglepopup-timeline-edit">
        <div class="admintogglepopup-details">
            <div class="admintogglepopup-sub">
                <form action="" class="jsTimelineEditForm">
                    <div class="form-input">
                        <textarea class="project-textarea jsInputMsgEdit" placeholder="Project Description" name="description"></textarea>
                    </div>
                </form>
                <div class="admintogglepopup-btn">
                    <button type="submit" class="yes-btn jsYesBtnDlt">Update</button>
                </div>
                <button type="button" class="popup-close-icon jspopCloseDlt"><img src="{{asset('/images/close.svg')}}" alt=""></button>
            </div>
        </div>
    </div>
    <!-- end New Message -->
    <script src="{{asset('./js/jquery.min.js')}}"></script>    

    @include('project_timeline.script')
@endsection