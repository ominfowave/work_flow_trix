@extends('layouts.main')
@section('title', 'Dashboard')

@section("content")
<div  class="newmessage-details">
    <div class="total-no-of-project">
        <div class="btn-no-project">
            <button class="total-project-no">{{$total_project ?? 0}}</button>
            <button class="total-project">Projects</button>
        </div>
    </div>

    <div class="project-tabs">
        <ul class="tabs">
            @php
                $latest_project_count = $latest_pro_read_count ?? 0;
                $unapproved_project_count = $read_count_pro_unaproved ?? 0;
                $unapproved_client_count = $read_count_client ?? 0;
            @endphp
            <li>
                <a href="#;" class="active latest_project jstab" data-tab="latest_project">
                    Latest Projects 
                    @if($latest_project_count > 0)
                        <span>{{$latest_project_count}}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#;" class="unapproved_project jstab" data-tab="unapproved_project">
                    Unapproved Projects 
                    @if($unapproved_project_count > 0)
                        <span>{{$unapproved_project_count}}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="#;" class="unapproved_client jstab" data-tab="unapproved_client">
                    Unapproved Clients
                    @if($unapproved_client_count > 0)
                        <span>{{$unapproved_client_count}}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>

    <div class="tabs-details active latest_project_content" id="tab1">
        <div class="projectsmain" >
            @if (count($latest_project) > 0)
                @foreach ($latest_project as $item)
                    <div class="projectsdetails">
                        <div class="project-desc">
                            <div class="project-name-dt">
                                <div class="project-name"><p>{{$item->title}}</p></div>
                                <div class="project-date-time res-project-date-time">
                                    <span><img src="{{ asset('/images/cal-icon.svg') }}" alt="">{{date('d M-Y', strtotime($item->created_at))}}</span>
                                    <span><img src="{{ asset('/images/clock-icon.svg') }}" alt="">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="new-message-desc"><span>New Message:&nbsp;</span><p>{{ $item->message ?? ''}}</p></div>
                        </div>
                        <div class="leftarrow">
                            <a href="{{route('projectTimeline', $item->table_id)}}">
                                <button type="button" class="move_chatbox_btn"><img src="{{ asset('/images/left-arrow.svg') }}" alt=""></button>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
           
           
        </div>
    </div>

    <div class="tabs-details unapproved_project_content" id="tab2">
        <div class="projectsmain">
            @if (count($unapproved_project) > 0)
                @foreach ($unapproved_project as $item)
                    <div class="projectacceptreject projectacceptreject-btn">
                        <div class="new-add-project">
                            <p>{!! isset($item->notification_label) ? html_entity_decode($item->notification_label) : '' !!}</p>
                            <div class="project-date-time">
                                <span><img src="{{ asset('/images/cal-icon.svg') }}" alt="">{{date('d M-Y', strtotime($item->created_at))}}</span>
                                <span><img src="{{ asset('/images/clock-icon.svg') }}" alt="">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="accept-reject-desc">
                            <div class="accept-reject-btn">
                                <button type="button" class="accept-btn jsProReqAccept" data-projectid="{{$item->id}}">Accept</button>
                                <button type="button" class="reject-btn reject-down-arrow-btn jsProReqReject" data-projectid="{{$item->id}}">Reject <img src="{{ asset('/images/reject-down-arrow.svg') }}" alt=""></button>
                            </div>
                            <a href="{{route('projectTimeline', $item->id)}}">
                                <div class="leftarrow"><button type="button" class="move_chatbox_btn"><img src="{{ asset('/images/left-arrow.svg') }}" alt=""></button></div>
                            </a>
                        </div>
                        <div class="reject-reason-details">
                            <input type="hidden" name="project_id" class="jsproIdReReason" value="{{$item->id}}">
                            <input type="text" name="" class="jsRejectRea" id="" placeholder="Enter the reject reason">
                            <button class="reject-reason-btn jsReajectBtn">Submit</button>
                        </div>
                    </div>
                @endforeach
            @endif
           
        </div>
    </div>

    <div class="tabs-details unapproved_client_content" id="tab3">
        <div class="projectsmain">
            {{-- @dd($unapproved_client) --}}
             @if (count($unapproved_client) > 0)
                @foreach ($unapproved_client as $item)
                    <div class="projectsdetails">
                        <div class="project-desc client_project-desc">
                            <div class="poject-name-email-mobile">                                        
                                <div class="project-name-dt cient_project-name-dt">
                                    <div class="project-name unapproving-project"><p>{{$item->title ?? ''}}</p></div>
                                </div>
                                <div class="client_email_mobile">
                                    {!! isset($item->message) ? html_entity_decode($item->message) : '' !!}
                                </div>
                            </div>
                            
                            <div class="unapproving-client-desc">
                                <div class="accept-reject-btn">
                                    <button type="button" class="accept-btn jsClientReqAccept" data-projectid="{{$item->id}}">Accept</button>
                                    <button type="button" class="reject-btn reject-down-arrow-btn jsClientReqReject" data-projectid="{{$item->id}}">Reject <img src="{{ asset('/images/reject-down-arrow.svg') }}" alt=""></button>
                                </div>
                            </div>
                            <div class="unapprove-reject-reason-details jsClientRejectform">
                                <input type="hidden" name="project_id" class="jsclientIdReject" value="{{$item->id}}">
                                <input type="text" name="" class="jsClientRejectInput" placeholder="Enter the reject reason">
                                <button class="reject-reason-btn jsClientRejectBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>
@endsection