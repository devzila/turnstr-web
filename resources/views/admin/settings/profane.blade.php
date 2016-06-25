@extends('layouts/admin')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <h1>Settings</h1>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Profane Words
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10">
								
								<form action="/admin/settings/profaneUpdate" method="post">
									<div class="row">  
                                    <div class="form-group col-lg-10">
                                        <div class="col-lg-2 text-align-right">
                                            <label for='test'>Profane</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" id='profane_words' name="profane_words">{{$profane_words}}</textarea>
                                        </div>
                                    </div>
									</div>
									<div class="row">    
										<div class="col-lg-2 text-align-right">
                                          
                                        </div>
										<div class="form-group col-lg-10">
											<div class="col-lg-2 text-align-right">
												<input  type="submit" class="form-control btn btn-block btn-primary"  name="submit" value="Update">
											</div>
										</div>                                
									</div>
									{{ csrf_field() }}
								</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection