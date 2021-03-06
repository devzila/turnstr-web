@extends('layouts/admin')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <h1>Users</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Users List
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Following</th>
                                            <th>Followers</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($all_users))
                                        @foreach ($all_users as $k=>$row)
                                        <tr>
                                            <td>{{ $row->id}}</td>
                                            <td>{{($row->name!='') ? $row->name : "--" }}</td>
                                            <td>{{($row->gender!='') ? $row->gender : "--" }}</td>
                                            <td>{{($row->email!='') ? $row->email : "--" }}</td>
                                            <td>{{($row->following!='') ? $row->following : "--" }}</td>
                                            <td>{{($row->followers!='') ? $row->followers : "--" }}</td>
                                            <td>
                                                <a href="{{url('/admin/users/'.$row->id.'/edit')}}">Edit</a>
                                                <span> | </span>
                                                <form action="{{ url('/admin/users/'.$row->id) }}" class='deleteForm{{$row->id}}' method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                         <a href='javascript:void(0)' onClick='deleteUser({{$row->id}})' >Delete</a>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
										
										
										
                                        @endif
                                    </tbody>
                                </table>
								<hr>
								<div class="paginate pull-right">{!! $all_users->render() !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function deleteUser(formClass) {
        var title = "Confirmation Alert !!!";
        var content = "Do you want to delete this user ?";

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