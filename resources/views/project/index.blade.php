@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
        
         <!-- create client -->
            <div id="new_message" class="newmessage-details">
                <div class="productlist">
                    <h2>Projects</h2>
                    @if (auth()->guard('admin')->user()->can('project-add'))
                        <a href="{{route('project.create')}}">
                            <button type="button" class="create-project-btn">
                                <img src="{{asset('/images/plus-icon.svg')}}" alt="">Create Project
                            </button>
                        </a>
                    @endif
                </div>
                <div class="projectsmain">
                    @if(session('success'))
                        <div class="custom-alert success-alert" style="margin-top: 55px;">
                            <span>{{ session('success') ?? '' }}</span>
                        </div>
                    @endif
                    @if (count($project) > 0)
                        @foreach ($project as $item)
                            <div class="project-assigned-main">
                                <div class="clientname-projectname">
                                    <div class="clientname-left">
                                            <img src="{{asset('/images/client-img.png')}}" alt="">
                                            <h3>{{$item->getClient->name ?? ''}} <span>{{$item->project_name ?? ''}}</span></h3>
                                    </div>
                                    <div class="clientname-right">
                                        <a href="{{route('project.edit', $item->id)}}">
                                            <button type="button"><img src="{{asset('/images/project-edit-icon.svg')}}" alt=""></button>
                                        </a>    
                                        <button type="button" class="jsDelete" data-title="Project" data-href="{{route('project.destroy', $item->id)}}" data-id="{{$item->id}}"><img src="{{asset('/images/project-delete-icon.svg')}}" alt=""></button>
                                    </div>
                                </div>
                                <div class="project-assigned-team">
                                    <img src="{{asset('/images/assigned-icon.svg')}}" alt="">
                                    <p>Assigned to  <span class="assigned-name">{{$item->getUser->name ?? ''}}</span></p>
                                </div>
                                <hr class="custline">
                                <div class="project-assigned-comment">
                                    <p>{{$item->description ?? ''}}</p>
                                </div>
                                <div class="project-assigned-details">
                                    <div class="ddl-work-progress">
                                        <select class="jsStatus" data-title="Project" data-id="{{$item->id ?? ''}}" data-href="{{route('projectStatus')}}">
                                            <option value="inquire" {{$item->status == 'inquire' ? 'selected': ''}}>Inquire</option>
                                            <option value="in_discussion" {{$item->status == 'in_discussion' ? 'selected': ''}}>In Discussion</option>
                                            <option value="in_negotion" {{$item->status == 'in_negotion' ? 'selected': ''}}>In Negotion</option>
                                            <option value="client_approved" {{$item->status == 'client_approved' ? 'selected': ''}}>Client Approved</option>
                                            <option value="in_progress" {{$item->status == 'in_progress' ? 'selected': ''}}>In Progress</option>
                                            <option value="completed" {{$item->status == 'completed' ? 'selected': ''}}>Completed</option>
                                        </select>
        
                                    </div>
                                    <a href="{{route('projectTimeline', $item->id)}}">
                                        <div class="leftarrow lightbluearrow"><button type="button" class="move_chatbox_btn"><img src="{{asset('/images/left-arrow.svg')}}" alt=""></button></div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        <!-- end create client -->
    </div>
    <!-- end New Message -->
@endsection