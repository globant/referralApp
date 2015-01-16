var referralController = angular.module('referralController',[]);

referralController.controller('mainPageCtrl',['$scope', '$routeParams','$http',
  function($scope, $routeParams,$http) {
    $('#carousel').carousel({interval: 10000});
    $('.carousel-control').on('click',function(e){e.preventDefault()})
    
    $http.get('/api/positions').success(function(data) {
        //console.log(data);//this is not bringing the data
        $scope.posName = "Most recent positions";
        $scope.positionList = data;
    });
    
    $http.get('/api/positions?isHot=1').success(function(data) {
        //console.log(data);//this is not bringing the data
      $scope.hotPosName = "hot positions - extra points!";
      $scope.hotPositionList = data;
    });
    
  }]);

referralController.controller('myProfileCtrl',['$scope', '$routeParams','$http',
  function($scope, $routeParams,$http) {
    $scope.name = "My Refersasfdsadf ";
}]);

referralController.controller('referalFriendCtrl',['$scope', '$routeParams','$http',
  function($scope, $routeParams,$http) {
    $scope.name = "My Refers";
}]);

referralController.controller('myProfildeCtrl',['$scope', '$routeParams','$http',
  function($scope, $routeParams,$http) {
    $scope.name = "My Refers";
}]);



















/*referralController.controller('mainPageCtrl',['$scope', '$http', 
    function ($scope, $http) {
        $scope.name = "Most recent positions";
        $http.get('/api/positions').success(function(data) {
            //console.log(data);//this is not bringing the data
            $scope.positionList = data;
        });
    }]
);*/

/*
referralController.controller('HotPositionsCtrl', function ($scope, $http) {
    $scope.name = "hot positions - extra points!";
    $http.get('/api/positions?isHot=1').success(function(data) {

        $scope.hotPositionList = data;
    });
});*/

/*      when('/phones/:phoneId', {
        templateUrl: 'partials/phone-detail.html',
        controller: 'PhoneDetailCtrl'
      }).
referralApp.controller('CocoonCtrl', function ($scope) {
    $scope.name = "Cocoon";
    $scope.pepitas = [
        {'name': 'fsadfsad',
         'snippet': 'fksalnmklnsd.'},
        {'name': 'Motorola ',
         'snippet': ' Next Generation tablet.'},
        {'name': 'fsafsda',
         'snippet': 'The Next, Next Generation tablet.'}
    ];
});
*/