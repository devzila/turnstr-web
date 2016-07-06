
    <div class='row'>
        <div class='col-md-12'>
            <h3>Post Reported - {{ $post->caption}}</h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Post Reports for ID  - {{ $post->id}}
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Reported By</th>
                                            <th>User Name</th>
                                            <th>Report Content</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($reports))
											@foreach ($reports as $k=>$row)
											<tr>
												<td>{{$k+1}}</td>
												<td>{{$row->user_id }}</td>
												<td>{{$row->name }}</td>
												<td>{{$row->username }}</td>
												<td>{{$row->content }}</td>												
											</tr>
											@endforeach
                                        @else
											<td colspan="3"> No Record Found</td>
											
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

