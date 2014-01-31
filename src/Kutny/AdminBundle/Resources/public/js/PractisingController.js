function PractisingController($scope, $http, $window) {

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
				if (!data.userVocabularyId) {
					alert('No more vocabulary for today\'s practising, add some more!');
					$window.location = '/translator';
				}

				if ($scope.getRandomArbitrary(1, 4) > 2) {
					$scope.userVocabularyId = data.userVocabularyId;
					$scope.englishVocabulary = data.englishVocabulary;
					$scope.userTranslation = data.userTranslation;
					$scope.explanation = data.explanation;
					$scope.note = data.note;
				}
				else {
					$scope.userVocabularyId = data.userVocabularyId;
					$scope.englishVocabulary = data.userTranslation;
					$scope.userTranslation = data.englishVocabulary;
					$scope.explanation = data.explanation;
					$scope.note = null;
				}

				$scope.setDefaultState();
			})
			.error(function() {
				$scope.setDefaultState();
			})
	};

	$scope.getRandomArbitrary = function(min, max) {
		return Math.random() * (max - min) + min;
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
