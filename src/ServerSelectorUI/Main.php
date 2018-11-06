<?php

namespace ServerSelectorUI;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\{PlayerJoinEvent, PlayerInteractEvent, PlayerExhaustEvent, PlayerDropItemEvent, PlayerItemConsumeEvent};
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {
    public function registerEvents(): void {
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onEnable() : void {
	    $this->registerEvents();
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getServer()->getPluginManager()->disablePlugin($this);			
		}
    }
    public function onDamageDisable(EntityDamageEvent $event){
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            $event->setCancelled(true);
        }
    }
  public function onPlaceDisable(BlockPlaceEvent $event) {
        $event->setCancelled(true);
    }
    public function onBreakDisable(BlockBreakEvent $event) {
		$event->setCancelled(true);
    }
    public function HungerDisable(PlayerExhaustEvent $event) {
        $event->setCancelled(true);
    }
    public function DropItemDisable(PlayerDropItemEvent $event){
        $event->setCancelled(true);
    }
    public function onConsumeDisable(PlayerItemConsumeEvent $event){
        $event->setCancelled(true);
    }
    public function onJoin(PlayerJoinEvent $event){
	    $player = $event->getPlayer();
	     $player->getInventory()->setItem(2, Item::get(345)->setCustomName("§a§lServer Selector"));
    }
    public function onInteract(PlayerInteractEvent $event){
	   $player = $event->getPlayer();
	    $item = $event->getItem();
	    if($item->getCustomName() == "§a§lServer Selector"){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $player, $data){
					$result = $data[0];
					
					if($result === null){
						return true;
					}
						switch($result){
							case 0:
								$command = "transferserver factions.voidminerpe.ml 25655";
								$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
								
							case 1:
								$command = "transferserver factions2.voidminerpe.ml 25584";
								$this->getServer()->getCommandMap()->dispatch($player, $command);
						        break;
							
							case 2:
								$player->sendMessage(TextFormat::RED . "Coming soon");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
              
								
						}
					});
					$form->setTitle("§a§lServer Selector!");
					$form->setContent("§bPlease choose a server to teleport to!");
					$form->addButton(TextFormat::BOLD . "§3OP §bFactions\n§a§lONLINE");
					$form->addButton(TextFormat::BOLD . "§3Normal §bFactions\n§a§lONLINE");
					$form->addButton(TextFormat::BOLD . "§5Prisons\n§c§lComing Soon");
					$form->sendToPlayer($player);
	    }
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		switch($cmd->getName()){
			case "servers":
				if($sender instanceof Player) {
					$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, array $data){
					$result = $data[0];
					
					if($result === null){
						return true;
					}
						switch($result){
							case 0:
								$command = "transferserver voidprisonspe.ml 25647";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
							break;
								
							case 1:
								$command = "transferserver voidfactionspe.ml 19132";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
						        break;
							
							case 2:
								$command = "transferserver voidkitpvppe.ml 25625";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
							break;
              
								
						}
					});
					$form->setTitle("§a§lServer Selector!");
					$form->setContent("§bPlease choose a server to teleport to!");
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bPrisons§cPE (§dTap Me!)");
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bFactions§cPE (§dTap Me!)");
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bKitPvP§cPE (§dTap me!)");
					$form->sendToPlayer($sender);
				}
				else{
					$sender->sendMessage(TextFormat::RED . "Use this Command in-game.");
					return true;
				}
			break;
		}
		return true;
    }
}
