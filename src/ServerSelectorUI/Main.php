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
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\item\Item;

class Main extends PluginBase implements Listener {
    public function registerEvents(): void {
	    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    protected function onEnable(): void {
	    $this->registerEvents();
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getServer()->getPluginManager()->disablePlugin($this);			
		}
    }
    public function onDamageDisable(EntityDamageEvent $event): void {
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            $event->setCancelled(true); //To-Do - Make this configurable
        }
    }
  public function onPlaceDisable(BlockPlaceEvent $event): void {
        $event->setCancelled(true); //To-Do - Make this configurable
    }
    public function onBreakDisable(BlockBreakEvent $event): void {
		$event->setCancelled(true); //To-Do - Make this configurable
    }
    public function HungerDisable(PlayerExhaustEvent $event): void {
        $event->setCancelled(true); //To-Do - Make this configurable
    }
    public function DropItemDisable(PlayerDropItemEvent $event): void {
        $event->setCancelled(true); //To-Do - Make this configurable
    }
    public function onConsumeDisable(PlayerItemConsumeEvent $event): void {
        $event->setCancelled(true); //To-Do - Make this configurable
    }
    public function onJoin(PlayerJoinEvent $event): void {
	    $player = $event->getPlayer();
	     $player->getInventory()->setItem(2, Item::get(345)->setCustomName("§a§lServer Selector"));
    }
    public function onInteract(PlayerInteractEvent $event): void {
	   $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    if($item->getCustomName() == "§a§lServer Selector"){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					 $result = $data;
					if($result != null) {
					}
						switch($result){
							case 0:
							        $form->setTitle("§a§lSERVER ONLINE");
							        $form->addButton(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the OP Factions server..");
								$command = "transferserver factions.voidminerpe.ml 25655";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle("§c§lServer error");
								$form->addButton("§cSomething went wrong - Contact server administrators if this was a mistake.");
							break;
								
							case 1:
							    $form->setTitle("§a§lSERVER ONLINE");
							    $form->addButton(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the Factions server..");
								$command = "transferserver factions2.voidminerpe.ml 25584";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle("§c§lServer error");
								$form->addButton("§cSomething went wrong - Contact server administrators if this was a mistake.");
						        break;
							
							case 2:
								$form->setTitle("§cServer unavailable!");
								$form->addButton("§cThis server is currently unavailable or offline! Please retry later!");
								$form->addButton("§c§lEXIT");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
              
								
						}
					});
					$form->setTitle("§a§lServer Selector!");
					$form->setContent("§bPlease choose a server to teleport to!");
					$form->addButton(TextFormat::BOLD . "§3OP §bFactions\n§a§lONLINE", 0);
					$form->addButton(TextFormat::BOLD . "§3Normal §bFactions\n§a§lONLINE", 1);
					$form->addButton(TextFormat::BOLD . "§5Prisons\n§c§lOFFLINE", 2);
					$form->sendToPlayer($player);
	    }
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		switch($command->getName()){
			case "servers":
				if($sender instanceof Player) {
					$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					 $result = $data;
					if($result != null) {
					}
						switch($result){
							case 0:
							    $form->setTitle("§a§lSERVER ONLINE");
							        $form->addButton(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the OP Factions server..");
								$command = "transferserver factions.voidminerpe.ml 25655";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle("§c§lServer error");
								$form->addButton("§cSomething went wrong - Contact server administrators if this was a mistake.");
							break;
								
							case 1:
							    $form->setTitle("§a§lSERVER ONLINE");
							        $form->addButton(TextFormat::DARK_PURPLE . "Please wait whilst we transferred you to the Factions server..");
								$command = "transferserver factions2.voidminerpe.ml 25584";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle("§c§lServer error");
								$form->addButton("§cSomething went wrong - Contact server administrators if this was a mistake.");
						        break;
							
							case 2:
								$form->setTitle("§cServer unavailable!");
								$form->addButton("§cThis server is currently unavailable or offline! Please retry later!");
								$form->addButton("§c§lEXIT");
								//$command = "";
								//$this->getServer()->getCommandMap()->dispatch($player, $command);
							break;
              
								
						}
					});
					$form->setTitle("§a§lServer Selector!");
					$form->setContent("§bPlease choose a server to teleport to!");
					$form->addButton(TextFormat::BOLD . "§3OP §bFactions\n§a§lONLINE", 0);
					$form->addButton(TextFormat::BOLD . "§3Normal §bFactions\n§a§lONLINE", 1);
					$form->addButton(TextFormat::BOLD . "§5Prisons\n§c§lOFFLINE", 2);
					$form->sendToPlayer($player);
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
