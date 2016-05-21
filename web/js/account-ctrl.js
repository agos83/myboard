var accountControllers = angular.module('accountControllers', []);

accountControllers.controller('LoginCtrl', ['$scope', '$http', function ($scope, $http) {
    $http.get('http://localhost/myboard/api/v10/account/login?usr=agos83@gmail.com&pwd=prova2').success(function (data) {
        $scope.user = data;
    });
}]);