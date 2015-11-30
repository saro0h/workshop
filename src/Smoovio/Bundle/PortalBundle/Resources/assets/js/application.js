require('../bower/angular/angular');
require('../bower/angular-route/angular-route');

var SearchCtrl = require('./controllers/search')
  , SearchRepo = require('./repositories/search');

var app = angular.module('Smoovio', [])
  // change template interpolation
  .config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
  })

  // register repos
  .factory('SearchRepo', ['$http', SearchRepo])

  // register controllers
  .controller('SearchCtrl', ['$scope', 'SearchRepo', SearchCtrl]);
