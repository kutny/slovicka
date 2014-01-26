var module = angular.module('slovicka', []);

module
	.config(['$interpolateProvider', function($interpolateProvider) {
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}])
	.config(['$httpProvider', function($httpProvider) {
		$httpProvider.defaults.withCredentials = true;
	}])
	.config(['$locationProvider', function($locationProvider) {
		$locationProvider.html5Mode(true)
	}]);
