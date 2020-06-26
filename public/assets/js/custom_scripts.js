   /*-----------------------------------------------------------------------------------*/
    /*	CUSTOM COMMENTS
    /*-----------------------------------------------------------------------------------*/
var sending = false;
//COMMENTS

    //close comment form
    function closeComments(){
        $('.imageform').addClass('d-none')
     }
    
     //Hide/Show comment section + disable slider control
     function openComments(id,isAlbum){

        $('.lg-close').addClass('d-none');
        $('.lg-prev').addClass('d-none');
        $('.lg-next').addClass('d-none');

         var route = "/portfolio/";
 
         if(isAlbum){
             route += "album/"+id+"/comments";
         } else {
             route += "image/"+id+"/comments";
         }
 
         $.get(route,function(response){
             if(response.success){
                 $("#comments-list").html(response.view);
                 $("#comments").fadeIn();
             }
         })
     }
 
     //form validation functions
     function checkEmail(input){
         var validEmail    = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
         return input.value.match(validEmail);
     }
 
     function checkInputFill(input){
      return input.value.length;
     }
 
     function checkLength(input){
        minLength = 1;
        maxLength = 255;
        if(input.value.length >= minLength && input.value.length <= maxLength){
            return true;
        }else{
            return false;
        }
     }
 
     //Comment input length
    function remainingCharacters(type){
     var commentInput  = document.getElementById( type + '_comment_content');
     var commentLength = commentInput.value.length;
    
     $('.textareaControl').html( '255'- commentLength + ' characters');
     if($('.textareaControl').html() == '0 characters' ){
         $('#'+type+'commentTextarea').removeClass('text-muted');
         $('#'+type+'commentTextarea').addClass('text-danger');
         $('#'+type+'_comment_content').css('border','1px solid red');
     }else{
         $('#'+type+'_comment_content').css('border','1px solid grey');
         $('#'+type+'commentTextarea').removeClass('text-danger');
         $('#'+type+'commentTextarea').addClass('text-muted');
     }
    }
   
     //send ajax comments
     $(document).on('click','.post',function(){

        if(sending)
            return false;
        
        sending = true;

         var type                   = $(this).data("type");
         var isAlbum                = type == "album";
         var form                   = $('#'+type+'CommentForm');
         var albumComments          = document.getElementById('album-comments');
         var imageComments          = document.getElementById('imageCommentsList');
         var emailInput             = document.getElementById(type + '_comment_email');
         var authorInput            = document.getElementById(type + '_comment_author');
         var commentInput           = document.getElementById(type + '_comment_content');
         var albumCommentsLength    = $('#album-comments-length').html();
         albumCommentsLength        = Number(albumCommentsLength);
         var imageCommentsLength    = $('.lg #image-comments-length').html();
         imageCommentsLength        = Number(imageCommentsLength);
       
         if(checkEmail(emailInput)){
             $('.emailError').html('');
             if(checkInputFill(authorInput)){
                 $('.nameError').html('');
                 if(checkLength(commentInput)){
                     $.post('/portfolio/comment', form.serialize(), function (response){
                        sending = false;

                         if(response.success){

                            $.post('/contact/post', form.serialize()).done(function(){sending=false;})

                             if(isAlbum){
                                 //display in view
                                $("#album-comments").prepend($(response.comment));
                                $('#album_comment_email').val('');
                                $('#album_comment_author').val('');
                                $('#album_comment_content').val('');
                                $('.nameError').html('');
                                $('.emailError').html('');
                                albumComments.scrollIntoView({
                                     block: 'start',
                                     behavior: 'smooth',
                                     inline: 'start'
                                });
                                albumCommentsLength += 1;
                                $('#album-comments-length').html(albumCommentsLength);
                                
                             } else {
                                 //Sends mail notification
                                //display in view
                                 $("#imageCommentsList").prepend($(response.comment));
                                 $('#image_comment_email').val('');
                                 $('#image_comment_author').val('');
                                 $('#image_comment_content').val('');
                                 $('.nameError').html('');
                                 $('.emailError').html('');
                                 imageComments.scrollIntoView({
                                     block: 'start',
                                     behavior: 'smooth',
                                     inline: 'start'
                                 });
                                 imageCommentsLength += 1;
                                 $('.lg #image-comments-length').html(imageCommentsLength);
                             }
                             $('.error').html('');
                         }else{
                             alert('Problemos sur les commentaires !!');
                         }
                     });
                 }else{
                     commentInput.focus({preventScroll:false})
                     $('.commentError').html('your comment must be at least 1 character and maximum 255 characters');
                     sending = false;
                 }
             }else{
                 authorInput.focus({preventScroll:false})
                 $('.nameError').html('enter your name');
                 sending = false;
             }
         }else{
             emailInput.focus({preventScroll:false})
             $('.emailError').html('enter a valid email');
             sending = false;
         }
     });
 
     //enable slider control on comments close
     $(document).on('click','#comments .close',function(){
         $('.lg-close').removeClass('d-none');
         $('.lg-prev').removeClass('d-none');
         $('.lg-next').removeClass('d-none');
         $("#comments").fadeOut();
         $("#comments-list").html("");
     })
 
 
     /*-----------------------------------------------------------------------------------*/
     /*	CUSTOM MAILS
     /*-----------------------------------------------------------------------------------*/
 
      //send ajax contact mail
      $(document).on('click','.send_message',function(){
        
         var form          = $('#contactForm');
         var emailInput    = document.getElementById('contact_Email');
         var subjectInput  = document.getElementById('contact_Subject');
         var messageInput  = document.getElementById('contact_Message');
       
         if(checkEmail(emailInput)){
             $('.emailError').html('');
             if(checkInputFill(subjectInput)){
                 $('.subjectError').html('');
                 if(checkLength(messageInput)){
                     $.post('/contact/post', form.serialize(), function (response){
                         if(response.success){
                             document.getElementById('contactForm').reset();
                             $('.successMessage').html('Message sent successfully');
                             $('.messageError').html('');
                             $('.subjectError').html('');
                             $('.emailError').html('');
                         }else{
                             alert('An error occured, please try again later');
                         }
                     });
                 }else{
                     messageInput.focus({preventScroll:true})
                     $('.messageError').html('your message must be at least 1 character and maximum 255 characters');
                 }
             }else{
                 subjectInput.focus({preventScroll:true})
                 $('.subjectError').html('enter your subject');
             }
         }else{
             emailInput.focus({preventScroll:true})
             $('.emailError').html('enter a valid email');
         }
     });

     /*-----------------------------------------------------------------------------------*/
     /*	CUSTOM ADMIN VIEW
     /*-----------------------------------------------------------------------------------*/

        //IMAGES
         //Sort images by album
         function sortImages(albumId){
            $.post('/admin/image/' + albumId + '/sort', function (response){
                if(response.success){
                    $('#refresh_image_list').html(response.view);
                }else{
                    alert('A problem occured');
                }
            })
         }

         //Display all images
         function allImages(){
            $.post('/admin/image/sort-all', function (response){
                if(response.success){
                    $('#refresh_image_list').html(response.view);
                }else{
                    alert('problemos');
                }
            })
         }

          //Delete image 
          function deleteImage(imageId){
                
            if(confirm('Delete image with id ' + imageId + ' ?')){
                $.post('/admin/image/' + imageId + '/erase', function (response){
                    if(response.success){
                        $('#refresh_image_list').html(response.view);
                    }else{
                        alert('A problem occured');
                    }
                })
            }
        }

        //ALBUMS
         //Delete album 
         function deleteAlbum(albumId){
                
            if(confirm('Delete album with id ' + albumId + ' ?')){
                $.post('/admin/album/' + albumId + '/erase', function (response){
                    if(response.success){
                        $('#refresh_album_list').html(response.view);
                    }else{
                        alert('A problem occured');
                    }
                })
            }
        }

         //COMMENTS
            //Delete comments
            function deleteComment(commentId){
                
                if(confirm('Delete comment with id ' + commentId + ' ?')){
                    $.post('/admin/' + commentId + '/erase', function (response){
                        if(response.success){
                            $('#refresh_comments').html(response.view);
                        }else{
                            alert('A problem occured');
                        }
                    })
                }
            }

             //Delete album comments
             function deleteAlbumComment(commentId){
                
                if(confirm('Delete comment with id ' + commentId + ' ?')){
                    $.post('/admin/' + commentId + '/album-erase', function (response){
                        if(response.success){
                            $('#refresh_album_comments').html(response.view);
                        }else{
                            alert('A problem occured');
                        }
                    })
                }
            }

             //Delete image comments
             function deleteImageComment(commentId){
                
                if(confirm('Delete comment with id ' + commentId + ' ?')){
                    $.post('/admin/' + commentId + '/image-erase', function (response){
                        if(response.success){
                            $('#refresh_image_comments').html(response.view);
                        }else{
                            alert('A problem occured');
                        }
                    })
                }
            }


    