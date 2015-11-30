module.exports = function ($scope, SearchRepo) {
  
  $scope.change = function () {
    if($scope.term.length > 2) {
      SearchRepo.find($scope.term, function(results) {
        $scope.search = results;
      });
    } else if (0 === $scope.term.length) {
      $scope.search = [];
    }
  };
};
