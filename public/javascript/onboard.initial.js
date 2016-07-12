$(document).ready(function(){initial.start();});

initial = {
    /*Changes text in the feedback button after ajax call is finished and the user has
     * submitted the form*/
    changeFeedbackbutton : function(result,message){
        var me               = initial;
        var text             = "Success";
        var element          = $('#success');
        var showErrorMessage = false;
        if(!result){
            text = "Failed";
            element = $("#fail");
            showErrorMessage = true;
        } 
        $(element).show('fast',function(){
             $('#feedbackbutton').text(text);
             if(showErrorMessage){
                 $('#error-message-container p').text(message).css({color:'red','font-size':'1.3em'});
                 $('#error-message-container').show('fast');
             }
         });
         
    },
    /*This function gives feedback button its original state*/
    revertFeedbackbutton : function(result){
         var element = $('#success');
         if(!result){
             element = $('#fail');
         }
        $(element).hide('slow',function(){
            $('#feedbackbutton').text("Send");
            $('#error-message-container').hide('fast').children('p').text('');
         });
    },
    
    sendFeedBackMeesage : function(event){
        var me = initial;
        event.preventDefault();
        var serialisedForm = $(event.target).serialize();         
        $.ajax({
            url     : $(event.target).data('url'),
            type    : 'post',
            data    : serialisedForm,
            dataType: 'json'
        }
        ).done(function(data){
            if(data.result){
                $('#feedbackbutton').animate({
                    'background':'-webkit-linear-gradient(right, #4B97E4, #A7EDC3)'
                },500,function(){
                    me.changeFeedbackbutton(data.result,null);  
                });
            }
            if (!data.result ) {
             var messageArray = $.map(data,function(obj){return obj;});
             var errorKey     = $.map(messageArray[1],function(obj,key){return key;})[0];
             $('#feedbackbutton').animate({
                    'background':'red'
                },500,function(){
                    me.changeFeedbackbutton(data.result,data.message[errorKey]);
                });
            }  
        }).always(function(data){
            
            setTimeout(function(){
                me.revertFeedbackbutton(data.result);
                $('.nobinput').val("");
            },5000);
            
        }).fail(function(data){
            
        });
        console.log($(event.target).data('url'));
    },
    
    /*If the device is phone this function changes a few*/
    changeForPhone : function(){
        var currentWidth      = $(window).width();
        var currentWidthHalf  = currentWidth/2;
        var currentHeight     = $(window).height();
        var $theLogo          = $('#nepOnboardImage');
        var toAddMargin       = (currentWidthHalf-$theLogo.width()/2)-10;
        $theLogo.css({'margin-left':toAddMargin});
        var paddingToadd      = (9*currentWidth)/100;
        if(currentWidth > 330){
           $('.menuList').css('padding-left',paddingToadd); 
        }
        
    },
    start: function(){
          var me        = initial;
          var $element  = $('.hamroMenu');
          var $element2 = $('#menu-options-container');
          var isPhone   = ($(window).width()<=750)?true:false;  
          var is1680    = ($(window).width()>=1680);   
          
          if(!isPhone && $(window).height() <705){
              $('#we').removeClass('col-md-push-2 col-md-8').addClass('col-md-push-1 col-md-10').css({'padding-top':0});
              $('#mission-statement-section').css({'margin-top':'-2em'}).siblings('#arrow-wrapper').css({"margin-top":"-1.5em"});
          }
          window.addEventListener('orientationchange',function(e){
            if(screen.orientation.angle === 0){
                me.changeForPhone();
            };
          });
          if(is1680){
              $('#hacha').removeClass('fa-3x').addClass('fa-5x');
          }
          if(isPhone){
              $("#our-slider").removeClass('carousel slider').removeAttr('data-ride');
              $('#hacha').removeClass('fa-3x').addClass('fa-4x');
              $('#messageForm').css('padding-left','0');
              $('#messageOnSubmission').css({"font-size":"1em"});
              $('#emailid').css({width:'100%','font-size':'15px','padding-left':'17%','margin-bottom':'1px'}).attr('placeholder','We will let you know').siblings('#icon').css({'left':'20px'}).siblings('#hail-button').addClass('btn-xs btn-primary').css({top:2,left:"35%",border:'2px groove #ffffff',color:'#ffffff','font-weight':'normal'});
              $('.social span').removeClass('fa-3x').addClass('fa-2x');
              $('.details').removeClass('fa-2x');
              $('#social-media-info-container .fa').removeClass('fa-5x').addClass('fa-2x');
              me.changeForPhone();
           }
           
           $(document).ajaxStart(function(){$('#loading').show('fast');}).ajaxComplete(function(){$('#loading').hide('fast');});
           $(document).on('submit','#feedbackform',function(e){me.sendFeedBackMeesage(e);});
           $(document).on('submit','#messageForm',function(e){
              e.preventDefault();
              var $serialisedForm =  $('#emailid').val() ===" " ?  " " :$(this).serialize(); 
              var url             = ($(this).data().url === 'http://localhost:8000/application')?$(this).data().url+'/initial/add':'application/initial/add';
              $.ajax({
                   
                  url      : url,
                  data     : $serialisedForm,
                  dataType : 'json',
                  type     : 'post'
                }).done(function(data){
                  var proceed   = true;
                  var substring = 'OOPS';
                  if(data.result && data.message.indexOf(substring)>-1){
                      $('#messageOnSubmission').text(data.message).css('color','white');
                      proceed = false;
                  }
                  if (data.result && proceed) {
                    $('#messageOnSubmission').text('We have received your email address. '+data.message).css('color','white'); 
                  } 
                  
                  if(!data.result && proceed){
                   /** Here I am converting data json object to array and retreiving key of the message and using the key to 
                       to extract the message and append on the body. Regardless of the type of message, it will always be shown 
                       on the same spot.
                   **/
                   var messageArray = $.map(data,function(obj){return obj;});
                   var errorKey     = $.map(messageArray[1],function(obj,key){return key;})[0];
                    $('#messageOnSubmission').text(data.message[errorKey]).css('color','#f70025 !important');  
                  }
              }).fail(function(data){
                   $('#messageOnSubmission').text(data.message).css('color','white');
              }).always(function(){  
                $('#emailid').val('');
                setTimeout(function(){
                    $('#messageOnSubmission').fadeOut('slow',function(){
                        $(this).text('').css({'font-size':'1em !important'});
                        $(this).css({visibility:'visible',display:'block'});
                    });
                    
                },5000);
              });
              
          });
          $(document).on('click','#b-m',function(event){
           $element.removeClass('close',{
                   duration :1,
                   complete:function(){
                       $element2.css({
                         height:0
                       });
                   }
           });
           $element.addClass('open');  
        });  
      $(document).on('click','#close-hamro-menu',function(event){ 
            
             $element.removeClass('open');
             $element.addClass('close');    
        });
        
        $(document).on('mouseover','.menu',function(){
           $(this).css({
               cursor:'pointer',
               opacity:0.7,
               border:'none'
           }); 
        });
        $(document).on('mouseout','.menu',function(){
            if(isPhone){
               $(this).css({
               opacity:1,
               border:'2px solid black'
            }); 
                return;
            }
            $(this).css({
               opacity:1,
               border:'4px solid black'
            }); 
            
            
        });
        $(document).on('click','.us',function(){
            window.location.assign('#aboutPage');
        });
        $(document).on('click','.house',function(){
            
            var href = $('.house').data('direction');
            window.location.assign(href);
        });
        
        $(document).on('click','.article', function(){
           window.location.assign($(this).data('direction')); 
        });
        $(document).on('click','#home-logo',function(){
            $(this).hide ('slow',function(){window.location.assign('#homePage');});
            
        });
        $(document).on('click','.contact',function(){
            window.location.assign('#contactPage');
        });
         $(document).on('click','.upArrow',function(){
            $.fn.fullpage.silentMoveTo('2');
        });
       
        $('#fullpage').fullpage({
            anchors:['homePage','menuPage','aboutPage','contactPage'],
            lockAnchors: false,
            navigation: false,
            navigationPosition: 'right',
            navigationTooltips: ['firstSlide', 'secondSlide','thirdSlide'],
            showActiveTooltip: false,
            slidesNavigation: true,
            slidesNavPosition: 'bottom',
            css3: true,
            scrollingSpeed: 100,
            autoScrolling: true,
            fitToSection: true,
            fitToSectionDelay: 50,
            scrollBar: false,
            easing: 'easeInOutCubic',
            easingcss3: 'ease',
            loopBottom: false,
            loopTop: false,
            loopHorizontal: true,
            continuousVertical: false,
            normalScrollElements: '#element1, .element2',
            scrollOverflow: true,
            touchSensitivity: 20,
            normalScrollElementTouchThreshold: 5,

            //Accessibility
            keyboardScrolling: true,
            animateAnchor: true,
            recordHistory: true,

            //Design
            controlArrows: true,
            verticalCentered: true,
            resize : false,
            paddingBottom: '0px',
            fixedElements: '#header, .footer',
            responsiveWidth: 0,
            responsiveHeight: 0,

            //Custom selectors
            sectionSelector: '.section',
            slideSelector: '.slide',

            afterLoad: function(anchorLink, index){
               
//                if(index === 1 && anchorLink === 'homePage'){
//                    setTimeout(function(){
//                        $.fn.fullpage.moveTo(2);
//                    },15000);   
//                } 
//                
                if(index === 1  || index === 2){
                    $('#home-logo').fadeOut();
       
                } else{
                    $('#home-logo').fadeIn('700');
                }
               
            } 
        });
        
     
          
    }
    
}