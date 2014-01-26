<?php

namespace Kutny\Menu;

use Knp\Menu\FactoryInterface;

class MainMenuBuilder {

	private $factory;

	public function __construct(
		FactoryInterface $factory
	) {
		$this->factory = $factory;
	}

	public function createMainMenu() {
		$menu = $this->factory->createItem('root');
		$menu->setChildrenAttribute('class', 'nav nav-justified');

		$menu->addChild('Dashboard', ['route' => 'route.dashboard']);
		$menu->addChild('Vocabulary', ['route' => 'route.vocabulary']);
		$menu->addChild('Settings', ['route' => 'route.settings']);

		return $menu;
	}

}
