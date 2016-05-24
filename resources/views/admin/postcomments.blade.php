@extends('layouts/admin')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <h1>Posts Comments</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Comments
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Comment</th>
                                            <th>Commented On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($all_comments))
                                        @foreach ($all_comments as $k=>$row)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{($row->username!='') ? $row->username : "--" }}</td>
                                            <td>{{$row->comments}}</td>
                                            <td>{{date('M d, Y',strtotime($row->created_at))}}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td colspan=4 style='text-align:center;'> No Records Found !! </td>
                                            </tr>
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