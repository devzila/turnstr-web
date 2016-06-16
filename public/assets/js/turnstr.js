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
				var status = likebtn.attr("data-like-status");
				var postId = likebtn.attr("data-postId");
				var likebtnHtml = likebtn.html();
				likebtn.html("Wait...");
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
								likebtn.html("Unlike");
							}else{
								likebtn.attr("data-like-status",1);
								likebtn.html("Like");
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
		
		
		
		
})(jQuery)