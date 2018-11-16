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
    public function onEnable(): void {
	    $this->registerEvents();
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getLogger()->info("FormAPI plugin is required to run this plugin. Without this, this plugin cannot begin to enable. Plugin has been disabled.");
			$this->getLogger()->info("We only support this download link here: https://poggit.pmmp.io/r/34221/FormAPI_dev-5.phar - We may support the latest in the future.");
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return;
		}
	    if($this->getServer()->getPluginManager()->getPlugin("FormAPI")) {
	       $this->getLogger()->info("FormAPI plugin has been found! This plugin shall begin enabling!");
	       return;
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
	     $player->getInventory()->setItem(2, Item::get(345)->setCustomName(TextFormat::GREEN . TextFormat::BOLD . "Server Selector"));
    }
    public function onInteract(PlayerInteractEvent $event){
	   $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    if($item->getCustomName() == TextFormat::GREEN . TextFormat::BOLD . "Server Selector"){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					 $result = $data;
					if($result != null) {
					}
						switch($result){
							case 0:
							     $sender->sendMessage(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the server..");
								$command = "transferserver factions.voidminerpe.ml 25655";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$sender->sendMessage(TextFormat::RED . "Something went wrong - Contact server administrators if this was a mistake.");
							break;
								
							case 1:
							    $sender->sendMessage(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the server..");
								$command = "transferserver factions2.voidminerpe.ml 25584";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$sender->sendMessage(TextFormat::RED . "Something went wrong - Contact server administrators if this was a mistake.");
						        break;
							
							case 2:
								$sender->sendMessage(TextFormat::RED . "Coming soon");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
							
							case 3:
								$sender->sendMessage(TextFormat::RED . "You have closed the Server selector!");
							break;
						}
					});
					$form->setTitle(TextFormat::GREEN . TextFormat::BOLD . "Server Selector!");
					$form->setContent(TextFormat::AQUA . TextFormat::BOLD . "Please choose a server to teleport to!");
					$form->addButton(TextFormat::DARK_AQUA . "OP" . TextFormat::AQUA . "Factions\n" . TextFormat::GREEN . TextFormat::BOLD . "ONLINE", 0);
					$form->addButton(TextFormat::DARK_AQUA . "Normal " . TextFormat::AQUA . "Factions\n" . TextFormat::GREEN . TextFormat::BOLD . "ONLINE", 1);
					$form->addButton(TextFormat::DARK_PURPLE . "Prisons\n" . TextFormat::RED . TextFormat::BOLD . "OFFLINE", 2);
		    			$form->addButton(TextFormat::RED . TextFormat::BOLD . "EXIT", 3);
					$form->sendToPlayer($player);
	    }
	}
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
		switch($cmd->getName()){
			case "servers":
				if($sender instanceof Player) {
					$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					 $result = $data;
					if($result != null) {
					}
						switch($result){
							case 0:
							    $sender->sendMessage(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the server..");
								$command = "transferserver factions.voidminerpe.ml 25655";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$sender->sendMessage(TextFormat::RED . "Something went wrong - Contact server administrators if this was a mistake.");
							break;
								
							case 1:
							    $sender->sendMessage(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the server..");
								$command = "transferserver factions2.voidminerpe.ml 25584";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$sender->sendMessage(TextFormat::RED . "Something went wrong - Contact server administrators if this was a mistake.");
						        break;
							
							case 2:
								$sender->sendMessage(TextFormat::RED . "Coming soon");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
							
							case 3:
								$sender->sendMessage(TextFormat::RED . "You have closed the Server selector!");
							break;
						}
					});
					$form->setTitle(TextFormat::GREEN . TextFormat::BOLD . "Server Selector!");
					$form->setContent(TextFormat::AQUA . TextFormat::BOLD . "Please choose a server to teleport to!");
					$form->addButton(TextFormat::DARK_AQUA . "OP " . TextFormat::AQUA . "Factions\n" . TextFormat::GREEN . TextFormat::BOLD . "ONLINE", 0);
					$form->addButton(TextFormat::DARK_AQUA . "Normal " . TextFormat::AQUA . "Factions\n" . TextFormat::GREEN . TextFormat::BOLD . "ONLINE", 1);
					$form->addButton(TextFormat::DARK_PURPLE . "Prisons\n" . TextFormat::RED . TextFormat::BOLD . "OFFLINE", 2);
					$form->addButton(TextFormat::RED . TextFormat::BOLD . "EXIT", 3);
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
