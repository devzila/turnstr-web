@extends('layouts/admin')



@section('content')

    <div class='row'>
        <div class='col-md-12'>
            <h1>Posts</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Posts
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Caption</th>
                                            <th>Name</th>
                                            <th>Reported Count</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($all_posts))
                                        @foreach ($all_posts as $k=>$row)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>
											@if($row->caption!='') 
												<a  href="{{App\Helpers\UniversalClass::shareUrl($row->id)}}" target="_blank">{{$row->caption}}</a>
											@else
												<a  href="{{App\Helpers\UniversalClass::shareUrl($row->id)}}" target="_blank">NULL</a>
											@endif
											</td>
                                            <td>{{$row->name}}</td>
                                            <td><a data-href="/admin/reports/{{$row->id}}" data-toggle="modal" href="#data-modal-get">{{$row->report_count}}</a></td>
                                            <td><div id="tappr{{$row->id}}" class="{{ ($row->active) ? 'btn-success':'btn-danger' }}">{{ ($row->active) ? 'Active':'InActive' }}</div></td>
                                            <td>{{date('M d, Y',strtotime($row->created_at))}}</td>
                                            <td>
                                                <a href='{{url("admin/comments/".$row->id)}}'>View Comments</a>
                                                <span> | </span>
                                                {{--<a href="{{url('/admin/posts/'.$row->id.'/edit')}}">Edit</a>
                                                <span> | </span>--}}
												<a href='javascript:void(0)' onClick='toggleActivate("appr{{ $row->id}}")'  data-status-appr{{$row->id}}='{{!$row->active}}' data-id-appr{{$row->id}}='{{$row->id}}' id="appr{{$row->id}}" class="{{ (!$row->active) ? 'btn-success':'btn-danger' }}">{{ (!$row->active) ? 'Activate':'InActivate' }}</a>
                                                <form action="{{ url('/admin/posts/'.$row->id) }}" class='deleteForm{{$row->id}}' method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href='javascript:void(0)' onClick='deletePost({{$row->id}})'>Delete</a>
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
	@include('admin.modal.modal')

@endsection
@section("additional_js")
    <script type="text/javascript">
    function deletePost(formClass) {
        var title = "Confirmation Alert !!!";
        var content = "Do you want to delete this post ?";

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

	
	function toggleActivate(btnId) {
        var title = "Confirmation Alert !!!";
        var btn  = $("#"+btnId);
		var  status = btn.attr("data-status-"+btnId);
		var aname = (status)?"Activate":"InActivate";
		var content = "Do you want to " + aname + " this Turn ?";
		
        $.confirm({
            title: title,
            content: content,
            confirm: function(){
				
				var  apprId = btn.attr("data-id-"+btnId);
				btn.attr('disabled','disabled');
				var btnHtml = btn.html();
				data = {
					status: status,
					apprId: apprId,
					_token: $('[name="csrf_token"]').attr('content')
					
				};
				$.ajax({
					url: "/admin/posts/activate",
					type: "post",
					data: data,
					dataType: "json",
					success: function(t) {						
						if(t.status == 1){
							if(status == 1){
								btn.attr("data-status-"+btnId,0);
								btn.html("InActivate");
								$("#t"+btnId).html("Active");
								$("#t"+btnId).addClass("btn-success").removeClass("btn-danger");							
								btn.removeClass("btn-success").addClass("btn-danger");
							}else{
								btn.attr("data-status-"+btnId,1);
								btn.html("Activate");
								$("#t"+btnId).html("InActive");
								$("#t"+btnId).removeClass("btn-success").addClass("btn-danger");							
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
	 
	 $("#data-modal-get").on('show.bs.modal',function(e){	   
			var url = $(e.relatedTarget).data('href');
			$('#allDetail').html("");
			$('#allDetail').load(url);
			
	   }); 
	
    </script>
@endsection
