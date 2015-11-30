module.exports = function($http) {
  return {
    find: function(term, func) {
      $http.get(window.urlRoot + '/search?term=' + term).success(func);
    }
  };
};
