<?php

namespace Check;

use FormAPI\CustomForm;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class CheckCommand extends Command
{

	/**
	 * @var Main
	 */
	private $plugin;

	public function __construct(Main $plugin)
	{
		parent::__construct("cek", "Çek Menüsü", "/cek", ["paraceki"]);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if ($sender instanceof Player) {
			$this->mainForm($sender);
		} else {
			$sender->sendMessage("Bu komutu sadece oyunda kullanabilirsin");
		}
	}

	private function mainForm(Player $player)
	{
		$form = new CustomForm(function (Player $player, $data) {
			if ($data === null) return true;
			if (is_numeric($data[1])  && $data[1] > 0) {
				$eco = EconomyAPI::getInstance();
				if ($eco->myMoney($player->getName()) >= $data[1]) {
					$eco->reduceMoney($player, $data[1]);
					$cek = Item::get(339, 5, 1);
					$name = $player->getName();
					$cek->setCustomName("§6" . $data[1] . "TL\n§c$name");
					$cek->setLore([
						"§6$name §fadlı oyuncunun para çeki", $data[1]
					]);
					$player->getInventory()->addItem($cek);
					$player->sendMessage("§8»§fHesabından §c$data[1] TL §fpara çekildi");
					$player->sendMessage("Başarıyla çek oluşturdun");
				} else {
					$player->sendMessage("§8»§cÇek yapmak istediğin miktar kendi paranı aşıyor");
				}
			} else {
				$player->sendMessage("§8»§cLütfen 0'dan büyük ve sayısal bir değer giriniz");
			}
		});
		$form->setTitle("Çek Menüsü");
		$form->addLabel("§8Oluşturmak istediğin çekin miktarını aşağıya yaz");
		$form->addInput("", "Örn: 500");
		$form->sendToPlayer($player);
	}
}