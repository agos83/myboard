var myboardApp = angular.module('myboardApp', ['ngRoute', 'ngCookies', 'accountControllers', 'accountServices']);

myboardApp.config(['$routeProvider',
  function ($routeProvider) {
      $routeProvider.
      when('/register', {
          templateUrl: 'partials/account/register.html',
          controller: 'UserController'
      }).
        when('/login', {
            templateUrl: 'partials/account/login.html',
            controller: 'LoginCtrl'
        }).
        otherwise({
            redirectTo: '/login'
        });
  }]).constant("API", {
      "URL": "http://localhost/myboard/api/",
      "VERSION": "V10"
  });


