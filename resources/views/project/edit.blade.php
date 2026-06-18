@extends('layouts.main')
@section("content")
    <!-- New Message -->
    <div id="new_message" class="newmessage-details">
         <!-- create project -->
        <div id="create_project_list" class="newmessage-details">
            <div class="createproject-desc">
                <div class="leftarrow">
                    <a href="{{route('project.index')}}">
                        <button type="button" id=""><img src="{{asset('/images/right-arrow.svg')}}" alt=""></button>
                    </a>
                </div>
                <h2>Update project</h2>
            </div>
            <div class="create-form-main">
                <form action="{{route('project.update', $project->id)}}" method="POST" class="projectForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('project.form')
                    <div class="submit-btn"><button type="submit">Update</button></div>
                </form>
            </div>
        </div>
        <!-- end create project -->
    </div>
    <!-- end New Message -->
@endsection