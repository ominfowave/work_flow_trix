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