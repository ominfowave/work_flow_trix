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