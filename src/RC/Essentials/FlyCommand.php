<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 8/11/2017
 * Time: 8:02 PM
 */
namespace RC\Essentials;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat as C;
use pocketmine\Player;
use pocketmine\utils\Config;
use RC\Main;
class FlyCommand extends PluginIdentifiableCommand{
    /** @var  Main $plugin */
    private $plugin;
    private $fly = array();
    public $prefix = C::GOLD . "BasicCore >> ".C::GRAY;

    public function __construct(Main $plugin){
        parent::__construct("fly", "Fly command");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : bool
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("core.fly")) {
                if (in_array($sender->getName(), $this->fly)) {
                    $sender->setAllowFlight(false);
                    $id = array_search($sender->getName(), $this->fly);
                    unset($this->fly[$id]);
                    $sender->sendMessage($this->prefix . "Flight Disabled!");
                    echo "disable" . var_dump($this->fly);
                    return;
                }
                $this->fly[] = $sender->getName();
                //echo "enabled".var_dump($this->fly);
                $sender->sendMessage($this->prefix . "Flight Enabled!");
                $sender->setAllowFlight(true);
                return;
            }
            $sender->sendMessage($this->prefix . "Do Not have permission for this command");
        }
    }
}