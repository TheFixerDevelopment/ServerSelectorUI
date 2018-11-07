<?php

namespace ServerSelectorUI;

use pocketmine\{Server, Player};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\{PlayerJoinEvent, PlayerInteractEvent, PlayerExhaustEvent, PlayerDropItemEvent, PlayerItemConsumeEvent};
use pocketmine\utils\TextFormat;
use pocketmine\command\{Command, CommandSender, CommandExecutor, ConsoleCommandSender};
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {
	
    public function registerEvents(): void {
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function onEnable(): void {
	    $this->registerEvents();
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getServer()->getPluginManager()->disablePlugin($this);			
		}
    }
    public function onDamageDisable(EntityDamageEvent $event): void {
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            $event->setCancelled(true);
        }
    }
  public function onPlaceDisable(BlockPlaceEvent $event): void {
        $event->setCancelled(true);
    }
    public function onBreakDisable(BlockBreakEvent $event): void {
		$event->setCancelled(true);
    }
    public function HungerDisable(PlayerExhaustEvent $event): void {
        $event->setCancelled(true);
    }
    public function DropItemDisable(PlayerDropItemEvent $event): void {
        $event->setCancelled(true);
    }
    public function onConsumeDisable(PlayerItemConsumeEvent $event): void {
        $event->setCancelled(true);
    }
    public function onJoin(PlayerJoinEvent $event): void {
	    $player = $event->getPlayer();
	    $this->LoadItems($player);
    }
    public function LoadItems(Player $player): void {
	    $player->getInventory()->clearAll();
	    $player->getInventory()->setItem(2, Item::get(345)->setCustomName("§a§lServer Selector"));
    }
    public function onInteract(PlayerInteractEvent $event) {
	   $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    if($item->getCustomName() == "§a§lServer Selector"){
		                        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					$result = $data;
					
					if($result != null){
						return true;
					}
						switch($result){
							case 0:
								$sender->transfer("factions.voidminerpe.ml", "25655");
							break;
								
							case 1:
								$sender->transfer("factions2.voidminerpe.ml", "25584");
						        break;
							
							case 2:
								$sender->sendMessage(TextFormat::RED . "Coming soon");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
							
							case 3:
								$sender->sendMessage("§cYou have closed the server selector!");
              
								
						}
					});
					$form->setTitle("§a§lServer Selector!");
					$form->setContent("§bPlease choose a server to teleport to!");
					$form->addButton(TextFormat::BOLD . "§3OP §bFactions\n§a§lONLINE", 0);
					$form->addButton(TextFormat::BOLD . "§3Normal §bFactions\n§a§lONLINE", 1);
					$form->addButton(TextFormat::BOLD . "§5Prisons\n§c§lComing Soon", 2);
		                        $form->addButton(TextFormat::BOLD . "§c§lEXIT", 3);
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
					
					if($result != null){
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
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bPrisons§cPE (§dTap Me!)", 0);
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bFactions§cPE (§dTap Me!)", 1);
					$form->addButton(TextFormat::BOLD . "§6§lVoid§bKitPvP§cPE (§dTap me!)", 2);
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
