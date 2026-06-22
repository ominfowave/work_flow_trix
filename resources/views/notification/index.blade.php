@extends('layouts.main')
@section("content")
    <div id="notification_details" class="newmessage-details">
        <div class="projectsmain">

            @if (count($notifications))
                @foreach ($notifications as $item)
                    <div class="project-details">
                        <div class="project-text">
                            <p>{!! ucfirst(html_entity_decode($item->notification_label)) !!}</p>
                            {{-- <div class="employe-name"><span>@Samir &nbsp;</span><p class="employe-text"> You have not start this project</p></div> --}}
                            <div class="project-date-time">
                                <span><img src="{{ asset('/images/cal-icon.svg')}}" alt="">{{ $item->created_at->format('d M-Y') }}</span>
                                <span><img src="{{ asset('/images/clock-icon.svg')}}" alt="">{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</span>
                            </div>
                        </div>

                        @if ($item->table_name == 'projects')
                            <a href="{{route('projectTimeline', $item->table_id)}}">
                                <div class="leftarrow notification-leftarrow"><button type="button" class="move_chatbox_btn"><img src="{{ asset('/images/left-arrow.svg')}}" alt=""></button></div>
                            </a>
                        @endif
                    </div>
                @endforeach
            @endif
            
        </div>
    </div>
@endsection