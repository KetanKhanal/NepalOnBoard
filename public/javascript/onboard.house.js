$(document).ready(function(){house.start();});
house = {
    dropzone:'',
    houseModalSettings:{
        backdrop:'static' 
    },
    host:{
     files:''   
    },
    clicked:{
        element:"" 
    },
    target:[
      "address",
      "information",
      "expenses",
      "pictures",
      "detail",
      "personal",
      "verification",
      "final"
    ],
    formTitle:{
      "":"Your Address",
      "address":"Your Address",
      "information":"House Information",
      "expenses":"Weekly Expenses",
      "pictures":"Upload Pictures",
      "detail":"Extra Detail",
      "personal":"Personal Information",
      "verification":"Verifications",
      "final":"Final Stage"
    },
    active : [],
    add:'+1',
    sub:'-1',
    purg:{},
    
    /*
     * 
     * handleNext function helps with host form switches. i.e switching from one view to another
     */
    handleNext:function(way,$current){
        var me = house;
        var $hostModal = $('#host-modal');
        var go = (way ==="next")?me.add:me.sub;
        for(var i = 0 ; i<me.target.length;i++){
            var hit = (me.target[i] ===$($current).attr('id'))?true:false;
            if(hit){
                var el = me.target[i+Number(go)];
                var ob = "#"+way+"-set";
                $($current).removeClass('active-set');
                 $("#"+el).addClass('active-set');
                $(ob).attr('href',el);
            }      
        }
        me.arrowHandler();
    },
    
    /*
     * arrow handler function deals with showing next and previous arrow in the host form depending
     * on the which view it is on
     * 
     * @returns {undefined}
     */
    arrowHandler:function(){
        var me = house;
        $('.change').css({display:'block'});  
        if($("#host-modal").data('bs.modal').isShown && $('.active-set').attr('id')===me.target[0]){
            $('#previous-set').css({display:'none'});
        } 
        if($('#host-modal').data('bs.modal').isShown && $('.active-set').attr('id')===me.target[me.target.length-1]){
            $('#next-set').css({display:'none'});
        }  
    },
    
    /**
     * This function opens up the signIn modal
     * 
     * @returns {undefined}
     */
    handleSignInModalOpen : function(){
        var me = house;
        var $modalElement = $('#sign-modal');
        $modalElement.modal(me.houseModalSettings);
        $modalElement.modal('show');
        $modalElement.on('shown.bs.modal',function(e){
            var $theModal = $(this);
        }); 
    },
    /*
     * 
     * @returns {undefined}
     */
    handleHostModalOpen: function(){
        var me=house;
        var stateObj = {};
        var begining ='';
        var route = (me.active.length >0)?"/house/"+me.active[0]:"/house/";
        window.history.pushState(stateObj, " ",route );
        if(me.active.length === 0 ){
            begining= me.target[0];
        } else {
            begining = me.active[0];
        }
        $("#"+begining).addClass('active-set');
        var $hostModal = $('#host-modal');
        $hostModal.modal(me.houseModalSettings);
        $hostModal.modal('show');
        me.arrowHandler();
    },
    
    /*
     * Shut modal function helps to shut the host modal
     * 
     * @param {type} $element
     * @param {type} $form
     * @returns {undefined}
     */
    shutModal:function($element,$form){
        var me = house;
        $($form).on('submit',function(e){
            e.preventDefault();
        });
        if($($element).data('modal').toString() ==="host"){
            me.active = [];
            me.active.push($('.active-set').attr('id'));
        }
        $element.modal('hide');
        $element.on('hidden.bs.modal',function(e){ 
            var stateObj = {};
            window.history.pushState(stateObj, " ", "/house/");
        });
    },
    /*
     * Handle date picker function assigns datepicker to mentioned element
     * 
     * @returns {undefined}
     */
    handleDatePicker:function(){
        $('.houseDate').datepicker({
            dateFormat : "dd-mm-yy" 
        });
        $('#dob').datepicker({
            changeYear : true,
            yearRange  : "1900:1998",
            dateFormat : "dd-mm-yy" 
        });
    },
    
    /*
     * 
     * 
     * @returns {undefined}
     */
    start:function(){
        var me = house;
        me.handleDatePicker();
        $(document).on('click','.sign', me.handleSignInModalOpen);
        var app = angular.module('formApp',['ngRoute','ngAnimate','ngAria','ngMaterial']);
        app.config(['$routeProvider', '$locationProvider','$mdThemingProvider',
        function($routeProvider, $locationProvider) {
            $routeProvider
            .when('/', {
                templateUrl: 'address.htm',
                controller : 'theController'
            })
            .when('/information', {
                templateUrl: 'information.htm',
                controller : 'theController'
            })
            .when('/expenses', {
                templateUrl: 'expenses.htm',
                controller : 'theController'
            })
            .when('/pictures', {
                templateUrl: 'pictures.htm',
                controller : 'theController'
            })
            .when('/detail', {
                templateUrl: 'detail.htm',
                controller : 'theController'
            })
            .when('/personal', {
                templateUrl: 'personal.htm',
                controller : 'theController'
            })
            .when('/address',{
                templateUrl : 'address.htm',
                controller: 'theController'
            })
            .when('/final',{
                templateUrl : 'final.htm',
                controller: 'theController'
            })
            .when('/verification',{
                templateUrl: 'verification.htm',
                controller:'theController'
            });
            $locationProvider.html5Mode(true);
        }]);
        app.service('loadMsg',['$route',function($route){
            var theObj='';
            var progress=0;
            var check =[];
            var toAdd = null;
            return {
                bust:false,
                setObj:function(obj){
                    theObj = obj;
                },
                getObj:function(){
                  return theObj;  
                },
                infos:{
                    "address"     : "You realise this rite",
                    "detail"      : "What are you looking in the housemate",
                    "expenses"    : "Rent per week for an individual",
                    "pictures"    : "whatever",
                    "information" : "What is this why is this happening",
                    "varification": "Please verify the phone number and licence",
                    "personal"    : "Personal info block",
                    "final"       : "Process Application"
                },
                msg:function(v){
                    $('#modal-title').text(v);
                },
                loadBlock:function(heading){
                    if(!heading.length > 0){
                       heading = 'address'; 
                    }
                    $('#info-block').text(this.infos[heading]);
                },
                setProgress:function(value){
                    progress = value;
                    $('#progressTracker').val(value);
                },
                getProgress:function(){
                    return progress; 
                },
                addToCheck : function(item){
                    var present = false;
                    if(check.length === 0 ){
                        check.push(item);
                        return true;
                    }
                    for(var  i = 0 ; i<check.length ; i++){
                        if(check[i] ===item){
                          present = true;
                          return ;
                        }  
                    }
                    if(!present){
                        check.push(item);
                    }
                },
                getCheck : function(k){
                    var present = true;
                    if(check.length === 0){
                        return true;
                    }
                    for(var i = 0 ; i <check.length ; i++){
                        if(check[i] === k){
                            present = false;
                            return ;
                        } 
                    }
                    return present;
                },
                getToAdd:function(){
                    toAdd = Math.round(100/20);
                    return toAdd;
                },
                removeFromCheck: function(k){
                    for(var i = 0 ; i<check.length ; i++){
                        if(check[i] === k){
                            check.splice(i,1);
                        }
                    }  
                },
                printCheck : function(){
                    return check;
                }
            };
        }]);
        app.controller('theController',['$scope','loadMsg','$route',function($scope,loadMsg,$route){
            $('#host-submit-button').hide();
            $('form').on('keypress',function(e){
               if(e.keyCode === 13){
                   e.preventDefault();
                   return ;
               }
            });
            $scope.message = me.formTitle[$route.current.$$route.originalPath.replace('/',"")];              
            loadMsg.msg($scope.message);
            loadMsg.loadBlock($route.current.$$route.originalPath.replace('/',""));
            me.handleDatePicker();
            $scope.currentRoute = $route.current.loadedTemplateUrl.split('.')[0];
            $scope.sayings ={
            } ; 
            $scope.fill = function(){
               if(me.purg[$scope.currentRoute]){
                 $scope.sayings = me.purg[$scope.currentRoute];
               }
               me.purg[$scope.currentRoute] = $scope.sayings; 
            };
            $scope.fill();
            $scope.$watch('sayings',function(ne,old){
            });  
            $scope.checkChange=function(){ 
                $.each(me.purg, function(key,value){
                  angular.forEach(value,function(v,k){
                      if(loadMsg.getCheck(k)){
                          loadMsg.addToCheck(k);
                          loadMsg.setProgress(loadMsg.getProgress()+loadMsg.getToAdd());
                      }
                      if(v === "" || v===null || angular.isObject(v) && !loadMsg.getProgress()<=0){
                         loadMsg.removeFromCheck(k);
                         loadMsg.setProgress(loadMsg.getProgress()-loadMsg.getToAdd());  
                      }
                  });
                });   
            };    
            
        }]);
        app.controller('picturesController',['$scope','loadMsg','$route',function($scope,loadMsg,$route){
            $('#the-drop-zone').css({height:'150'});
            me.dropzone = me.generateDropZone();
            me.dropzone.on('removedfile',function(file){        
               console.log($(file.previewElement).closest('.theAddButtonContainer'));                
            });
            $scope.imageIds=[
                {id:'a',name:"image1"},
                {id:'b',name:"image2"},
                {id:'c',name:"image3"},
                {id:'d',name:"image4"}
            ];
            me.dropzone.clickable = '.theAddButtonContainer .theAddButton';
            $scope.description =['Kitchen','Lounge','Bathroom','Bedroom'];
            $scope.setDes = function($event){
                var imageId = $($event.currentTarget).parent().siblings('.imageDescription').attr('id');
                $($event.currentTarget).parent().siblings('.imageDescription').blur();
                $scope.sayings[imageId] = $($event.currentTarget).data('val'); 
                $scope.$parent.checkChange();
            };
            $scope.$watch('sayings',function(ne,ol){
                loadMsg.setObj(ne);
            });    
           
            if(me.purg[$scope.$parent.currentRoute]){
               $.each(me.purg[$scope.$parent.currentRoute],function(key,value){
                    
               });
            }      
        }]);
        app.controller('finalController',function($scope){
            $('#host-submit-button').toggle();
        });
        app.controller('verificationController',function($scope){
            
        });
        //Adress controller populates address fields automatically
        app.controller('addressController',function($scope){
            //Creating an autocomplete object using google maps palces api
            var autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('street'),
                {types: ['geocode']}
            );
            /**using html5 object navigator.geolocation which gives information about the browser's latitude and 
               longitude co-ordinates. and seting a bound to autocomplete object 
            */
            navigator.geolocation.getCurrentPosition(function(p){
                var geolocation = {
                    lat : p.coords.latitude,
                    lng : p.coords.longitude
                };
                var area = new google.maps.Circle({
                    center : geolocation,
                    radius : p.coords.accuracy
                });
                autocomplete.setBounds(area.getBounds());
            });     
            $scope.fillAddress = function(){
              var i = 0;
              var fields = ["street","suburb","state","postcode"];
              var tempResult = [];
              var result = autocomplete.getPlace().address_components;
              if(result.length ===8){
                  i = 1;
              }
              for( i ; i<result.length ; i++){
                if(result[i].types[0] !== "administrative_area_level_2" && result[i].types[0] !== "country"){
                   var toSet = result[i].types[0] ;
                   var name  = toSet ==="administrative_area_level_1" ? "short_name" : "long_name" ;
                   tempResult.push(result[i][name]);
                }
              }
              tempResult[0] = tempResult[0]+" "+tempResult[1];
              tempResult.splice(1,1);
              for(var j = 0 ;j< fields.length ; j++ ){
                $scope.$apply(function(){
                       $scope.$parent.sayings[fields[j]] = tempResult[j];
                       $scope.$parent.checkChange();
                });    
              }
            };
            autocomplete.addListener('place_changed',$scope.fillAddress);
        });
        app.controller('informationController', function($scope){
            $scope.setType = function($event){
                $scope.$parent.sayings.shareType = $($event.currentTarget).data('val'); 
                $scope.$parent.checkChange();
            };
            
            $scope.setMat=function($event){
                $scope.$parent.sayings.mattress=$($event.currentTarget).data('val');
                $scope.$parent.checkChange();
            };
        });
        app.controller('submitController',function($scope,loadMsg,$filter){
           var self = this;  
           self.value =loadMsg.getProgress();
           $scope.calPro = function(){
                self.value  = loadMsg.getProgress();
           };
           $scope.submitHost =function(){
               me.purg['expenses']['Total'] = $filter('number')(me.purg['expenses']['Total']);
               /*When the dropzone is sending the file*/
               console.log('dd');
               me.dropzone.on("sendingmultiple", function(file, xhr, formData) {
                    formData.append('data',JSON.stringify(me.purg));
               });
               me.dropzone.processQueue();
           };
        });
        app.controller('expenseController',['$scope','$filter','loadMsg',function($scope,$filter,loadMsg){
                $scope.checkBoxes = [
                {label:"Electricity",val:false},
                {label:"Water",val:false},
                {label:"Gas",val:false},
                {label:"Internet",val:false}
            ];
            $scope.call = function(){
               $scope.$watch('checkBoxes',function(ne,ol){
                    $.each(ne,function(key,val){
                        if(!val.val){
                            $scope.sayings[$scope.$parent.currentRoute][val.label] = 0;
                        }
                    });
                },true); 
            };
            
            $scope.expenses= {};
            //Object.Keys(object) gives the number of keys present in it 
            if(Object.keys($scope.$parent.sayings).length>0){
                $scope.expenses = $scope.$parent.sayings[$scope.$parent.currentRoute];
                $.each($scope.checkBoxes,function(key,val){
                    if($scope.$parent.sayings[$scope.$parent.currentRoute][val.label]){
                        val.val = true;  
                    }   
                });  
            }   
            $scope.call();
            $scope.$parent.sayings.expenses={
            };
            $scope.grandTotal = "";        
            $scope.total=function(){
                var total = 0 ; 
                $.each($scope.expenses,function(name,value){
                  total = total+value;
                });
                $scope.$parent.sayings.expenses=$scope.expenses;
                var gTotal = $filter('currency')(total+$scope.sayings.rent,'$',2);
                
                if(loadMsg.bust &&total === 0 && $scope.sayings.rent ===null){
                    gTotal = '';
                    $scope.$parent.checkChange();
                }
                $scope.$parent.sayings.Total= gTotal ; 
                loadMsg.bust= true;
                return gTotal  ;
            };
            $scope.$parent.fill();
            
        }]);
        $('.change').on('click',function(){
           me.arrowHandler();
           me.handleNext($(this).data('way'),$('.active-set')); 
        });
        $('#house-share-button-container').on('click','#house-share-button',me.handleHostModalOpen);
        $(document).on('click','.cancel',function(e){
           e.preventDefault();
           $('#host-modal').modal('toggle');
        });
        $(document).on('click','.modalShut',function(){
            me.shutModal($(this).closest('.modal'),$(this).closest('form')); 
        });
        var cities = [];
        $('input:radio[name=country]').on('click',function(e){
            if(cities.length >0){
                cities=[];
            }
            var data =$(this).val();
            $.ajax({
                url:'/house/load?country='+data,
                dataType:'json'
            }).done(function(data){
              $.each(data,function(key,city){
                cities.push(city);
                $('#destination').autocomplete({
                    autoFocus : true,
                    autocomplete:'on',
                    delay:0,
                    width:'350px',
                    source : cities,   
                    minLength : 1
                });
              });
            });
         });       
    },
    giveMe : function(file){
        var me = house;
        var $toRemove = document.getElementById($(file.previewElement).attr('id'));
        return $toRemove;
    },
    calculateWidth:function(){
        var num = Number($('.theAddButton').css('padding-left').match( /^\d+/g)[0]);
        return $('.theAddButton').width()+num;
    },
    generateDropZone:function(){
        var me = house;
        me.clicked.element = '';
        deleteMePlease = function(){
           me.host.files = me.dropzone.files;
        };
        callMePlease = function(file){
            var $toRemove = me.giveMe(file);
            var desContainer = document.getElementById($($toRemove).parent().data('image'));
            $(desContainer).parent().css({visibility:'visible'});
             $($toRemove).css('display','none'); 
             $(file.previewElement).addClass('col-md-12');
            $(file.previewElement).prependTo($($toRemove).parent());
            $(file.previewElement).children('.uploaded-photo').hover(function(){
                $(this).css({opacity:0.8});
                $(this).parent().children('.delete').show();
             },function(){$(this).css({opacity:1});$(this).parent().children('.delete').hide();});
             $(file.previewElement).children('.uploaded-photo').on('click',function(){
                 dropzone.removeFile(file);
                $($toRemove).fadeIn('fast',function(){
                    var con = document.getElementById($(this).parent().data('image'));
                    $(con).val("");
                    $(con).parent().css({visibility:'hidden'});
                }); 
                
             });
        };
        var theTemplate = $('.the-template').parent().html();// get the original template
        $('.the-template').parent().children('.the-template').remove();//remove the original template as this temp area needs to be vacated for when upload progresses
        var dropzone = new Dropzone('#the-drop-zone',{ 
           url:'/house/add',
           parallelUploads:4,
           autoProcessQueue:false,// dont want dropzone to automatically process request when file upload completes
           autoDiscover:false,//
           maxFiles: 4,//only one file is allowed to be uploaded at once
           uploadMultiple:true,//allow multiple data to be posted
           clickable:'.theAddButton',// add clickable class to add-button so that users can use add button to add photos
           thumbnailWidth:me.calculateWidth(),//width of the image that is seen in the upload progress block
           //thumbnailHeight:$('.theAddButton').height(),//height of the image that will be seen in the upload progress block
           previewTemplate:theTemplate,//template to be used for upload progress block
           previewsContainer:'#preview-container',//this specifies where to append the upload progress block
           maxFilesize:1,
           /*This function is the first entry point when dropzone class is added to an element*/
           init : function(){
               var dZone = this;
               $(document).on('click','.theAddButton',function(e){
                    me.clicked.element = $(this).attr('id');
               });
               if(me.host.files.length > 0 ){
                   $.each(me.host.files,function(key,file){
                         callMePlease(file);                 
                    });
               }
           }
        });
       
        /*This function is called when image is accepted by dropzone and is ready to be uploaded*/
        dropzone.on('addedfile',function(file){
          var me = house;
          if(!$(file.previewElement).attr('id')){
            $(file.previewElement).attr('id',me.clicked.element);
          }
          me.host.files = dropzone.files;
          callMePlease(file);
        });
        dropzone.on('sending',function(file,xhr,formData){
           formData.append($($(file.previewElement).parent()).data('image'),file.name);
        });
        /*When ajax call is completed and json string has been received from the backend, call this function which shows messages*/
        dropzone.on("success", function(file, xhr, formData) {
        });
        dropzone.on('removedfile',function(file){        
            deleteMePlease();
        });
        /*When the dropzone action is complete, i.e ajax call has been finished and messages have been received call this function*/
        dropzone.on("error", function(file,error) {
            var me = house;
            if(error){
              deleteMePlease(file);
              dropzone.removeFile(file);
              var $toRemove = me.giveMe(file);
              var error = '<p id="error">'+error+'</p>';
              $($toRemove).parent().append(error);
              setTimeout(function(){
                $('#error').remove();
                $($toRemove).css({'display':'block'});
              },3000);
            }
        });
        dropzone.on("uploadprogress", function(file,progress) {
          
        });
        
        return dropzone;
    }
}