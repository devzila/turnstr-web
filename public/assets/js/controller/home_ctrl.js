var myApp = angular.module('Turnstr', ['infinite-scroll']);
myApp.controller('HomeController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="HomeController";
	$scope.reddit = new Reddit();
});

myApp.controller('ExplorerController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="ExplorerController";
	$scope.reddit = new Reddit();
});

myApp.controller('TagController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="TagController";
	$scope.reddit = new Reddit();
});

myApp.controller('ProfileController', function($scope, Reddit, tSharedService ) {
	tSharedService.controllerName="ProfileController";
	$scope.reddit = new Reddit();
});

myApp.factory('tSharedService', function($rootScope) {
    var sharedService = {};
	sharedService.ctrlDefine = function(ctrlName){
		sharedService.controllerName = ctrlName;
	}
	sharedService.getParameterValues= function (param) {
			var urls = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			for (var i = 0; i < urls.length; i++) {
			var urlparam = urls[i].split('=');
				if (urlparam[0] == param) {
				return urlparam[1];
			}
		}
	}
	
  	sharedService.constructUrl=function(urlCtrl,page, offset){
	    var url;
		searchData = this.getParameterValues('searchData');
		
		if(searchData == null) searchData="";
		
		if(urlCtrl == "HomeController"){
			url = "/?page=" + page + "&jsonp=JSON_CALLBACK";	
		}else if(urlCtrl == "ExplorerController"){			
			url = "/explore?searchData=" + searchData + "&page=" + page + "&jsonp=JSON_CALLBACK";
		}else if(urlCtrl == "TagController"){
			url = "/tags?searchData=" + searchData + "&page=" + page + "&jsonp=JSON_CALLBACK";
		}else if(urlCtrl == "ProfileController"){
			url = window.location.href+"?page=" + page + "&jsonp=JSON_CALLBACK";
		}
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
		if((typeof data[i].comments !== "undefined") && data[i].comments.length > 0){
			for(var j = 0; j < data[i].comments.length; j++) {
				data[i].comments[j].commentsHtml = $sce.trustAsHtml(data[i].comments[j].commentsHtml);
			}
		}
		
        this.items.push(data[i]);
      }	  
      this.page = this.page + 1 ;
      this.busy = false;
    }.bind(this));
  };

  return Reddit;
});
