
@extends('layout')


@section('content')


<div class="header">
    <h3 class="font-weight-bold">
        {{$title}}
    </h3>
    <div class="bottom-line"></div>
</div>

 @if($preview)
    <div class="profile">
        <div>
            <a href="">
                    <img src="{{asset('img/default.png')}}" alt="">
                <span>No Account Connected
                    <br>
                    <small>0 posts so far!</small>
                </span>

            </a>
        </div>


    </div>

    @else

    <div class="profile">
        <div>
            <a href="/instagram/{{$connection->id}}">
                @if($connection->avatar == ''):
                    <img src="{{asset('img/default.png')}}" alt="">
                @else
                    <img src="{{$connection->avatar}}" alt="">
                @endif
                <span>{{$connection->name}}
                    <br>
                    <small>{{count($posts)}} posts so far!</small>
                </span>

            </a>
            <a href="#" class="remove-user" data-id={{ $connection->id }}>
                <i class="far fa-trash-alt"></i>
            </a>
        </div>

        @foreach($connections as $con)

            <div>
                <a href="/instagram/{{$con->id}}">
                    @if($con->avatar == ''):
                        <img src="{{asset('img/default.png')}}" alt="">
                    @else
                        <img src="{{$con->avatar}}" alt="">
                    @endif
                    <span>{{$con->name}}
                        <br>
                        <small>{{count($con->posts)}} posts so far!</small>
                    </span>

                </a>
                <a href="#" class="remove-user" data-id={{ $con->id }}>
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>

        @endforeach

        <div>
            <a class="connect-btn" href="/instagram/login/{{$user->id}}" target="_blank">
                <i class="fab fa-instagram"></i> Connect with Instagram
            </a>
        </div>

    </div>
@include('messages')




{{-- Hereeee --}}


<div class="social-media-post">
    <div>
        <span class="title">
            <i class="fas fa-edit"></i> New Post
        </span>


        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="instagram-media-tab" data-toggle="tab" href="#instagram-media" role="tab" aria-controls="instagram-media" aria-selected="true">
                    <i class="fas fa-photo-video"></i> Media
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="instagram-story-tab" data-toggle="tab" href="#instagram-story" role="tab" aria-controls="instagram-story" aria-selected="false">
                    <i class="far fa-image"></i> Story
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="instagram-igtv-tab" data-toggle="tab" href="#instagram-igtv" role="tab" aria-controls="instagram-igtv" aria-selected="false">
                    <i class="fas fa-tv"></i> IGTV
              </a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="instagram-media" role="tabpanel" aria-labelledby="instagram-media-tab">
                <form action="{{ action('InstagramController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <input type="hidden" name="connection_id" value="{{ $connection->id }}"/>
                    <input type="hidden" name="type" value="media">
                    <input type="hidden" name="timezone" class="timezone" value="">


                    <div class="upload-manager {{ $errors->has('media_image') ? ' has-image-error' : '' }}">
                        <div class="uploaded-image-preview">
                            <div class="image-container">
                                <img src="" alt="" id="preview-media-image">
                                <button class="btn" id="remove-media-btn" type="button">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="" class="btn" id="upload-media-image-btn" >
                               <i class="fas fa-upload"></i> Upload
                            </a>

                            <div class="media-url">
                                <a href="" class="btn" id="media-url-btn">
                                    <i class="fas fa-link"></i>
                                </a>
                                <div>
                                    <div class="d-flex">
                                        <input type="text" placeholder="Enter Media URL" id="media-url-input" name="media-url">
                                        <button class="btn" id="get-media-url" type="button">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <input type="file" name="media_image" id="upload-media-image">

                        </div>
                    </div>
                    {!! $errors->first('media_image', '<small class="help-block">The image field is required</small>') !!}
                    <div class="captions-manager {{ $errors->has('media_captions') ? 'textarea-error' : ''}}">
                        <div>
                            <textarea placeholder="Enter Your Caption" class="caption-textarea caption1" name="media_captions"></textarea>
                        </div>
                        <div class="d-flex">
                            <div class="count-word caption1-word">
                                <i class="fas fa-text-width"></i>
                                <span>0</span>
                            </div>




                        </div>
                    </div>
                    {!! $errors->first('media_captions', '<small class="help-block">The captions field is required</small>') !!}

                    <div class="schedular">
                        <label class="checkbox-container">Schedule
                            <input type="checkbox" id="schedule-checkbox" class="schedule-box" name="is_schedule">
                            <span class="checkmark"></span>
                        </label>

                        <div class="schedule-container">
                            <div>
                                <div>
                                    <span>Time post</span>
                                    <input type="text" class="picker" name="scheduled_date">
                                </div>
                                <!-- <div>
                                    <span>Interval per post (minute)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost frequency (day)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost until</span>
                                    <input type="text" class="picker">
                                </div> -->
                            </div>

                        </div>
                    </div>
                    <button class="btn btn-primary submit-btn" type="submit" >
                        Schedule
                    </button>
                </form>
            </div>

            <div class="tab-pane fade" id="instagram-story" role="tabpanel" aria-labelledby="instagram-story-tab">
                <form action="{{ action('InstagramController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="connection_id" value="{{ $connection->id }}"/>
                    <input type="hidden" name="type" value="story">
                    <input type="hidden" name="timezone" class="timezone" value="">



                    <div class="upload-manager {{ $errors->has('story_image') ? ' has-image-error' : '' }}">
                        <div class="uploaded-image-preview">
                            <div class="image-container">
                                <img src="" alt="" id="preview-story-image">
                                <button class="btn" id="remove-story-btn" type="button">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="" class="btn" id="upload-story-image-btn" >
                               <i class="fas fa-upload"></i> Upload
                            </a>

                            <div class="media-url">
                                <a href="" class="btn" id="story-url-btn">
                                    <i class="fas fa-link"></i>
                                </a>
                                <div>
                                    <div class="d-flex">
                                        <input type="text" placeholder="Enter Media URL" id="story-url-input" name="media-url">
                                        <button class="btn" id="get-story-url" type="button">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>



                            <input type="file" name="story_image" id="upload-story-image">

                        </div>
                    </div>
                    {!! $errors->first('story_image', '<small class="help-block">The story image field is required</small>') !!}


                    <div class="schedular">
                        <label class="checkbox-container">Schedule
                            <input type="checkbox" id="schedule-checkbox" class="schedule-box" name="is_schedule">
                            <span class="checkmark"></span>
                        </label>

                        <div class="schedule-container">
                            <div>
                                <div>
                                    <span>Time post</span>
                                    <input type="text" class="picker" name="scheduled_date">
                                </div>
                                <!-- <div>
                                    <span>Interval per post (minute)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost frequency (day)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost until</span>
                                    <input type="text" class="picker">
                                </div> -->
                            </div>

                        </div>
                    </div>
                    <button class="btn btn-primary submit-btn" type="submit" >
                        Schedule
                    </button>
                </form>
            </div>

            <div class="tab-pane fade" id="instagram-igtv" role="tabpanel" aria-labelledby="instagram-igtv-tab">
                <form action="{{ action('InstagramController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="connection_id" value="{{ $connection->id }}"/>
                    <input type="hidden" name="type" value="video">
                    <input type="hidden" name="timezone" class="timezone" value="">


                    <div class="title-container {{ $errors->has('title') ? 'has-error' : ''}}">
                        <input type="text" placeholder="Enter Your Title" name="title">
                        {!! $errors->first('title', '<small class="help-block">The title field is required</small>') !!}
                    </div>



                    <div class="upload-manager {{ $errors->has('video') ? ' has-image-error' : '' }}">
                        <div class="uploaded-video-preview">
                            <div class="video-container">
                                <video src="" id="preview-video"></video>
                                <button class="btn" id="remove-video-btn" type="button">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="" class="btn" id="upload-video-btn" >
                               <i class="fas fa-upload"></i> Upload
                            </a>

                            <div class="media-url">
                                <a href="" class="btn" id="video-url-btn">
                                    <i class="fas fa-link"></i>
                                </a>
                                <div>
                                    <div class="d-flex">
                                        <input type="text" placeholder="Enter Video URL" id="video-url-input" name="video-url">
                                        <button class="btn" id="get-video-url" type="button">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>



                            <input type="file" name="video" id="upload-video">

                        </div>
                    </div>
                    {!! $errors->first('video', '<small class="help-block">The video field is required</small>') !!}
                    <div class="captions-manager {{ $errors->has('video_captions') ? 'textarea-error' : ''}}">
                        <div>
                            <textarea placeholder="Enter Your Caption" class="caption-textarea caption2" name="video_captions"></textarea>
                        </div>
                        <div class="d-flex">
                            <div class="count-word caption2-word">
                                <i class="fas fa-text-width"></i>
                                <span>0</span>
                            </div>




                        </div>
                    </div>
                    {!! $errors->first('video_captions', '<small class="help-block">The captions field is required</small>') !!}

                    <div class="schedular">
                        <label class="checkbox-container">Schedule
                            <input type="checkbox" id="schedule-checkbox" class="schedule-box" name="is_schedule">
                            <span class="checkmark"></span>
                        </label>

                        <div class="schedule-container">
                            <div>
                                <div>
                                    <span>Time post</span>
                                    <input type="text" class="picker" name="scheduled_date">
                                </div>
                                <!-- <div>
                                    <span>Interval per post (minute)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost frequency (day)</span>
                                    <input type="number" value="0">
                                </div>
                                <div>
                                    <span>Repost until</span>
                                    <input type="text" class="picker">
                                </div> -->
                            </div>

                        </div>
                    </div>
                    <button class="btn btn-primary submit-btn" type="submit" >
                        Schedule
                    </button>
                </form>
            </div>

          </div>


    </div>
    <div class="preview-tab">
        <div class="">
            <span class="title text-center">
                <i class="fab fa-instagram"></i>
            </span>
        </div>
        <div id="media-preview">
            <div>
                <div class="user-details-container">


                    @if($connection->avatar == ''):
                        <img src="{{ asset('img/default.png')}}" alt="" class="user-icon avatar">
                    @else
                        <img src="{{$connection->avatar}}" alt="" class="user-icon avatar">
                    @endif
                    <div>
                        <span class="username">{{$connection->name}}</span>
                        <span class="time">Just Now <i class="fas fa-globe"></i></span>
                    </div>
                </div>
                <br>
                <div id="instagram-media-preview">
                    <div class="caption-text caption1-text">
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                    </div>
                    <div class="image-preview">
                        <img src="" alt="">
                    </div>

                    <div class="options align-items-center my-2">
                        <i class="far fa-heart"></i>
                        <span> &nbsp;Be the first to like this</span>
                    </div>
                    <input type="text" placeholder="Add a comment">
                </div>


                <div id="instagram-story-preview">
                    <div class="story-image-preview">
                        <img src="" alt="">
                    </div>
                </div>

                <div id="instagram-igtv-preview">
                    <div class="caption2-text">
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                    </div>
                    <div class="video-preview">
                        <video src="" autoplay controls muted></video>
                    </div>

                    <div class="options align-items-center my-2">
                        <i class="far fa-heart"></i>
                        <span> &nbsp;Be the first to like this</span>
                    </div>
                    <input type="text" placeholder="Add a comment">
                </div>
            </div>
        </div>
    </div>
</div>



<div class="table-container">

    <h3 class="font-weight-bold">Scheduled & History</h3>
    <div class="bottom-line"></div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Text</th>
                <th scope="col">Date</th>
                <th scope="col">Likes</th>
                <th scope="col">Comments</th>
                <th>Posted</th>
                <th>Preview</th>
            </tr>
        </thead>
        <tbody>
            @if($posts)
                 @foreach ($posts as $post)
                 <tr>
                    <td>
                        @if($post->image_path)
                          @if(filter_var($post->image_path, FILTER_VALIDATE_URL))
                          <img src="{{ $post->image_path }}" alt="">
                          @else
                              <img src="storage/images/{{ $post->image_path }}" alt="">
                          @endif
                       @else
                       <img src="https://via.placeholder.com/50x50" alt="">
                        @endif
                      </td>
                     <td>
                         {{ $post->caption  }}
                     </td>
                     <td>
                         {{ date("Y-m-d", strtotime($post->scheduled_date))  }}
                     </td>
                     <td>
                         {{ $post->likes }}
                     </td>
                     <td>
                         {{ $post->comments }}
                     </td>
                     <td>
                        @if($post->isPosted)
                            <i class="fas fa-check"></i>
                        @else
                            <i class="fas fa-times"></i>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-primary preview-instagram" id="{{ $post->id }}">
                            View
                        </button>
                    </td>
                 </tr>
    
    
                 @endforeach
            @endif
         </tbody>
    </table>
    </div>
    
    <div class="modal show" id="previewInstagramPost" tabindex="-1" role="dialog" aria-labelledby="previewPostLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="previewPostLabel">
                  Your Post
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="post-preview">
                    <div>
                        <div class="user-details-container">
    
                            @if($connection->avatar == ''):
                                <img src="{{ asset('img/default.png')}}" alt="" class="user-icon avatar">
                            @else
                                <img src="{{$connection->avatar}}" alt="" class="user-icon avatar">
                            @endif
                            <div>
                                <span class="username">{{$connection->name}}</span>
                                <span class="time">Just Now <i class="fas fa-globe"></i></span>
                            </div>
                        </div>
                        <br>
                        <div id="preview-content"></div>
                       {{-- <div class="Twitter-media-preview" >
                            <div class="options">
                                <div class="like">
                                    <i class="far fa-thumbs-up"></i>  Like
                                </div>
                                <div class="comment">
                                    <i class="far fa-comments"></i> Comment
                                </div>
                                <div class="share">
                                    <i class="fas fa-share"></i> Share
                                </div>
                            </div>
                       </div> --}}
    
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    
    @endif
    
    @endsection