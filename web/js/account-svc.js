var accountServices = angular.module('accountServices', ['ngResource']);

accountServices.factory('Login', ['$resource','API',
  function ($resource, API) {
      return $resource(API.URL+API.VERSION+ '/account/login?usr=:usr&pwd=:pwd', {}, {
          query: { method: 'GET', params: { usr: 'username', pwd: 'password' }, isArray: true }
      });
  }]);

accountServices.factory('User', ['$resource', 'API',
  function ($resource, API) {
      return $resource(API.URL + API.VERSION + '/user', {}, {
          query: { method: 'POST', params: { usr: 'username', pwd: 'password' }, isArray: true }
      });
  }]);