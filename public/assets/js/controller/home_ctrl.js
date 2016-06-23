var myApp = angular.module('Turnstr', ['infinite-scroll']);
var complete =0;
var url = 0;
myApp.controller('HomeController', function($scope, Reddit) {
  $scope.reddit = new Reddit();
});

// Reddit constructor function to encapsulate HTTP and pagination logic
myApp.factory('Reddit', function($http,$sce) {
  var Reddit = function() {
    this.items = [];
    this.busy = false;    
	this.page = 0;
  };
  Reddit.prototype.nextPage = function() {
	 
    if (complete) return;
    if (this.busy) return;
    this.busy = true;
    var url = "/?page=" + this.page + "&jsonp=JSON_CALLBACK";
    $http.get(url).success(function(data) {
	  if(data.length <=0) complete = 1;
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
