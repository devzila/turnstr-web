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
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($all_posts))
                                        @foreach ($all_posts as $k=>$row)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{($row->caption!='') ? $row->caption : "--" }}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{date('M d, Y',strtotime($row->created_at))}}</td>
                                            <td>
                                                <a href='{{url("admin/comments/".$row->id)}}'>View Comments</a>
                                                <span> | </span>
                                                <a href="{{url('/admin/posts/'.$row->id.'/edit')}}">Edit</a>
                                                <span> | </span>

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
    </script>
@endsection