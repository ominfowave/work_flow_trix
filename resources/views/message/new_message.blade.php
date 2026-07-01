
{{-- @dd(count($messages->messageFile)) --}}
@php
    $contentCount = isset($messages->messageFile) ? count($messages->messageFile) : 0;
    $messageDate = \Carbon\Carbon::parse($messages->created_at);
@endphp
<div class="message-row right jsreceiver_id" data-receiver_id="{{$receiver_id ?? null}}">
    <div class="message-text {{$contentCount == 1 ? 'cust-message-text' : ''}}">
        <p>{{ $messages->message }}</p>
        @if ($messages->messageFile && count($messages->messageFile))
        <div class="chatinner-files">
            @foreach ($messages->messageFile as $messageFile)
                @php
                    $icon = '';
                    $files = explode(".", $messageFile->file_name);
                    $isFile = false;

                    $fileType = $files[1];
                    if ($fileType === "jpeg" || $fileType === "png" || $fileType === "jpg") {
                        $icon = asset('/images/jpg-file-icon.svg');
                    }else if ($fileType === "pdf") {
                        $icon = asset('/images/pdf-file-icon.svg');
                        $isFile = true;
                    }else if ($fileType === "doc" || $fileType === "docx") {
                        $icon = asset('/images/word-file-icon.svg');
                    }else if ( $fileType === "xls" || $fileType === "xlsx" ) {
                        $icon = asset('/images/excell-file-icon.svg');
                    }

                    $filePath = public_path('chat-files/' . $messageFile->file_name);

                    $size = file_exists($filePath) ? filesize($filePath) : 0;

                    if ($size >= 1024 * 1024) {
                        $fileSize = round($size / (1024 * 1024), 2) . ' MB';
                    } else {
                        $fileSize = round($size / 1024, 2) . ' KB';
                    }

                @endphp

                @if ($contentCount == 1 && ($fileType === "jpeg" || $fileType === "png" || $fileType === "jpg"))
                    <div class="chatinner-images single-image">
                        <div class="sub-chatiner-img cust-sub-chatiner-img">
                            <img class="imagepopup" data-file="{{$messageFile->file_name ?? ''}}"  src="{{  asset('chat-files/' . $messageFile->file_name) }}" alt="">
                            <a href="{{ asset('chat-files/' . $messageFile->file_name) }}" download>
                                <div class="signle-image-download-arrow"><img class="img_down" src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                            </a>
                        </div>
                    </div>
                @else
                    @if ($fileType === "jpeg" || $fileType === "png" || $fileType === "jpg")
                        <div class="file-card" data-index="0">
                            <div class="file-left cust-file-left">
                                <img class="imagepopup" src="{{ asset('chat-files/' . $messageFile->file_name)}}" alt="">

                                <div class="file-info">
                                    <div class="file-name">
                                        <div class="file-name cust-file-name">
                                            {{$messageFile->file_name ?? ''}}
                                        </div>
                                    </div>
                                    <div class="file-size">{{ $fileSize }}</div>
                                </div>

                            </div>
                            <a href="{{ asset('chat-files/' . $messageFile->file_name) }}" download>
                            <div class="file-download-arrow"><img class="img_down" src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                            </a>
                        </div>
                    @else
                        <div class="file-card" data-index="0">
                            <div class="file-left cust-file-left {{$isFile ? 'imagepopupPdf' : 'jsIsNotPdf' }}" data-filesrc="{{asset('chat-files/' . $messageFile->file_name)}}">
                                <img src="{{$icon ?? ''}}" alt="">
                                <div class="file-info">
                                    <div class="file-name">
                                        <div class="file-name cust-file-name">
                                            {{$messageFile->file_name ?? ''}}
                                        </div>
                                    </div>
                                    <div class="file-size">{{ $fileSize }}</div>
                                </div>
                            </div>
                            <a href="{{ asset('chat-files/' . $messageFile->file_name) }}" download>
                                <div class="file-download-arrow"><img class="img_down" src="{{asset('/images/download-icon.svg')}}" alt=""></div>
                            </a>
                        </div>
                    @endif
                @endif
                
            @endforeach
        </div>
        @endif

        <span>{{ $messageDate->format('h:i A') }}</span>
    </div>


    {{-- @if ($is_pop_user == false)
        <div class="messanger-name">
            <img src="{{asset('/images/dp-img.png')}}" alt="">
        </div>
    @endif --}}
</div>