$(document).ready(function(){initial.start();});
initial = {
    stop: true,
    clicked:'',
    id:'',
    /*This function add dropzone to the form and listens to other events related to dropzone*/
    generateDropZone:function(){
        var theTemplate = $('#the-template').parent().html();// get the original template
        $('#the-template').parent().children('#the-template').remove();//remove the original template as this temp area needs to be vacated for when upload progresses
        var dropzone = new Dropzone($('#fake-form').get(0),{
           url:'/blog/add', //relative url to send the post request to 
           parallelUploads:100,
           autoProcessQueue:false,// dont want dropzone to automatically process request when file upload completes
           autoDiscover:false,//
           maxFiles: 1,//only one file is allowed to be uploaded at once
           uploadMultiple:true,//allow multiple data to be posted
           clickable:'#add-button',// add clicable class to add-button so that users can use add button to add photos
           thumbnailWidth:50,//width of the image that is seen in the upload progress block
           thumbnailHeight:50,//height of the image that will be seen in the upload progress block
           previewTemplate:theTemplate,//template to be used for upload progress block
           previewsContainer:'#preview-container',//this specifies where to append the upload progress block
           
           /*This function is the first entry point when dropzone class is added to an element*/
           init : function(){
               var dZone = this;
               /*Fake form is the form with dropzone container in it.Since I need data from another form
                * to be submitted along with the image I have used two forms, one for normal data and another 
                * for image*/
               $('#fake-form').on('submit',function(e){
                 e.preventDefault();//when the fake form is submitted stop reagular form submission process
                 e.stopPropagation();
                 dZone.processQueue();// add the image call the dropzone function processqueue i.e call the send process manually
               });
               
               /*when any of the buttons with class theBtns is clicked*/
               $(document).on('click','.theBtns',function(e){
                   e.preventDefault();
                   e.stopPropagation();
               });
               /*when cancel button is clicked enabe the add button and remove the accepted image from dropzone*/
               $(document).on('click','#cancel-button',function(e){
                   e.preventDefault();
                   if($('#add-button').attr('disabled')==='disabled'){
                       $('#add-button').removeAttr('disabled');                   
                   }
                   dZone.removeAllFiles();
               });
           }         
        });
        /*When the dropzone is sending the file*/
        dropzone.on("sending", function(file, xhr, formData) {
            var items = $('#postform').serializeArray();//get data from the normal data entry form
            /*for each of the post data get the key and the value pair*/
            $.each(items,function(key,value){
                formData.append(value.name,value.value);//add these data as blogPost['somehting'] as key and the actual data to the uploaded picture post request
            });
             $('#loading').show('fast');//as the ajax process is happening show the loading gif
        });
        /*This function is called when image is accepted by dropzone and is ready to be uploaded*/
        dropzone.on('addedfile',function(){
            console.log('ready');
            $('#add-button').attr('disabled','disabled');
        });
        
        /*When ajax call is completed and json string has been received from the backend, call this function which shows messages*/
        dropzone.on("success", function(file, xhr, formData) {
            $('#loading').hide('fast');// hide the loading gif
            if(!xhr.result){
                $('#the-message').html('<p>'+xhr.message+'</p>').css({color:'red'});//replace html of message box with failiur message
                $('#fail').show();//show the error svg
            }        
            if(xhr.result){
                $('#the-message').html('<p>'+xhr.message+'</p>').css({color:'red'});//replace html of message boz with success message
                $('#success').show();//show the success svg
            }            
        });
        /*When the dropzone action is complete, i.e ajax call has been finished and messages have been received call this function*/
        dropzone.on("complete", function(file) {
           setTimeout(function(){
               $('#the-message').html('');//hide the message
               $('.result').hide();//hide the svg 
               $('#add-button').removeAttr('disabled');//enable the add button
               dropzone.removeAllFiles(true);//remove the image from dropzone
               /*if everything went according to the plan and database has received the data then reset input fields otherwise do not r
                * reset the input fileds.*/
               if($.parseJSON(file.xhr.response).result){
                    $('.nobinput').val(""); //
                }
            },3000);
            
        });
    },
    /*This function below gets respective images of all the posts from image folder*/
    bringPhoto: function(){
            var isPhone   = ($(window).width()<=750)?true:false;//if the device is phone
            /*check the uri path and see if there is any writer on it*/
            if(window.location.pathname.indexOf('writer') > -1){
                 $('.posts').css({width:'100%'});//increase the width of the image to 100%
                if(!isPhone){
                    $('.posts').css({height:'200px',width:'150px'});//if the device is phone let the width of image be 150px
                }
                $('.thePosts').css('margin-top','0');// remove margin topform thePosts class which is the posts container
            }
            /*add respectinve image to html a element inside posts div*/
            $('.posts').each(function(index,element){
            var imgId = $(this).data('post');        
            var imgToGet = "post"+imgId+".jpg" ;
            var imgToGetUrl = "url('/img/posts/"+imgToGet+"')";
            $(this).css({'background-image':imgToGetUrl});
        });
    },
    /*This function is called when user submits author search form .Asynchronously loads theposts div from the response that
     * is received from the backend*/
    AuthorSearch:function(event){
        var me = this;
        var $form = event.target;
        var serialisedForm = $($form).serialize();
        console.log(serialisedForm);
       $('.thePosts').load('/blog/populate?'+serialisedForm+' .thePosts > *',function(){
                me.bringPhoto();              
        });
    },
    
    /*when blog js loads this function is called and has all listeners to required events and calls to other functions*/
    start : function(){
        var me = this;
        $(document).on('click','.cancel',function(e){
            e.preventDefault();
           $('#mymodal').modal('toggle');
        });
        $(document).ajaxStart(function(){$('#loading').show('fast');}).ajaxComplete(function(){$('#loading').hide('fast');});
        me.bringPhoto();
        $(document).on('click','#login-fb',function(){
           me.clicked = true; 
        });
        $('#author-search').autocomplete({
            autoFocus : true,
            delay:0,
            source : $('#new-posts').data('authors'),      
            minLength : 1,
            select:function(event){
                me.AuthorSearch(event);
            }
        });
        /*set cache for ajax call. have to look into it mre*/
        $.ajaxSetup({ cache: true });
        /*this code here is received from facebook developers website. Sets a connection to facebook sdk api*/
        $.getScript('//connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
                appId   : '596409587196547',// This is nepalonboard appid
                version : 'v2.6',
                status  : false,//automaticaly get the login status false
                xfbml   : true,
                cookie  : false
            });
            if(window.location.pathname.indexOf('/blog/writer/')>-1){
                me.generateDropZone();// generate dropzone if it is writers screen
                FB.getLoginStatus(function(){
                    FB.api('/me?fields=id',function(res){                         
                    $('#fbidinput').val(res.id);//get fb id of the user and set value of fbinput field which is hidden as the user id
                });
                });
            }
            $(document).on('click','#share-button',function(){
                FB.ui({ 
                    method: 'share',
                    display: 'popup',
                    mobile_iframe:true,
                    href: 'http://www.nepalonboard.com/blog/show/'+$(this).data('id')
                }),function(response){
                    console.log(response);
                   }; 
             });
             $(document).on('click','.shareYourExperience',function(){
                 FB.getLoginStatus(function(response){
                   if(response.status === 'connected'){
                        var name= '';
                      FB.api('/me/',function(res){
                          name= res.name.replace(/\s+/g,'-');
                         $('#continue-with').attr('href','/blog/writer/'+name);
                      });
                   }
                   if(response.status !== 'connected' ){
                     $('#continue-with').css('display','none');
                     $('#login-fb').css('display','inline');
                   }    
               });
               $('#mymodal').modal('toggle');
             });
        });
        
        $(document).on('submit','#author-search-form',function(e){
            e.preventDefault();
            if(!$(e.target).val()===''){
                me.AuthorSearch(e);
            }
        });
        $(document).on('click','.sort',function(){
           var value = $(this).val();
            $('.thePosts').load('/blog/'+value+' .thePosts > *',function(){
                me.bringPhoto();              
            }); 
        });
        $('#home-logo').on('click',function(){
           window.location.assign('/application');
        }); 

        $(document).on('click','.posts',function(){
            $(window).location.assign('"/show/'+$(this).data('url')+'"');
        });  
    }
};
