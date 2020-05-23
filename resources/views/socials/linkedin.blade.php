


@extends('layout')


@section('content')

<div class="header">
    <h3 class="font-weight-bold">
       {{ $title }}
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

        <div>
            <a class="connect-btn" href="/linkedin/login/{{$user->id}}" target="_blank">
                <i class="fab fa-linkedin"></i> Connect with LinkedIn
            </a>
        </div>
    </div>

@else

 <div class="profile">
    <div>
         <a href="/linkedin/{{$connection->id}}">
             @if($connection->avatar == '')
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
             <a href="/linkedin/{{$con->id}}">
                 @if($con->avatar == '')
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
        <a class="connect-btn" href="/linkedin/login/{{$user->id}}" target="_blank">
            <i class="fab fa-linkedin"></i> Connect with LinkedIn
        </a>
    </div>
 </div>

@include('messages')

<div class="social-media-post">
    <div>
        <span class="title">
            <i class="fas fa-edit"></i> New Post
        </span>


        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="linkedin-media-tab" data-toggle="tab" href="#linkedin-media" role="tab" aria-controls="linkedin-media" aria-selected="true">
                <i class="fas fa-photo-video"></i> Media
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="linkedin-link-tab" data-toggle="tab" href="#linkedin-link" role="tab" aria-controls="linkedin-link" aria-selected="false">
                <i class="fas fa-link"></i> Link
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="linkedin-text-tab" data-toggle="tab" href="#linkedin-text" role="tab" aria-controls="linkedin-text" aria-selected="false">
                <i class="far fa-file-alt"></i> Text
              </a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="linkedin-media" role="tabpanel" aria-labelledby="linkedin-media-tab">
                <form action="{{ action('LinkedInController@store') }}" method="POST" enctype="multipart/form-data">
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

                    <button class="btn btn-primary submit-btn" type="submit">
                        Schedule
                    </button>
                </form>
            </div>
            <div class="tab-pane fade" id="linkedin-link" role="tabpanel" aria-labelledby="linkedin-link-tab">
                <form action="{{ action('LinkedInController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="connection_id" value="{{ $connection->id }}"/>
                    <input type="hidden" name="type" value="link">
                    <input type="hidden" name="timezone" class="timezone" value="">

                    {{-- Link form --}}
                    <div class="link-container">
                        <input type="text" placeholder="Enter Your Link" id="link-input" name="link"
                        class="{{ $errors->has('link') ? ' has-error' : '' }}">
                        {!! $errors->first('link', '<small class="help-block">The link field is required</small>') !!}
                        <img src="{{ asset('img/loading.gif')}}" alt="">
                    </div>

                    <div class="upload-manager {{ $errors->has('link_image') ? ' has-image-error' : '' }}">
                        <div class="uploaded-image-preview">
                            <div class="image-container">
                                <img src="" alt="" id="preview-link-image">
                                <button class="btn" id="remove-link-btn" type="button">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="" class="btn" id="upload-link-image-btn" >
                               <i class="fas fa-upload"></i> Upload
                            </a>

                            <div class="media-url">
                                <a href="" class="btn" id="link-media-url-btn">
                                    <i class="fas fa-link"></i>
                                </a>
                                <div>
                                    <div class="d-flex">
                                        <input type="text" placeholder="Enter Media URL" id="link-media-url-input" name="media-url">
                                        <button class="btn" id="get-link-media-url" type="button">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>



                            <input type="file" name="link_image" id="upload-link-image">

                        </div>
                    </div>
                    {!! $errors->first('link_image', '<small class="help-block">The image field is required</small>') !!}
                    <div class="captions-manager {{ $errors->has('link_captions') ? 'textarea-error' : ''}}">
                        <div>
                            <textarea placeholder="Enter Your Caption" class="caption-textarea caption2" name="link_captions"></textarea>
                        </div>
                        <div class="d-flex">
                            <div class="count-word caption2-word">
                                <i class="fas fa-text-width"></i>
                                <span>0</span>
                            </div>




                        </div>
                    </div>
                    {!! $errors->first('link_captions', '<small class="help-block">The captions field is required</small>') !!}

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


                    <button class="btn btn-primary submit-btn" type="submit">
                        Schedule
                    </button>
                </form>
            </div>
            <div class="tab-pane fade" id="linkedin-text" role="tabpanel" aria-labelledby="linkedin-text-tab">
                <form action="{{ action('LinkedInController@store') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="connection_id" value="{{ $connection->id }}"/>
                    <input type="hidden" name="type" value="text">
                    <input type="hidden" name="timezone" class="timezone" value="">

                    {{-- text form --}}

                    <div class="captions-manager {{ $errors->has('text_captions') ? 'textarea-error' : ''}}">
                        <div>
                            <textarea placeholder="Enter Your Caption" class="caption-textarea caption3" name="text_captions"></textarea>
                        </div>
                        <div class="d-flex">
                            <div class="count-word caption3-word">
                                <i class="fas fa-text-width"></i>
                                <span>0</span>
                            </div>




                        </div>
                    </div>
                    {!! $errors->first('text_captions', '<small class="help-block">The captions field is required</small>') !!}

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



                    <button class="btn btn-primary submit-btn" type="submit">
                        Schedule
                    </button>
                </form>
            </div>
          </div>


    </div>
    <div class="preview-tab">
        <div class="">
            <span class="title text-center">
                <i class="fab fa-linkedin"></i>
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
               <div class="linkedin-media-preview">
                   <div class="caption-text caption1-text">
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                   </div>

                    <div class="image-preview">
                        <img src="" alt="">
                    </div>
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
               </div>
               <div class="linkedin-link-preview">
               <div class="link-text">
                    <div class="line-no-text"></div>
                    <div class="line-no-text"></div>
                    <div class="line-no-text"></div>
                </div>


                <div class="caption-text caption2-text">
                    <div class="line-no-text"></div>
                    <div class="line-no-text"></div>
                    <div class="line-no-text"></div>
                </div>

                <div class="link-image-preview">
                    <img src="" alt="">
                </div>



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

               </div>

               <div class="linkedin-text-preview">
                   <div class="caption-text caption3-text">
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                        <div class="line-no-text"></div>
                   </div>
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
                    <th scope="col">Shares</th>
                    <th>Posted</th>
                    <th>Preview</th>
                </tr>
            </thead>
            <tbody>
               @if($posts)
                    @foreach ($posts as $post)
                    <tr class="ln-48">
                        <td>
                          @if($post->image_path)
                            @if(filter_var($post->image_path, FILTER_VALIDATE_URL))
                            <img src="{{ $post->image_path }}" alt="">
                            @else
                                <img src="/storage/images/{{ $post->image_path }}" alt="">
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
                            {{ $post->shares }}
                        </td>
                        <td>
                            @if($post->isPosted)
                                <i class="fas fa-check"></i>
                            @else
                                <i class="fas fa-times"></i>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary preview-linkedin" id="{{ $post->id }}">
                                View
                            </button>
                        </td>
                    </tr>


                    @endforeach
               @endif
            </tbody>
        </table>
</div>

<div class="modal show" id="previewLinkedInPost" tabindex="-1" role="dialog" aria-labelledby="previewPostLabel" aria-hidden="true">
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
                   <div class="linkedin-media-preview" >
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
                   </div>

                </div>
            </div>
        </div>
      </div>
    </div>
</div>

@endif
@endsection

