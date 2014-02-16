<?php

namespace Kutny\Stats;

use KutnyLib\DateTime\Date;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

class ChartConfigurationCreator {

	public function createConfiguration(array $addedVocabularyData, array $learnedVocabularyData, Date $startDate, $chartId) {
		$series = array(
			array(
				'name' => 'Added vocabulary',
				'data' => $addedVocabularyData,
				'color' => '#5D6FE3',
				'pointStart' => new Expr('Date.UTC(' . $startDate->getYear() . ', ' . $startDate->getMonth() . ', ' . $startDate->getDay() . ')'),
				'pointInterval' => new Expr('24 * 3600 * 1000') // one day
			),
			array(
				'name' => 'Learned vocabulary',
				'data' => $learnedVocabularyData,
				'color' => '#5DB83D',
				'pointStart' => new Expr('Date.UTC(' . $startDate->getYear() . ', ' . $startDate->getMonth() . ', ' . $startDate->getDay() . ')'),
				'pointInterval' => new Expr('24 * 3600 * 1000') // one day
			)
		);

		$ob = new Highchart();
		$ob->chart->renderTo($chartId);
		$ob->title->text('Vocabulary');
		$ob->xAxis->type('datetime');
		$ob->exporting->enabled(false);

		$ob->series($series);

		return $ob;
	}

}
