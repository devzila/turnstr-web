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
                                            <td>{{$k+1}}</td>
                                            <td>{{($row->name!='') ? $row->name : "--" }}</td>
                                            <td>{{($row->gender!='') ? $row->gender : "--" }}</td>
                                            <td>{{($row->email!='') ? $row->email : "--" }}</td>
                                            <td>{{($row->following!='') ? $row->following : "--" }}</td>
                                            <td>{{($row->followers!='') ? $row->followers : "--" }}</td>
                                            <td>
                                                <a href='javascript:void(0)'>Edit</a>
                                                <span> | </span>
                                                <a href='javascript:void(0)' >Delete</a>
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
@endsection