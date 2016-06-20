(function(e) {			
		e(document).on("click", "#followbtn", function() {
			var followBtn = e("#followbtn");
			var likebtn = e("#likebtn");			
			var status = followBtn.attr("data-status");
			var followId = followBtn.attr("data-followId");
			var followBtnHtml = followBtn.html();
			followBtn.html("Wait...");
			followBtn.attr('disabled','disabled');
			
			data = {
				status: status,
				followId: followId,
				_token: followBtn.attr("data-token")
			};
			e.ajax({
				url: "/users/followuser",
				type: "post",
				data: data,
				dataType: "json",
				success: function(t) {						
					if(t.status == 1){
						if(status == 1){
							followBtn.attr("data-status",0);
							followBtn.html("Unfollow");
						}else{
							followBtn.attr("data-status",1);
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
					_token: likebtn.attr("data-token")
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
					_token: e("input[name='_token']").val()
				};
				e.ajax({
				url: "/comments",
				type: "post",
				data: data,
				dataType: "json",
				success: function(response) {						
					if(response.status == 1){						
						e( ".commentBLock" ).prepend( response.commentBlock );
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
		
		
		
		
})(jQuery)