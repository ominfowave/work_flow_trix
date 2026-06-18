<header class="headersection">
        <div class="main_container">
            <div class="header-details">
                <div class="logo-details">
                    <a href="#;">
                        <img src="{{asset('/images/new_logo.png')}}" alt="">
                    </a>
                </div>
                @php
                    $user = auth()->guard('admin')->user();
                    $notification = \App\Models\Notification::select('notification_label')->where('receiver_id', $user->id)->where('is_read', '1')->orderBy('id', 'desc')->limit(3)->get();
                    $notiCount = count($notification);
                @endphp
                <div class="icon-details">
                    <div class="icon-desc">
                        <a href="{{route('notifications')}}">
                            <button type="button" class="btn-icon" id="notification_id">
                                <img src="{{asset('/images/notification-icon.svg')}}" alt="">
                                @if ($notiCount > 0)
                                    <div class="notification">{{$notiCount}}</div>
                                @endif
                            </button>
                        </a>
                        
                        <div class="notifiPop" style="{{$notiCount <= 0 ? 'display:none;' : ''}}">
                            <ul>
                                @if ($notiCount > 0)
                                    @foreach ($notification as $item)
                                        <li>
                                            <a href="#;">
                                                <p>{!! isset($item->notification_label) ? html_entity_decode($item->notification_label) : '' !!}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                                
                            </ul>
                            <a href="{{route('notifications')}}">View All</a>
                        </div>
                    </div>
                </div>

                <div class="menuIcon">
                    <a href="#;"><img src="{{asset('images/menu.png')}}" alt=""> </a>
                </div>
            </div>
        </div>
     </header>