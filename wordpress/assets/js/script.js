$(document).ready(function() {
	  
		// validate the comment form when it is submitted
		//$("#step1Form").validate();
		
		// validate signup form on keyup and submit
 	
		$("#savepet").click(function(e){
			//e.preventDefault();
			$("#step1Form").validate({
			
			debug: true,
			rules: {
				pettype: "required",
				petname: "required",
				
				zipcode: {
					required: true,
                                        number: true,
                                minlength: 5
				},
				weight: "required"
			},
			messages: {
				pettype: "Please enter your pet type",
				petname: "Please enter your pet name",
				
				zipcode:{
				  required: "Please enter your zip code."
				  ,number: "Please enter the numbers only.",
                                  minlength: "Zip code must be 5 digits."
				  },
				weight: "Please select pet weight",
				
			}
		});
                        
                        
			if($("#step1Form").valid()){
								$('#loading-image').show();
					var pettype = $('input:radio[name=pettype]:checked').val();
					var petname = $("#petname").val();
					var weight = $("#weight").val();
					var zipcode = $("#zipcode").val();
					var category = $("#category").val();
					var fun_type = "savepet";
					
					   $.ajax({
							type: 'POST',
                           // dataType: 'json',
							 url:"/wordpress/wp-content/themes/dp-ecomm-merged/ajax.php?action=addToCart",
							 data: {type: pettype,name:petname,weight:weight,zipcode:zipcode,category:category,fun_type:fun_type},
							 success: function (data) {
                                var results = $.parseJSON(data);
                                var petData = results.petData;
                                //$.each(petData, function(i,item){
                                //    console.log('i-'+i);
                                //    console.log('item---'+item.id);
                                //});
                                
                                if(data!=0){
                                    var finalhtml ='';
                                    $.each(petData, function(i,item){
                                        petid = item.id;
                                        pettype = item.pet_type;
                                        petname = item.pet_name;
                                        weight = item.pet_weight;
                                        category_id = item.category_id;
                                        if(pettype==0){ pet_type = 'Dog'; } else{ pet_type = "Cat";}
                                            /*********************************************/
                                            finalhtml +='<div class="row"><div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><span class="label">'+pet_type+' - <span class="text-capitalize">'+petname+'</span></span></div><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">Weight: '+weight+' lbs</div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><div class="crossBtn" onclick="deletediv('+petid+','+pettype+','+category_id+');"><input type="hidden" value="'+petid+'" id="recordid" style="display:none;"/></div></div></div>';
                                            /*********************************************/
                                    });
                                    
                                    $('#left_bar .cart-info').html(finalhtml);
                                }
                                else{
                                    $('#left_bar .cart-info').html('<li></li>');
                                }                                
							    //if(pettype==0){ pettype = 'Dog'; } else{ pettype = "Cat";}
								/*********************************************/
								//$('#left_bar .cart-info').append('<li><div class="left">'+pettype+' - '+petname+'</div><div class="right">Weight: '+weight+' lbs</div><div class="crossBtn" onclick="deletediv('+msg+');"><input type="hidden" value="'+msg+'" id="recordid" style="display:none;"/></div></li>');
								/*********************************************/
								$("#petname").val("");
								$("#weight").val("");
								//$("#zipcode").val("");
								$("#zipcode").prop('disabled', true);
								  $('#loading-image').hide();
								//  location.reload(); 
								//alert(msg);
                            },
							error: function (error) {
							   // alert("Please check your connection");
							}
						});
			}
		
		});
                
		$('#savecontinue').click(function() {
		 	//if($("#step1Form").valid()){
			  var pettype = $('input:radio[name=pettype]:checked').val();
			  var petname = $("#petname").val();
			  var weight = $("#weight").val();
			  var zipcode = $("#zipcode").val();
			  var category = $("#category").val();
                          var zipcode1 = $("#zipcode").val().length;
			  if(zipcode1<5){alert("Zip code must be 5 digits.");
			  return false;
			  }
			  var fun_type = "savecontinue";
				 $.ajax({
					  type: 'POST',
					   url:"/wordpress/wp-content/themes/dp-ecomm-merged/ajax.php?action=addToCart",
					   data: { type: pettype,name:petname,weight:weight,zipcode:zipcode,category:category,fun_type:fun_type},
					  success: function (data) {
                        var results = $.parseJSON(data);
                        var petData = results.petData;
						//console.log();
						//msg = $.trim(msg);
						if((results.pettype == 'dog') || (results.pettype == "multiple"))
						{
							window.location = "/step-2";
						}
						else{
							window.location = "/step-3a";
						}
				   },
					  error: function (error) {
						  console.log("Please check your connection");
					  }
				  });
		// };	
	  });
		
		$(".radio1").on("change",function(){
			var pettype = $('input:radio[name=pettype]:checked').val();
			$.ajax({
				type: 'POST',
				url:"/wordpress/wp-content/themes/dp-ecomm-merged/ajax.php?action=getPetweight",
				data: { pettype: pettype},
				success: function (msg) {
					if(pettype==1){
						$('#category').val(3);
					}else{
						$('#category').val(1);
					}
					//console.log(msg);
				  $('#weight').html(msg);
				  
				},
				error: function (error) {
					alert("Please check your connection");
				}
			});
		});
/*step 2 functions*/		
		$("#catfood_category").hide();
        $("#dogfood_category").hide();
        var pettypeid = $("#pettypeid").text();
        //console.log(pettypeid);
        if(pettypeid == "dog" || pettypeid == "multiple"){
          $("#dogfood_category").show();
        }
        if(pettypeid == "cat"){
          $("#catfood_category").show();
        }

	
$('#recurring_order').click(function() {
        if($(this).is(':checked')){
		var dataid = $(this).attr("data-id");
		//console.log(dataid);
		$("#recurring_order_category").val(dataid);            
           // alert('sdsd');
			$("#recurring_order_first").prop('checked', false);
            $('.column-2').removeClass('active');
	        $('.column-3').addClass('active');
		}
        else{
            console.log('unchecked');
		}
    });
$('#recurring_order_first').click(function() {
        if($(this).is(':checked')){
		var dataid = $(this).attr("data-id");
		//console.log(dataid);
		$("#recurring_order_category").val(dataid);            
           //  alert('sdsd');
			$("#recurring_order").prop('checked', false);
            $('.column-2').addClass('active');
	        $('.column-3').removeClass('active');            
		}
    });


	//  $('#step2Form input').on('change', function() {
	//	alert($('input[name=recurring_order]:checked', '#step2Form').val()); 
	// });
	
	//  var $chkboxes = $('input[type=radio]');
	//   
	//  $chkboxes.click(function() {

	//       $('.column-2').toggleClass('active');
	//       $('.column-3').toggleClass('active');
	//      });
/*end step 2 functions*/			
/*step 3 functions*/

/*end step 3 functions*/

/*Shipping page */
  $("input#inputPhone").mask("(?999) 999-9999");//"(99) 9999?9-9999"
  $("input#inputZipCode").mask("99999");
  var creditcard = $("#creditcard").mask("9999 9999 9999 9999");

//  $.mockjax({
//			url:"/wp-content/themes/dp/ajax.php?action=getStates",
//            data: { state: state, zipcode:zipcode},
//			response: function(settings) {
//                console.log(settings);
//				//var user = settings.data.match(/user=(.+?)($|&)/)[1],
//					//password = settings.data.match(/password=(.+?)($|&)/)[1];
//				if (password !== "foobar") {
//					this.responseText = "Your password is wrong (must be foobar).";
//					return;
//				}
//				this.responseText = "Hi " + user + ", welcome back.";
//			},
//			responseStatus: 200,
//			responseTime: 500
//		});
  $("#shippingform").validate({
			
			debug: true,
			rules: {
				inputFirstName: {
                                                 required: true,
                                                 alphanumeric: true
                                                  },
                                                  
                                inputLastName: {
                                                 required: true,
                                                 alphanumeric: true
                                                  },
				
				inputAddress1: {
					required: true
				},
				//inputAddress2: "required",
                                inputCity: {
                                                 required: true,
                                                 alphanumeric: true
                                },
				inputZipCode:{
					required: true,
					number: true,
					minlength: 5
             
				},
				inputEmail:{
					required: true,
					email: true
				},
				inputConfirmEmail:{
					required: true,
					email: true,
                    equalTo: "#inputEmail"
				},
				inputPhone:{
					required: true,
                    //maskedPhone: true
					//number: true,
                    minlength: 10,
                   // maxlength: 10
				},
                inputState:"required",
				//inputReferred:"required"
				
			},
			messages: {
                                inputFirstName:{
				  required: "Please enter your First Name.",
                                  alphanumeric : "Letters, numbers, and underscores only please."
				  },
				
                                 inputLastName:{
				  required: "Please enter your Last Name.",
                                  alphanumeric : "Letters, numbers, and underscores only please."
				  },
				
				inputAddress1:{
				  required: "Please enter your Address."
				  },
				//inputAddress2: "Please enter your Address 2",
                                inputCity:{
				  required: "Please enter your City.",
                                  alphanumeric : "Letters, numbers, and underscores only please."
				  },

				inputZipCode:{
					required:"Please enter your Zipcode.",
					number: "Please enter 5 digits",
                    minlength: "Your zip code must be 5 digit long."
				},
				inputEmail:{
					required:"Please enter your Email.",
					email: "Please enter valid email id."
				},
				inputConfirmEmail:{
					required:"Please enter your confirmation Email.",
					email: "Please enter valid email id.",
                    equalTo: "Please enter the same email as above"
				},
				inputPhone:{
					required:"Please enter your Phone no.",
                    //maskedPhone: "Please enter your Phone no."
					//number: "Please enter only numbers",
                    minlength: "Your phone number must be 10 digit long",
                    //maxlength: "Your phone number must be 10 digit long"
				},
                inputState: "Please select your state",
				//inputReferred:"Please select Referred by."
				
			},
			submitHandler: function(form) {
					//alert(form);
				form.submit();
//                jQuery(form).ajaxSubmit({
//					target: "#result"
//				});
            }
           
		});
                
                 $.validator.addMethod("alphanumeric", function(value, element) {
	return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, and underscores only please");
/*end shipping page*/
/*billing page*/
		$("#billingform").validate({
			
			debug: true,
			rules: {
				inputCardholderName: "required",
				inputCardNumber: {
					required: true,
					number: true,
					creditcard: true
				},
				Month: {
					required: true
				},
				
				inputCardID:{
					required: true,
					number: true
				}
				
			},
			messages: {
				inputCardholderName: "Please enter your card name",
				inputCardNumber: {
					required:"Please enter your card number.",
					number: "Please enter only numbers.",
					creditcard: "Please enter valid credit card numbers."
				},
				
				Month:{
				  required: "Please select your month."
				  },
				
				inputCardID:{
					required:"Please enter your ccv.",
					number: "Please enter only numbers."
				},
				
			},
			submitHandler: function(form) {
					//alert(form);
				form.submit();
		 
		
		  
		  }     
		});
        
/*end billing page*/
});

function checkStates(){
      var state = $("#inputState").val();
  var zipcode = $("#inputZipCode").val();
    				 $.ajax({
					  type: 'POST',
					  dataType: 'json',
					   url:"/wordpress/wp-content/themes/dp-ecomm-merged/ajax.php?action=getStateszip",
                        data: { state: state, zipcode:zipcode},
					   success: function (data) {
						console.log(data);
						if (data == "0") {
                            this.responseText = "Your zipcode is wrong.";
                            $("#ziperror").css("display","block");
                            $("#ziperror").html("Your zipcode is wrong.");
                            return;
                        }else{
                            $("#ziperror").css("display","none");
                            $("#ziperror").html("");
                        }
                        //this.responseText = "Hi " + user + ", welcome back.";		
						  }
				  });
}
		function deletediv(id,pet_type,catid){
			//$(this).parents(".items").find(".bisonId").show();
		
			//var id = $(this).find("#recordid").val();
			//console.log(id);
				 $.ajax({
					  type: 'POST',
					  dataType: 'json',
					   url:"/wordpress/wp-content/themes/dp-ecomm-merged/ajax.php?action=deletePet",
					   data: { id: id,pettype:pet_type,category_id:catid },
					   success: function (data) {
						if(data!=0){
						var finalhtml ='';
						$.each(data, function(i,item){
							petid = item.id;
							pettype = item.pet_type;
							petname = item.pet_name;
							weight = item.pet_weight;
							category_id = item.category_id;
							if(pettype==0){ pet_type = 'Dog'; } else{ pet_type = "Cat";}
								/*********************************************/
								finalhtml +='<div class="row"><div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"><span class="label">'+pet_type+' - <span class="text-capitalize">'+petname+'</span></span></div><div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">Weight: '+weight+' lbs</div><div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><div class="crossBtn" onclick="deletediv('+petid+','+pettype+','+category_id+');"><input type="hidden" value="'+petid+'" id="recordid" style="display:none;"/></div></div></div>';
								/*********************************************/
						});
						
						$('#left_bar .cart-info').html(finalhtml);
							
							
						}
						else{
							$('#left_bar .cart-info').html('<li></li>');
						}
								
						  },
					  error: function (error) {
						  console.log("Please check your connection");
					  }
				  });
		}		