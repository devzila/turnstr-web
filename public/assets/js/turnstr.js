var signinWin,cAlertMessage,cAlertTitle;
(function(e) {	
		
		e(document).on("click", ".followbttn", function() {	
			var btnId = this.id;			
			var followBtn = e("#"+btnId);
			var likebtn = e("#likebtn");			
			var status = followBtn.attr("data-status-"+btnId);
			var followId = followBtn.attr("data-followId-"+btnId);
			var followBtnHtml = followBtn.html();
			followBtn.html("Wait...");
			followBtn.attr('disabled','disabled');
			
			data = {
				status: status,
				followId: followId,
				_token: e('[name="csrf_token"]').attr('content')
				
			};
			e.ajax({
				url: "/users/followuser",
				type: "post",
				data: data,
				dataType: "json",
				success: function(t) {						
					if(t.status == 1){
						if(status == 1){
							followBtn.attr("data-status-"+btnId,0);
							followBtn.html("Unfollow");
						}else{
							followBtn.attr("data-status-"+btnId,1);
							followBtn.html("Follow");
						}
					}else if(t.status == 3){
							likebtn.addClass("hide");
							followBtn.addClass("hide");
						}
				},
				error: function(){
					followBtn.html(followBtnHtml);						
				},
				complete: function() {						
					followBtn.removeAttr('disabled');
				}
			})
		});
		
		
		
		e(document).on("click", "#likebtn", function() {
				var likebtn = e("#likebtn");				
				var followBtn = e("#followbtn");				
				var totalLikes = e("#total_likes");				
				var totalLikesCount = totalLikes.html();				
				var status = likebtn.attr("data-like-status");
				var postId = likebtn.attr("data-postId");
				var likeImg = e("#likeImg");			
				var unlikeImg = e("#unlikeImg");	
				//var likebtnHtml = likebtn.html();
				//likebtn.html("Wait...");
				likebtn.attr('disabled','disabled');
				
				data = {
					status: status,
					postId: postId,
					_token: e('[name="csrf_token"]').attr('content')
				};
				e.ajax({
					url: "/users/likePost",
					type: "post",
					data: data,
					dataType: "json",
					success: function(t) {						
						if(t.status == 1){
							if(status == 1){
								likebtn.attr("data-like-status",0);								
								unlikeImg.removeClass("show").addClass('hide');
								likeImg.removeClass("hide").addClass('show');
								//totalLikes.html(totalLikesCount-1);	
								totalLikes.html(function(i, val) { return +val+1 });
							}else{
								likebtn.attr("data-like-status",1);								
								likeImg.removeClass("show").addClass('hide');
								unlikeImg.removeClass("hide").addClass('show');
								totalLikes.html(function(i, val) { return +val-1 });
							}
						}else if(t.status == 3){
							likebtn.addClass("hide");
							followBtn.addClass("hide");
						}
					},
					error: function(){
						likebtn.html(likebtnHtml);						
					},
					complete: function() {						
						likebtn.removeAttr('disabled');
					}
				})
			});
		
		
		e(document).on("keyup", "#commentPost", function(event) {
			var hasError = e(".has-error");
			hasError.removeClass("show").addClass("hide");
			if ((event.keyCode || event.which) == 13) {  // Enter keycode
				event.preventDefault();
				var commentPost = e("#commentPost");
				var commentPostId = e("#commentPostId");				
				var comments = commentPost.val();
				var commentError = e("#comment-error");
				var totalComments = e("#total_comments");
				
				if(comments == ""){
					commentError.html("Comment Filed is required.");
					hasError.removeClass("hide").addClass("show");
					return false;
				}
				commentPost.attr('disabled','disabled');
				commentPost.val("");
				var post_id = commentPostId.val();
				data = {
					post_id: post_id,
					comments: comments,
					_token: e('[name="csrf_token"]').attr('content')
				};
				e.ajax({
				url: "/comments",
				type: "post",
				data: data,
				dataType: "json",
				success: function(response) {						
					if(response.status == 1){						
						e( ".commentBLock" ).append( response.commentBlock );
						totalComments.html(function(i, val) { return +val+1 });						
					}if(response.status == 2 || response.status == 3){						
						commentError.html(response.msg);						
						hasError.removeClass("hide").addClass("show");
					}
				},
				error: function(){
					commentPost.val(comments);
					commentError.html("Comment is not Added.");
					hasError.removeClass("hide").addClass("show");		
				},
				complete: function() {						
					commentPost.removeAttr('disabled');
				}
			});
			
				
			}
			return false;			
		});		
	e(document).on("click", "#facebooklogin", function() {		
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (780 / 2)) + dualScreenLeft;
		var top = ((height / 2) - (610 / 2)) + dualScreenTop;
        signinWin = window.open("/auth/facebook", "SignIn", "width=780,height=610,toolbar=0,scrollbars=0,status=0,resizable=0,location=0,menuBar=0,left=" + left + ",top=" + top);
        //setTimeout(CheckLoginStatus, 2000);
        signinWin.focus();
        return false;
    });
	inappAppBusy = 0;
	e(document).on('click',"#inappBtn",function(event){
			event.preventDefault();
			if(inappAppBusy == 1) return;
			inappAppBusy = 1;
			
			var optinapp = e('input[name=optinapp]:checked').val();
			if(typeof optinapp === "undefined") { alert("Please select one Option"); inappAppBusy = 0; return; }
			data = {
					optinapp: optinapp,
					_token: e('[name="csrf_token"]').attr('content')
				};
			e.ajax({
				url: "/markInappropriate/"+e('#pid').val(),
				type: "post",
				data: data,
				dataType: "json",
				success: function(response) {					
					e("#inapp").html(response.msg);
					e("#inappClose").html("OK");					
					e("#inappBtn").addClass("hide");					
				},
				error: function(){
					
				},
				complete: function() {				
					inappAppBusy = 0;
				}		
				
	   }); 
	   }); 
	   
	   e(document).on('click',"#deletePost",function(event){
			event.preventDefault();
			e("#deletePost").addClass("hide");
			e("#deletePostClose").addClass("hide");
			var post_id = e("#deletePost").attr("data-post");
			data = {					
				_token: e('[name="csrf_token"]').attr('content')
			};
			e.ajax({
				url: "/deletePost/"+post_id,
				type: "post",
				data:data,
				dataType: "json",
				success: function(response) {										
					e("#postDeletedPost").removeClass("hide");
					e("#deleteConfirm").addClass("hide");
					e("#deleteMessage").html(response.msg);								
				},
				error: function() {										
					e("#deletePostClose").addClass("hide");
					e("#deleteConfirm").addClass("hide");
					e("#deleteMessage").html("Something went wrong. Please try Again.");
					window.location.reload();
				},
			}); 
	   });
	   e(document).on('click',"#postDeletedPost",function(event){
			event.preventDefault();
			window.location.href="/";
	   });	
		
	   e(document).on('show.bs.modal','#cAlert', function (e) {

		$(this).find('.modal-body .cAlertMessage').text(cAlertMessage);
		if(cAlertTitle)
			$(this).find('.panel-title').text(cAlertTitle);
		cAlertMessage ="";
		cAlertTitle ="";
	});
	e(document).on('click','.deleteComment', function (e) {
		e.preventDefault();
		var url=$(this).attr('data-href'); 
		var cmsg=$(this).attr('data-cmsg');
		var data_id=$(this).attr('data-id');
		$('#cmsg').html(cmsg);
		$('#confirmModal').modal({ backdrop: 'static', keyboard: false }).one('click', '#deleteConfirm', function() {
			
			data = {					
				_token: $('[name="csrf_token"]').attr('content')
			};
			$.ajax({
				url: url,
				type: "post",
				data:data,
				dataType: "json",
				success: function(response) {
					if(response.status == 1){
						$(".delete-user-comment-"+data_id ).slideUp( "fast"	);
					}
					else 
						cAlert("Something is wrong. Please try again.","Alert!");
				},
				error: function() {										
					cAlert("Something is wrong. Please try again.","Alert!");
				},
			}); 
		});

	});

		
})(jQuery);

function share_social(url){
	window.open(url,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
	return false;	
}
		
function cAlert(cAlertMessage1,cAlertTitle1){
	cAlertMessage = cAlertMessage1;
	cAlertTitle = cAlertTitle1;
	$('#cAlert').modal('show');
}