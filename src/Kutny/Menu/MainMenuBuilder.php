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
		$menu->setChildrenAttribute('class', 'nav navbar-nav');

		$menu->addChild('Translator', ['route' => 'route.translator']);
		$menu->addChild('Practising', ['route' => 'route.practising']);
		$menu->addChild('Stats', ['route' => 'route.stats']);

		return $menu;
	}

}
