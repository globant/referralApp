var referralApp = angular.module('referralApp', [
  'ngRoute',
  'referralController'
]);

referralApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/homepage.html', {
        templateUrl: '/resources/templates/homepage.html',
        controller: 'mainPageCtrl'
      }).
      when('/login.html', {
        templateUrl: '/resources/templates/login.html',
        controller: 'mainPageCtrl'
      }).
      when('/my-profile.html', {
        templateUrl: '/resources/templates/myprofile.html',
        controller: 'myProfileCtrl'
      }).
      when('/referalfriend.html', {
        templateUrl: '/resources/templates/referafriend.html',
        controller: 'referalFriendCtrl'
      }).
      when('/report.html', {
        templateUrl: '/resources/templates/report.html',
        controller: 'mainPageCtrl'
      }).
      otherwise({
        redirectTo: '/login.html'
      });
  }]);



