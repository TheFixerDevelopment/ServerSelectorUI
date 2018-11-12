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
		$this->saveDefaultConfig();
	    $this->registerEvents();
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null){
			$this->getServer()->getPluginManager()->disablePlugin($this);			
		}
    }
    public function onDamageDisable(EntityDamageEvent $event){
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
            if($this->getConfig()->get("disable-damage") === true){
            $event->setCancelled(true); //To-Do see if this is correct
        }
    }
    }
  public function onPlaceDisable(BlockPlaceEvent $event) {
       if($this->getConfig()->get("disable-placing") === true){
        $event->setCancelled(true); //To-Do see if this is correct
    }
  }
    public function onBreakDisable(BlockBreakEvent $event) {
         if($this->getConfig()->get("disable-breaking") === true){
		$event->setCancelled(true); //To-Do see if this is correct
    }
    }
    public function HungerDisable(PlayerExhaustEvent $event) {
         if($this->getConfig()->get("disable-hunger") === true){
        $event->setCancelled(true); //To-Do see if this is correct
    }
    }
    public function DropItemDisable(PlayerDropItemEvent $event){
         if($this->getConfig()->get("disable-dropitem") === true){
        $event->setCancelled(true); //To-Do see if this is correct
    }
    }
    public function onConsumeDisable(PlayerItemConsumeEvent $event){
         if($this->getConfig()->get("disable-itemconsume") === true){
        $event->setCancelled(true); //To-Do see if this is correct
    }
    }
    public function onDamageEnable(EntityDamageEvent $event){
        if($event->getCause() === EntityDamageEvent::CAUSE_FALL){
		$player = $event->getPlayer();
            if($this->getConfig()->get("disable-damage") === false){
            }
        if($player->isSurvival() === true){
            $event->setCancelled(false); //To-Do see if this is correct
        }
    }
    }
  public function onPlaceEnable(BlockPlaceEvent $event) {
       if($this->getConfig()->get("disable-placing") === false){
        $event->setCancelled(false); //To-Do see if this is correct
    }
  }
    public function onBreakEnable(BlockBreakEvent $event) {
         if($this->getConfig()->get("disable-breaking") === false){
		$event->setCancelled(false); //To-Do see if this is correct
    }
    }
    public function HungerEnable(PlayerExhaustEvent $event) {
         if($this->getConfig()->get("disable-hunger") === false){
        $event->setCancelled(false); //To-Do see if this is correct
    }
    }
    public function DropItemEnable(PlayerDropItemEvent $event){
         if($this->getConfig()->get("disable-dropitem") === false){
        $event->setCancelled(false); //To-Do see if this is correct
    }
    }
    public function onConsumeEnable(PlayerItemConsumeEvent $event){
         if($this->getConfig()->get("disable-itemconsume") === false){
        $event->setCancelled(false); //To-Do see if this is correct
    }
    }
    public function onJoin(PlayerJoinEvent $event){
	    $player = $event->getPlayer();
	     $player->getInventory()->setItem($this->getConfig()->get("join-slot"), Item::get($this->getConfig()->get("server-selector-itemid", 0, 1)->setCustomName($this->getConfig()->get("server-selector-name"))));
    }
    public function onInteract(PlayerInteractEvent $event){
	   $player = $event->getPlayer();
	    $item = $player->getInventory()->getItemInHand();
	    if($item->getCustomName() == $this->getConfig()->get("server-selector-name")){
		$api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
					$form = $api->createSimpleForm(function (Player $sender, $data){
					 $result = $data;
					if($result != null) {
					}
						switch($result){
							case 0:
							        $form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip1 = $this->getConfig()->get("ip1");
								$command = "transferserver $ip1";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
							break;
								
							case 1:
									$form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip2 = $this->getConfig()->get("ip2");
								$command = "transferserver $ip2";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
						        break;
							case 2:
								$form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip2 = $this->getConfig()->get("ip2");
								$command = "transferserver $ip2";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
							break;
              
								
						}
					});
					$form->setTitle($this->getConfig()->get("server-selector-title"));
					$form->setContent($this->getConfig()->get("server-selector-content"));
					$form->addButton($this->getConfig()->get("server-1"), 0);
					$form->addButton($this->getConfig()->get("server-2"), 1);
					$form->addButton($this->getConfig()->get("server-3"), 2);
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
							    $form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip1 = $this->getConfig()->get("ip1");
								$command = "transferserver $ip1";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
							break;
							case 1:
									$form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip2 = $this->getConfig()->get("ip2");
								$command = "transferserver $ip2";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
						        break;
							case 2:
								$form->setTitle($this->getConfig()->get("server-status"));
							        $form->addButton($this->getConfig()->get("server-loading"));
									$ip2 = $this->getConfig()->get("ip2");
								$command = "transferserver $ip2";
								$this->getServer()->getCommandMap()->dispatch($sender, $command);
								$form->setTitle($this->getConfig()->get("server-errortitle"));
								$form->addButton($this->getConfig()->get("server-error"));
							break;
              
								
						}
					});
					$form->setTitle($this->getConfig()->get("server-selector-title"));
					$form->setContent($this->getConfig()->get("server-selector-content"));
					$form->addButton($this->getConfig()->get("server-1"), 0);
					$form->addButton($this->getConfig()->get("server-2"), 1);
					$form->addButton($this->getConfig()->get("server-3"), 2);
					$form->sendToPlayer($player);
				}
				else{
					$sender->sendMessage($this->getConfig()->get("console-message"));
					return true;
				}
			break;
		}
		return true;
    }
}
