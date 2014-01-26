<?php

namespace KutnyLib\Yml;

class YmlSorter {

	public function sort($yml) {
		$level = 1;

		if (preg_match('~(([a-z]+ < [a-z]+):)~', $yml)) {
			$level++;
			$sections = preg_split('~(([a-z]+ < [a-z]+):)|(common:)~', $yml);
		}
		else {
			$sections = array($yml);
		}

		foreach ($sections as $section)	{
			$subsection = preg_replace('~(^.*?)(services|parameters|factories):~s', '', $section);
			$parts = preg_split('~\n' . $this->generateSpacesForLevel($level) . '(?=[a-z])~', $subsection);
			sort($parts);
			$subsectionSorted = implode("\n" . $this->generateSpacesForLevel($level), $parts);
			$yml = str_replace($subsection, $subsectionSorted, $yml);
		}

		return $yml;
	}

	private function generateSpacesForLevel($level) {
		return str_repeat(' ', $level * 2);
	}
}
