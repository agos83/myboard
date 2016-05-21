var myboardApp = angular.module('myboardApp', ['ngRoute', 'accountControllers']);

myboardApp.config(['$routeProvider',
  function ($routeProvider) {
      $routeProvider.
        when('/login', {
            templateUrl: 'partials/account/login.html',
            controller: 'LoginCtrl'
        }).
        otherwise({
            redirectTo: '/login'
        });
  }]);