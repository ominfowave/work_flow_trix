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