$(document).ready(function(){initial.start();});

initial = {
    start: function(){
          var me = initial;
          var $element  = $('.hamroMenu');
          var $element2 = $('#menu-options-container');
          
          $(document).on('submit','#messageForm',function(e){
              e.preventDefault();
              var $serialisedForm =  $('#emailid').val() ===" " ?  " " :$(this).serialize(); 
              var url             = ($(this).data().url === 'http://localhost:8000/application')?$(this).data().url+'/initial/add':'application/initial/add';
              console.log(url);
              $.ajax({
                  url      :url,
                  data     : $serialisedForm,
                  dataType : 'json',
                  type     : 'post'
              }).done(function(data){
                  var proceed = true;
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
                    $('#messageOnSubmission').text(data.message[errorKey]).css('color','#f70025');  
                  }
              }).fail(function(){
                  
              }).always(function(){  
                $('#emailid').val('');
                setTimeout(function(){
                    $('#messageOnSubmission').fadeOut('slow',function(){
                        $(this).text('');
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
            window.location.assign('#menuPage');
        });
        $(document).on('click','.contact',function(){
            window.location.assign('#contactPage');
        });
         $(document).on('click','.upArrow',function(){
            $.fn.fullpage.silentMoveTo('2');
        });
       
       $('.animsition').animsition({
            inClass               :   'flip-in-x',
            outClass              :   'fade-out',
            inDuration            :    1500,
            outDuration           :    800
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

            //Scrolling
            css3: true,
            scrollingSpeed: 1600,
            autoScrolling: true,
            fitToSection: true,
            fitToSectionDelay: 1000,
            scrollBar: false,
            easing: 'easeInOutCubic',
            easingcss3: 'ease',
            loopBottom: false,
            loopTop: false,
            loopHorizontal: true,
            continuousVertical: false,
            normalScrollElements: '#element1, .element2',
            scrollOverflow: true,
            touchSensitivity: 15,
            normalScrollElementTouchThreshold: 5,

            //Accessibility
            keyboardScrolling: true,
            animateAnchor: true,
            recordHistory: true,

            //Design
            controlArrows: true,
            verticalCentered: true,
            resize : false,
            paddingBottom: '10px',
            fixedElements: '#header, .footer',
            responsiveWidth: 0,
            responsiveHeight: 0,

            //Custom selectors
            sectionSelector: '.section',
            slideSelector: '.slide',

            afterLoad: function(anchorLink, index){
               
                if(index === 1 && anchorLink === 'homePage'){
                    setTimeout(function(){
                        $.fn.fullpage.moveTo(2);
                    },15000);   
                } 
                
                if(index === 1  || index === 2){
                    $('#home-logo').fadeOut();
       
                } else{
                    $('#home-logo').fadeIn('700');
                }
               
            } 
        });
        
     
          
    }
    
}