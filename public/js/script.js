$(document).ready(function() {
    // var fileInput = this;
    // if(fileInput.files.length){
    //     var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
    //     $("#course-promotion-video").attr("src", fileUrl);
    //
    // }

    var linesDiv = `<div class="line-no-text"></div>
                    <div class="line-no-text"></div>
                    <div class="line-no-text"></div>`;

    $("[data-toggle='tooltip']").tooltip();

    $("#whatsapp-remove-image-btn").click(function(){
        $("#whatsapp-image").val("");
        $("#img-small").show();
        $(".whatsapp-image-preview img").attr("src", "");
        $(".whatsapp-image-preview img").hide()
    })


    $("#whatsapp-remove-video-btn").click(function(){
        $("#whatsapp-video").val("");

        $("#video-small").show();
        $(".whatsapp-video-preview video").attr("src", "");
        $(".whatsapp-video-preview video").hide()
    })


    $("#upload-media-image-btn").click(function(e){
        e.preventDefault();
        $("#upload-media-image").click();
    });

    $("#upload-link-image-btn").click(function(e){
        e.preventDefault();
        $("#upload-link-image").click();
    });

    $("#upload-story-image-btn").click(function(e){
        e.preventDefault();
        $("#upload-story-image").click();
    });

    $("#upload-video-btn").click(function(e){
        e.preventDefault();
        $("#upload-video").click();
    });



    $("#upload-media-image").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#preview-media-image").attr("src", fileUrl);
            $("#preview-media-image").css("display", "inline-block")
            $("#remove-media-btn").css("display", "inline-block")
            $(".image-preview img").attr("src", fileUrl);
        }
    });

    $("#upload-story-image").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#preview-story-image").attr("src", fileUrl);
            $("#preview-story-image").css("display", "inline-block")
            $("#remove-story-btn").css("display", "inline-block")
            $(".story-image-preview img").attr("src", fileUrl);
        }
    });

    $("#upload-link-image").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#preview-link-image").attr("src", fileUrl);
            $("#preview-link-image").css("display", "inline-block")
            $("#remove-link-btn").css("display", "inline-block")
            $(".link-image-preview img").attr("src", fileUrl);
        }
    });

    $("#upload-video").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#preview-video").attr("src", fileUrl);
            $("#preview-video").css("display", "inline-block")
            $("#remove-video-btn").css("display", "inline-block")
            $(".video-preview video").attr("src", fileUrl);
        }
    });

    $("#whatsapp-image").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#img-small").hide();
            $(".whatsapp-image-preview img").attr("src", fileUrl);
            $(".whatsapp-image-preview img").show()
            // $("#remove-whatsapp-image-btn").css("display", "inline-block")
            
        }
    });

    $("#whatsapp-video").change(function(){
        var fileInput = this;
        if(fileInput.files.length){
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            $("#video-small").hide();
            $(".whatsapp-video-preview video").attr("src", fileUrl);
            $(".whatsapp-video-preview video").show()
            
            // $("#remove-whatsapp-image-btn").css("display", "inline-block")
            
        }
    });


    $("#remove-media-btn").click(function(){
        $("#upload-media-image").val("");
        $("#preview-media-image").fadeOut(200)
        $("#remove-media-btn").fadeOut(200)
        $(".image-preview img").attr("src", "");
    });


    $("#remove-link-btn").click(function(){
        $("#upload-link-image").val("");
        $("#preview-link-image").fadeOut(200)
        $("#remove-link-btn").fadeOut(200)
        $(".link-image-preview img").attr("src", "");
    });

    $("#remove-story-btn").click(function(){
        $("#upload-story-image").val("");
        $("#preview-story-image").fadeOut(200)
        $("#remove-story-btn").fadeOut(200)
        $(".story-image-preview img").attr("src", "");
    });



    $("#remove-video-btn").click(function(){
        $("#upload-video").val("");
        $("#preview-video").fadeOut(200)
        $("#remove-video-btn").fadeOut(200)
        $(".video-preview video").attr("src", "");
    });

    $("#media-url-btn").click(function(e){
        e.preventDefault();
        $(".media-url > div").fadeToggle(400);
    });

    $("#link-media-url-btn").click(function(e){
        e.preventDefault();
        $(".media-url > div").fadeToggle(400);
    });

    $("#story-url-btn").click(function(e){
        e.preventDefault();
        $(".media-url > div").fadeToggle(400);
    });



    $("#video-url-btn").click(function(e){
        e.preventDefault();
        $(".media-url > div").fadeToggle(400);
    });


    $("#get-media-url").click(function(e){
        e.preventDefault();
        var fileUrl = $("#media-url-input").val();

        var tempImg = new Image();
        tempImg.src = fileUrl;

        tempImg.onload = function(){
            $("#preview-media-image").attr("src", fileUrl);
            $("#preview-media-image").css("display", "inline-block")
            $("#remove-media-btn").css("display", "inline-block")
            $(".image-preview img").attr("src", fileUrl);
        }

        tempImg.onerror = function(){
            bootbox.alert("Could not load this image");
            $("#media-url-input").val("");
        }


    });

    $("#get-link-media-url").click(function(e){
        e.preventDefault();
        var fileUrl = $("#link-media-url-input").val();


        var tempImg = new Image();
        tempImg.src = fileUrl;

        tempImg.onload = function(){
            $("#preview-link-image").attr("src", fileUrl);
            $("#preview-link-image").css("display", "inline-block")
            $("#remove-link-btn").css("display", "inline-block")
            $(".link-image-preview img").attr("src", fileUrl);
        }

        tempImg.onerror = function(){
            bootbox.alert("Could not load this image");
            $("#media-url-input").val("");
        }



    });


    $("#get-story-url").click(function(e){
        e.preventDefault();
        var fileUrl = $("#story-url-input").val();


        var tempImg = new Image();
        tempImg.src = fileUrl;

        tempImg.onload = function(){
            $("#preview-story-image").attr("src", fileUrl);
            $("#preview-story-image").css("display", "inline-block")
            $("#remove-story-btn").css("display", "inline-block")
            $(".story-image-preview img").attr("src", fileUrl);
        }

        tempImg.onerror = function(){
            bootbox.alert("Could not load this image");
            $("#media-url-input").val("");
        }



    });

    $("#get-video-url").click(function(e){
        e.preventDefault()
        var video = $("#preview-video")[0];
        $("#preview-video").attr("src", fileUrl);
        $("#preview-video").css("display", "inline-block")
        $("#remove-video-btn").css("display", "inline-block")
        $(".video-preview video").attr("src", fileUrl);


       var onError = function() {
           bootbox.alert("Video is not available")
           $("#remove-video-btn").css("display", "none")
           video.removeEventListener('error', onError);
       };
       video.addEventListener('error', onError);
    })



    $(".schedule-box").on('click', function(){
        if(this.checked) {
           $(".schedule-container").fadeIn(300);
        }else {
            $(".schedule-container").fadeOut(300);
        }
    });

    $("#facebook-media-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".facebook-link-preview").hide();
        $(".facebook-text-preview").hide();
        $(".facebook-media-preview").show();
    });

    $("#facebook-link-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".facebook-media-preview").hide();
        $(".facebook-text-preview").hide();
        $(".facebook-link-preview").show();
    });

    $("#facebook-text-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".facebook-media-preview").hide();
        $(".facebook-link-preview").hide();
        $(".facebook-text-preview").show();
    });


    $("#instagram-media-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");

        $("#instagram-media-preview").show();
        $("#instagram-story-preview").hide();
        $("#instagram-igtv-preview").hide();
    });


    $("#instagram-story-tab").click(function(){

        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $("#instagram-media-preview").hide();
        $("#instagram-story-preview").show();
        $("#instagram-igtv-preview").hide();

    });

    $("#instagram-igtv-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $("#instagram-media-preview").hide();
        $("#instagram-story-preview").hide();
        $("#instagram-igtv-preview").show();


    });





    $("#linkedin-media-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".linkedin-link-preview").hide();
        $(".linkedin-text-preview").hide();
        $(".linkedin-media-preview").show();
    });

    $("#linkedin-link-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".linkedin-media-preview").hide();
        $(".linkedin-text-preview").hide();
        $(".linkedin-link-preview").show();
    });

    $("#linkedin-text-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".linkedin-media-preview").hide();
        $(".linkedin-link-preview").hide();
        $(".linkedin-text-preview").show();
    });


    $(".advance-manager-btn").click(function(){
        var icon = $(this).find(".fa-chevron-down").length;
        if(icon){
            var element = $(this).find(".fa-chevron-down");
            element.removeClass("fa-chevron-down").addClass("fa-chevron-up");
        }else {
            var element = $(this).find(".fa-chevron-up");
            element.removeClass("fa-chevron-up").addClass("fa-chevron-down");
        }

        $(".advance-manager").slideToggle();

    });


    $("#twitter-media-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".twitter-media-preview").show();
        $(".twitter-video-preview").hide();
        $(".twitter-link-preview").hide();
        $(".twitter-text-preview").hide();

    });

    $("#twitter-video-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".twitter-media-preview").hide();
        $(".twitter-video-preview").show();
        $(".twitter-link-preview").hide();
        $(".twitter-text-preview").hide();


    });

    $("#twitter-link-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".twitter-media-preview").hide();
        $(".twitter-video-preview").hide();
        $(".twitter-link-preview").show();
        $(".twitter-text-preview").hide();


    });


    $("#twitter-text-tab").click(function(){
        $(".tab").removeClass("sel");
        $(this).addClass("sel");
        $(".twitter-media-preview").hide();
        $(".twitter-video-preview").hide();
        $(".twitter-link-preview").hide();
        $(".twitter-text-preview").show();


    });

    $("#link-input").on('keyup', function (e) {
        if (e.keyCode === 13) {
            var val = $(this).val();
            $(".link-container img").css("display", "block");
            setTimeout(() => {
                $(".link-container img").hide();
                if(!validURL(val)){
                    bootbox.alert("Invalid URL");
                }else {
                    var url = `<a href='${val}'>${val}</a>`;
                    $(".link-text").html(url);
                }
            }, 800);
            e.preventDefault();
        }
    });

    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
          e.preventDefault();
          return false;
        }
      });

    $(".preview").click(function(){
       var id = this.id;
       var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
       $.post("/fetchPost", {_token: CSRF_TOKEN, id:id}, function(data){
           $("#preview-content").html(data);
           $("#previewPost").modal("show");
       })
    })


    $(".preview-linkedin").click(function(){
        var id = this.id;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/fetchLinkedInPost", {_token: CSRF_TOKEN, id:id}, function(data){
            $("#preview-content").html(data);
            $("#previewLinkedInPost").modal("show");
        })
     })

     $(".preview-twitter").click(function(){
        var id = this.id;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/fetchTwitterPost", {_token: CSRF_TOKEN, id:id}, function(data){
            $("#preview-content").html(data);
            $("#previewTwitterPost").modal("show");
        })
     })

     $(".preview-instagram").click(function(){
        var id = this.id;
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post("/fetchInstagramPost", {_token: CSRF_TOKEN, id:id}, function(data){
            $("#preview-content").html(data);
            $("#previewInstagramPost").modal("show");
        })
     })




     $('#sendBtn').click(function(){

        let conID = $('#conversation_id').val();
        let page_id = $('#messagePageID').val();
        $.post(`/facebookMessages/${page_id}/${conID}`,{message: $('#message-area').val()},function(resp){
            if(resp == 'sent'){
                $('.emojionearea-editor').text('')
                $.get(`/facebookMessages/${page_id}/${conID}`,function(resp){
                    $('.loading-div').hide();
                    $('.modal-messages-holder').html(resp).show();
                })
            }
        })
        return false;
     })

     function loadMessages(){
        let page_id = $('#messagePageID').val();
        $.get('/facebookMessages/'+page_id,function(resp){
              $('.page-inbox-loader').hide();
              $('.page-messages-holder').html(resp).show();
              registerMessageClickHandler();
        })
     }

     $('#messagePageID').change(function(){
        $('.page-inbox-loader').show();
        $('.page-messages-holder').hide();
        loadMessages();
     });

     if($('#messagePageID').length > 0){
        loadMessages();

     }

     function registerMessageClickHandler(){
        $(".message").click(function(){
            let conID = $(this).data('conversation-id');
            let page_id = $('#messagePageID').val();
            $("#messageModal").modal("show");
            $('.loading-div').show();
            $('.modal-messages-holder').hide();
            $('#conversation_id').val(conID);
            $.get(`/facebookMessages/${page_id}/${conID}`,function(resp){
                $('.loading-div').hide();
                $('.modal-messages-holder').html(resp).show();
            })
         });
     }



     $("#message-area").emojioneArea();
     $("#advance-textarea").emojioneArea();


    $(".caption1").emojioneArea({
        pickerPosition:"bottom",
        events: {
                keyup: function (editor, event) {
                    var val = $(".caption1").data("emojioneArea").getText();
                    if(val == ""){
                        $(".caption1-text").html(linesDiv);
                    }else {
                        $(".caption1-text").html(val);
                    }

                    $(".count-word.caption1-word span").html(val.length);

                }
            }
        }
    );

    $(".caption2").emojioneArea({
        pickerPosition:"bottom",
        events: {
                keyup: function (editor, event) {
                    var val = $(".caption2").data("emojioneArea").getText();
                    if(val == ""){
                        $(".caption2-text").html(linesDiv);
                    }else {
                        $(".caption2-text").html(val);
                    }

                    $(".count-word.caption2-word span").html(val.length);

                }
            }
        }
    );


    $(".caption3").emojioneArea({
        pickerPosition:"bottom",
        events: {
                keyup: function (editor, event) {
                    var val = $(".caption3").data("emojioneArea").getText();
                    if(val == ""){
                        $(".caption3-text").html(linesDiv);
                    }else {
                        $(".caption3-text").html(val);
                    }

                    $(".count-word.caption3-word span").html(val.length);

                }
            }
        }
    );

    $(".caption4").emojioneArea({
        pickerPosition:"bottom",
        events: {
                keyup: function (editor, event) {
                    var val = $(".caption4").data("emojioneArea").getText();
                    if(val == ""){
                        $(".caption4-text").html(linesDiv);
                    }else {
                        $(".caption4-text").html(val);
                    }

                    $(".count-word.caption4-word span").html(val.length);

                }
            }
        }
    );

    if($(".caption1").length > 0){
        $(".caption1")[0].emojioneArea.on("emojibtn.click", function(btn, event) {
            var val = $(".caption1").data("emojioneArea").getText();
                if(val == ""){
                    $(".caption1-text").html(linesDiv);
                }else {
                    $(".caption1-text").html(val);
                }
    
                $(".count-word.caption1-word span").html(val.length);
          })
    }

      if($(".caption2").length > 0){
        $(".caption2")[0].emojioneArea.on("emojibtn.click", function(btn, event) {
            var val = $(".caption2").data("emojioneArea").getText();
                if(val == ""){
                    $(".caption2-text").html(linesDiv);
                }else {
                    $(".caption2-text").html(val);
                }

                $(".count-word.caption2-word span").html(val.length);
        })
      }

      if($(".caption3").length > 0){
        $(".caption3")[0].emojioneArea.on("emojibtn.click", function(btn, event) {
            var val = $(".caption3").data("emojioneArea").getText();
                if(val == ""){
                    $(".caption3-text").html(linesDiv);
                }else {
                    $(".caption3-text").html(val);
                }

                $(".count-word.caption3-word span").html(val.length);
          })
      }



      if($(".caption4").length > 0){
        $(".caption4")[0].emojioneArea.on("emojibtn.click", function(btn, event) {
            var val = $(".caption3").data("emojioneArea").getText();
                if(val == ""){
                    $(".caption4-text").html(linesDiv);
                }else {
                    $(".caption4-text").html(val);
                }

                $(".count-word.caption4-word span").html(val.length);
          })
      }

      $('.remove-user').click(function(){
        let id = $(this).data('id')
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            position: 'top'
          }).then((result) => {
            if (result.value) {
            //   Swal.fire(
            //     'Deleted!',
            //     'Your file has been deleted.',
            //     'success'
            //   )
            window.location.href = '/delete_connection/'+id;
            }
          })
      })


 
      var deviceTime = document.querySelector('.status-bar .time');
      var messageTime = document.querySelectorAll('.message .time');
      
      if(deviceTime)
          deviceTime.innerHTML = moment().format('h:mm');
      
      if(deviceTime){
          setInterval(function() {
              deviceTime.innerHTML = moment().format('h:mm');
          }, 1000);
      }
      
      for (var i = 0; i < messageTime.length; i++) {
          messageTime[i].innerHTML = moment().format('h:mm A');
      }

    /* Message */

    var form = document.querySelector('.conversation-compose');
    var conversation = document.querySelector('.conversation-container');

    if(form)
        form.addEventListener('submit', newMessage);


        function newMessage(e) {

      
            var input = e.target.input;
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
            var inputText = input.value;
            $("#input-msg").data("emojioneArea").setText("");
            
            var numbers = [];
    
            $(".number-value").each(function(element){
                var num = this.value;
                numbers.push(num)
            });
    
            var formData = new FormData();
            formData.append("_token", CSRF_TOKEN);
            formData.append("message", inputText);
            formData.append("numbers", JSON.stringify(numbers));
    
    
            if($('#whatsapp-image')[0].files.length != 0)
            {
                formData.append("image", $('#whatsapp-image')[0].files[0]) 
            }
    
            if($('#whatsapp-video')[0].files.length != 0)
            {
                formData.append("video", $('#whatsapp-video')[0].files[0]) 
            }
    
            if(inputText == "" && $('#whatsapp-image')[0].files.length == 0 && $('#whatsapp-video')[0].files.length == 0){
                bootbox.alert({
                    "message" : "Please enter your message",
                    "size" : "small"
                })
            }else{
                $.ajax({
                    url: "whatsapp/send",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data)
                    {
                       if(data == ""){
                        bootbox.alert({
                            "message" : "Message sent successfully!",
                            "size" : "small"
                        })
                       }
                    }
        
                });        
        
            }
    
           
          
    
            
            e.preventDefault()
    
            if(inputText != ""){
                var message = buildMessage(inputText);
                conversation.appendChild(message);
                animateMessage(message);
               
            }
    
            if($('#whatsapp-image')[0].files.length != 0)
            {
                var fileInput = $('#whatsapp-image')[0];
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var message = buildMedia(inputText, fileUrl);
                conversation.appendChild(message);
                animateMessage(message);
            }
    
            if($('#whatsapp-video')[0].files.length != 0)
            {
                var fileInput = $('#whatsapp-video')[0];
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var message = buildMedia(inputText, fileUrl, "video");
                conversation.appendChild(message);
                animateMessage(message);
            }
    
            $("#whatsapp-image").val("");
            $("#whatsapp-video").val("");
    
            $("#img-small").show();
            $(".whatsapp-image-preview img").attr("src", "");
            $(".whatsapp-image-preview img").hide()
    
            $("#video-small").show();
            $(".whatsapp-video-preview video").attr("src", "");
            $(".whatsapp-video-preview video").hide()
    
            conversation.scrollTop = conversation.scrollHeight;
        }
        
        function buildMessage(text) {
            var element = document.createElement('div');
        
            element.classList.add('message', 'sent');
        
            element.innerHTML = text +
                '<span class="metadata">' +
                    '<span class="time">' + moment().format('h:mm A') + '</span>' +
                    '<span class="tick tick-animation">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck" x="2047" y="2061"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#92a58c"/></svg>' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg>' +
                    '</span>' +
                '</span>';
        
            return element;
        }
    
        function buildMedia(text, media, type="image") {
    
            var element = document.createElement('div');
    
            let html ="";
    
            if(type == "image"){
               html = `<img src="${media}" alt="" class="message-image">`;
            }else {
                html = `<video src="${media}" class="message-video"></video>`;
            }
        
            element.classList.add('message', 'sent');
        
            element.innerHTML = text + html +
                '<span class="metadata">' +
                    '<span class="time">' + moment().format('h:mm A') + '</span>' +
                    '<span class="tick tick-animation">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck" x="2047" y="2061"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#92a58c"/></svg>' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg>' +
                    '</span>' +
                '</span>';
        
            return element;
        }
        
        function animateMessage(message) {
            console.log(message)
            setTimeout(function() {
                var tick = message.querySelector('.tick');
                tick.classList.remove('tick-animation');
            }, 500);
        }
    
        $("#whatsapp-image-upload").click(function(){
            $("#whatsapp-image").click()
        });
        
        $("#whatsapp-video-upload").click(function(){
            $("#whatsapp-video").click()
        });
    
        $("#input-msg").emojioneArea()
        
    
    
    });
    
    function validURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
          '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
          '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
          '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
          '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
          '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return pattern.test(str);
      }
    
    function showHideList(element){
        element.value == "page" ? showPage(element) : showGroup(element)
    }
    
    function showPage(element){
        $(element).parent().find(".page-div").show()
        $(element).parent().find(".group-div").hide();
    }
    
    function showGroup(element){
        $(element).parent().find(".page-div").hide();
        $(element).parent().find(".group-div").show();
    }
    
    function showContactInfo(element){
        var contactDiv = $(element).parent().parent();
        var id = contactDiv.find(".id-value").val();
        var name = contactDiv.find(".name-value").val();
        var number = contactDiv.find(".number-value").val();
    
        $("#contact-name-val").val(name);
        $("#contact-number-val").val(number);
        $("#contact-id-val").val(id);
        $("#contact-desc").fadeIn();
    }
    
    $("#remove-contact-box").click(function(){
        $("#contact-desc").fadeOut();
    })
    
    
    function updateContactInfo(element){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        if($("#contact-name-val").val().trim() == "" && $("#contact-number-val").val().trim() == "")
        {
            bootbox.alert({
                message : "Cannot Update The Details",
                size : "small"
            })
    
            return;
    
        }
    
        var id =  $("#contact-id-val").val();
        var name = $("#contact-name-val").val();
        var number = $("#contact-number-val").val();
    
        $.post("/contact/update", {_token: CSRF_TOKEN, name:name, number:number, id:id}, function(data){
            if(data == ""){
                bootbox.alert({
                    message : "Details Updated Successfully",
                    size : "small"
                })
                location.reload();
            }else {
                bootbox.alert({
                    message : "Cannot Update The Details",
                    size : "small"
                })
            }
        })
        
    }
    
    function removeContactInfo(element){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        if($("#contact-id-val").val() == "")
        {
            bootbox.alert({
                message : "Cannot remove the contact!",
                size : "small"
            })
    
            return;
    
        }
    
        var id =  $("#contact-id-val").val();
       
    
        $.post("/contact/delete", {_token: CSRF_TOKEN, id:id}, function(data){
            if(data == ""){
                bootbox.alert({
                    message : "Removed Successfully",
                    size : "small"
                })
                location.reload();
            }else {
                bootbox.alert({
                    message : "Cannot remove the contact!",
                    size : "small"
                })
            }
        })
        
    }
    
    