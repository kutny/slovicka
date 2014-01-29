function PractisingController($scope, $http) {

	$scope.noteShown = false;
	$scope.nextButtonLabel = 'Show next';

	$scope.loadVocabulary = function() {
		var apiEndpointUrl = apiBaseUrl + '/v1/practise/get-vocabulary';

		$scope.sendingRequest = true;

		if ($scope.englishVocabulary) {
			$scope.nextButtonLabel = 'Correct: ' + $scope.userTranslation;
		}

		$http.get(apiEndpointUrl)
			.success(function(data) {
				$scope.englishVocabulary = data.englishVocabulary;
				$scope.userTranslation = data.userTranslation;
				$scope.explanation = data.explanation;
				$scope.note = data.note;

				$scope.sendingRequest = false;
				$scope.noteShown = false;
				$scope.nextButtonLabel = 'Show next';
			})
			.error(function() {
				$scope.sendingRequest = false;
				$scope.noteShown = false;
				$scope.nextButtonLabel = 'Show next';
			})
	};

	$scope.showHint = function() {
		$scope.noteShown = true;
	};

	$scope.loadVocabulary();

}
