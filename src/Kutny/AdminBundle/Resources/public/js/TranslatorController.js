function TranslatorController($scope, $http, $location, $anchorScroll) {

	$scope.findVocabulary = function() {
		var apiEndpointUrl = apiBaseUrl + '/v1/translate?vocabulary=' + $scope.vocabulary;

		$scope.sendingRequest = true;

		$http.post(apiEndpointUrl)
			.success(function(data, status, headers, config) {
				$scope.translations = data.translations;
				$scope.userVocabularyId = data.userVocabularyId;
				$scope.userTranslation = data.userTranslation;
				$scope.explanation = data.explanation;
				$scope.note = data.note;

				$scope.sendingRequest = false;
			})
			.error(function(data, status, headers, config) {
				$scope.sendingRequest = false;
			});
	};

	$scope.prefillTranslation = function($event) {
		$scope.userTranslation = event.target.firstChild.nodeValue;
		$location.hash('saveVocabulary');

		$anchorScroll();
	};

	$scope.saveVocabulary = function() {
		var apiEndpointUrl;

		var data = {
			userTranslation: $scope.userTranslation,
			note: $scope.note
		};

		if ($scope.userVocabularyId) {
			apiEndpointUrl = apiBaseUrl + '/v1/user-vocabulary/' + $scope.userVocabularyId;
		}
		else {
			apiEndpointUrl = apiBaseUrl + '/v1/user-vocabulary';
			data['englishVocabulary'] = $scope.vocabulary;
		}

		$scope.sendingRequest = true;

		$http({'method': 'POST', url: apiEndpointUrl, data: data})
			.success(function(data, status, headers, config) {
				if (data.recordId) {
					$scope.userVocabularyId = data.recordId;
				}

				$scope.sendingRequest = false;
			})
			.error(function(data, status, headers, config) {
				$scope.sendingRequest = false;
			});
	};

}

