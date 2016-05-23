var accountControllers = angular.module('accountControllers', []);

accountControllers.controller('LoginCtrl', ['$scope', '$routeParams', 'Login', function ($scope, $routeParams, Login) {

    $scope.login = function(){
    $scope.user = Login.get({ usr: 'agos83@gmail.com', pwd: 'prova2' }, function (data) {
        $scope.user = data;
    });}

}]);


accountControllers.controller('UserController', ['$scope', '$routeParams', 'User', function ($scope, $routeParams, User) {
    $scope.register = function() {
        $scope.user = User.save({ usr: 'agos83@gmail.com', pwd: 'prova2' }, function (data) {
            $scope.user = data;
        });
    }

}]);