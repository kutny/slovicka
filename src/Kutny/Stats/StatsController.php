<?php

namespace Kutny\Stats;

use Kutny\User\CurrentUserGetter;
use Kutny\User\User;
use KutnyLib\DateTime\Date;
use KutnyLib\Templating\FillLayout;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StatsController {

	private $currentUserGetter;
	private $statsFacade;
	private $chartConfigurationCreator;

	public function __construct(CurrentUserGetter $currentUserGetter, StatsFacade $statsFacade, ChartConfigurationCreator $chartConfigurationCreator) {
		$this->currentUserGetter = $currentUserGetter;
		$this->statsFacade = $statsFacade;
		$this->chartConfigurationCreator = $chartConfigurationCreator;
	}

	/**
	 * @Route("/stats", name="route.stats")
	 * @FillLayout(service="templating.layout_filler")
	 * @Template("@KutnyAdmin/Stats/stats.html.twig")
	 */
	public function statsAction() {
		$dayInterval = 7;

		$currentUser = $this->currentUserGetter->getUserEntity();
		$startDateTimestamp = strtotime('-' . $dayInterval . ' DAYS');
		$startDate = new Date(
			date('Y', $startDateTimestamp),
			date('m', $startDateTimestamp),
			date('d', $startDateTimestamp)
		);

		return [
			'chartNew' => $this->createNewChartConfiguration($currentUser, $startDate, $dayInterval),
			'chartCumulative' => $this->createCumulativeChartConfiguration($currentUser, $startDate, $dayInterval),
		];
	}

	private function createNewChartConfiguration(User $currentUser, $startDate, $dayInterval) {
		$addedVocabularyData = $this->statsFacade->getAddedVocabularyByDay($currentUser, $startDate, $dayInterval);
		$learnedVocabularyData = $this->statsFacade->getLearnedVocabularyByDay($currentUser, $startDate, $dayInterval);

		return $this->chartConfigurationCreator->createConfiguration($addedVocabularyData, $learnedVocabularyData, $startDate, 'chartNew');
	}

	private function createCumulativeChartConfiguration(User $currentUser, $startDate, $dayInterval) {
		$addedVocabularyData = $this->statsFacade->getAddedVocabularyByDayCumulative($currentUser, $startDate, $dayInterval);
		$learnedVocabularyData = $this->statsFacade->getLearnedVocabularyByDayCumulative($currentUser, $startDate, $dayInterval);

		return $this->chartConfigurationCreator->createConfiguration($addedVocabularyData, $learnedVocabularyData, $startDate, 'chartCumulative');
	}

}
