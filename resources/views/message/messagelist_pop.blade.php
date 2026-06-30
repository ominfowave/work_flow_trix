@if (count($userList))
    @foreach ($userList as $user_list)
        <div class="chat-user-details-pop jsUserDetails" data-userid="{{$user_list->id}}">
            <div class="chat-user">
                <img src="{{asset('/images/dp-img.png')}}" alt="">
            </div>
            <div class="chat-and-duration">
                <div class="chatuser-name-details">
                    <h3 class="jspopUsername" data-userrole="{{$user_list->role->name ?? ''}}">{{$user_list->full_name ?? ''}}</h3>
                    <p>{{$user_list->last_message ?? ''}}</p>
                </div>
                <div class="chatduration">
                    <p class="chatTime">
                        @php
                            $getDate = \Carbon\Carbon::parse($user_list->last_message_date);
                            $diffDate = $getDate->diff(now());
                            
                            if($diffDate->days >= 7){
                                $last_date = $getDate->format('d/m/Y');
                            }else if($diffDate->days == 0){
                                $last_date = 'Today';
                            }else{
                                $last_date = now()->subDays($diffDate->days)->format('D');
                            }
                        @endphp
                        {{ $last_date ?? ''}}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
@endif