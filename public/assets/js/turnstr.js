(function(e) {			
		e(document).on("click", "#followbtn", function() {
			var followBtn = e("#followbtn");				
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
})(jQuery)