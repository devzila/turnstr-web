var myApp = angular.module('Turnstr', ['infinite-scroll']);
myApp.controller('HomeController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="HomeController";
	$scope.reddit = new Reddit();
});

myApp.controller('ExplorerController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="ExplorerController";
	$scope.reddit = new Reddit();
});

myApp.factory('tSharedService', function($rootScope) {
    var sharedService = {};
	sharedService.ctrlDefine = function(ctrlName){
		sharedService.controllerName = ctrlName;
	}
  	sharedService.constructUrl=function(urlCtrl,page, offset){
	    var url;
		if(urlCtrl == "HomeController")
			url = "/?page=" + page + "&jsonp=JSON_CALLBACK";
		else if(urlCtrl == "ExplorerController")
			url = "/explore?page=" + page + "&jsonp=JSON_CALLBACK";
		
		return url;	
	  }
    return sharedService;
});

// Reddit constructor function to encapsulate HTTP and pagination logic
myApp.factory('Reddit', function($http,tSharedService,$sce) {
  var Reddit = function() {
	this.sharedService = tSharedService;
    this.items = [];
    this.busy = false;    
	this.page = 0;
	this.offset = 0;
	this.complete = 0;
  };
  Reddit.prototype.nextPage = function() {
	 
    if (this.complete) return;
    if (this.busy) return;
    this.busy = true;
    var url = this.sharedService.constructUrl(this.sharedService.controllerName,this.page, this.offset);
    $http.get(url).success(function(data) {
	  if(data.length <=0) this.complete = 1;
	  for(var i = 0; i< data.length; i++) {
		data[i].caption = $sce.trustAsHtml(data[i].caption);
        this.items.push(data[i]);
      }	  
      this.page = this.page + 1 ;
      this.busy = false;
    }.bind(this));
  };

  return Reddit;
});
