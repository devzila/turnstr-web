@extends('layouts/admin')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <h1>Comments</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Comments List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Post Caption</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th>Comment Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($all_comments))
                                        @foreach ($all_comments as $k=>$row)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{($row->user_name!='') ? $row->user_name : "--" }}</td>
                                            <td>{{($row->caption!='') ? $row->caption : "--" }}</td>
                                            <td>{{($row->comments!='') ? $row->comments : "--" }}</td>
                                            <td><div class="{{ ($row->approved) ? 'btn-success':'btn-danger' }}">{{ ($row->approved) ? 'Approved':'Disapproved' }}</div></td>
                                            <td>{{($row->created_at!='') ? date('M d, Y',strtotime(($row->created_at))) : "--" }}</td>
                                           <td>
                                                {{--<a href='javascript:void(0)'>Edit</a>
                                                <span> | </span>--}}
												<a href='javascript:void(0)' onClick='toggleApprove("appr{{ $row->id}}")'  data-status-appr{{$row->id}}='{{!$row->approved}}' data-id-appr{{$row->id}}='{{$row->id}}' id="appr{{$row->id}}" class="{{ (!$row->approved) ? '':'btn-danger' }}">{{ (!$row->approved) ? 'Approve':'Disapprove' }}</a>
												<span> | </span>
												<form action="{{ url('/admin/comments/'.$row->id) }}" class='deleteForm{{$row->id}}' method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                         <a href='javascript:void(0)' onClick='deleteComment({{$row->id}})' >Delete</a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function deleteComment(formClass) {
        var title = "Confirmation Alert !!!";
        var content = "Do you want to delete this Comment ?";

        $.confirm({
            title: title,
            content: content,
            confirm: function(){
                $(".deleteForm"+formClass).submit();
                return true;
            },
            cancel: function(){
                 return true;
            }
        });
        
    }
	
	function toggleApprove(btnId) {
        var title = "Confirmation Alert !!!";
        var content = "Do you want to Disapprove this Comment ?";

        $.confirm({
            title: title,
            content: content,
            confirm: function(){
				var btn  = $("#"+btnId);
				var  status = btn.attr("data-status-"+btnId);
				var  apprId = btn.attr("data-id-"+btnId);
				btn.attr('disabled','disabled');
				var btnHtml = btn.html();
				data = {
					status: status,
					apprId: apprId,
					_token: $('[name="csrf_token"]').attr('content')
					
				};
				$.ajax({
					url: "/comments/approve",
					type: "post",
					data: data,
					dataType: "json",
					success: function(t) {						
						if(t.status == 1){
							if(status == 1){
								btn.attr("data-status-"+btnId,0);
								btn.html("Disapprove");
								btn.removeClass("btn-success").addClass("btn-danger");
							}else{
								btn.attr("data-status-"+btnId,1);
								btn.html("Approve");
								btn.addClass("btn-success").removeClass("btn-danger");
							}
						}else if(t.status == 3){								
								btn.html("Login");
							}
					},
					error: function(){
						btn.html(btnHtml);						
					},
					complete: function() {						
						btn.removeAttr('disabled');
					}
				});				
                return true;
            },
            cancel: function(){
                 return true;
            }
        });
        
    }
	
	
    </script>
@endsection