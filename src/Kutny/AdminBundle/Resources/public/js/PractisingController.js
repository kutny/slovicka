function PractisingController($scope, $http) {

	$scope.setDefaultState = function() {
		$scope.noteShown = false;
		$scope.userTranslationShown = false;
		$scope.responseButtonsShown = true;
		$scope.showNextButtonsShown = false;
		$scope.sendingRequest = false;
	};

	$scope.loadVocabulary = function() {
		var apiEndpointUrl = apiBaseUrl + '/v1/practise/get-vocabulary';

		$scope.sendRequest(apiEndpointUrl, 'GET', {});
	};

	$scope.storeAnswer = function(answeredCorrectly) {
		var apiEndpointUrl = apiBaseUrl + '/v1/practise/answer/' + $scope.userVocabularyId;
		var data = {answeredCorrectly: (answeredCorrectly ? 1 : 0)};

		$scope.sendRequest(apiEndpointUrl, 'POST', data);
	};

	$scope.sendRequest = function(apiEndpointUrl, method, data) {
		$scope.sendingRequest = true;

		if ($scope.englishVocabulary) {
			$scope.userTran = 'Correct: ' + $scope.userTranslation;
		}

		$http({'method': method, url: apiEndpointUrl, data: data})
			.success(function(data) {
				$scope.userVocabularyId = data.userVocabularyId;
				$scope.englishVocabulary = data.englishVocabulary;
				$scope.userTranslation = data.userTranslation;
				$scope.explanation = data.explanation;
				$scope.note = data.note;

				$scope.setDefaultState();
			})
			.error(function() {
				$scope.setDefaultState();
			})
	};

	$scope.notSure = function() {
		$scope.userTranslationShown = true;
		$scope.responseButtonsShown = false;
		$scope.showNextButtonsShown = true;
	};

	$scope.iKnow = function() {
		$scope.userTranslationShown = true;
		$scope.responseButtonsShown = false;

		$scope.storeAnswer(true);
	};

	$scope.showNext = function() {
		$scope.userTranslationShown = true;

		$scope.storeAnswer(false);
	};

	$scope.showHint = function() {
		$scope.noteShown = true;
	};

	$scope.setDefaultState();
	$scope.loadVocabulary();

}
