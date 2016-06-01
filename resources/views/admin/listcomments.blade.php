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
                                            <td>{{($row->created_at!='') ? date('M d, Y',strtotime(($row->created_at))) : "--" }}</td>
                                           <td>
                                                {{--<a href='javascript:void(0)'>Edit</a>
                                                <span> | </span>--}}
                                                <form action="{{ url('/admin/comments/'.$row->id) }}" class='deleteForm{{$row->id}}' method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href='javascript:void(0)' onClick='deleteComment({{$row->id}})'>Delete</a>
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
    function deleteComment(commentId) {
        var title = "Confirmation Alert !!!";
        var content = "Do you want to delete this Comment ?";

        $.confirm({
            title: title,
            content: content,
            confirm: function(){
                $(".deleteForm"+commentId).submit();
                return true;
            },
            cancel: function(){
                 return true;
            }
        });
        
    }
    </script>
@endsection