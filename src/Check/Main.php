<?php
namespace Check;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {
	public function onEnable(){
		$this->getLogger()->info("§6Çek Plugini Aktif\n§bGeliştirici Discord: §fGüney#8352");
		$this->loader();
	}

	private function loader(){
		$commandMap = $this->getServer()->getCommandMap();
		$commandMap->register("cek", new CheckCommand($this));

		$pluginManager = $this->getServer()->getPluginManager();
		$pluginManager->registerEvents(new CheckListener(), $this);
	}
}