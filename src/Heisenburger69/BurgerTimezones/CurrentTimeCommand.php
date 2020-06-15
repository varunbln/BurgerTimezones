<?php

namespace Heisenburger69\BurgerTimezones;

use Exception;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat as C;
use function date;
use function date_default_timezone_set;
use function str_replace;
use function time;
use function timezone_name_from_abbr;

class CurrentTimeCommand extends Command implements PluginIdentifiableCommand
{

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param string[] $args
     * @return void
     * @throws Exception
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): void
    {
        if (!isset($args[0])) {
            $time = date("h:i:s A", time());
            $sender->sendMessage(str_replace("{TIME}", $time, C::colorize(Main::getInstance()->getConfig()->get("default-message"))));
            return;
        }
        $tz = timezone_name_from_abbr($args[0]);
        if ($tz === false) {
            $sender->sendMessage(C::colorize(Main::getInstance()->getConfig()->get("no-timezone-message")));
            return;
        }
        date_default_timezone_set($tz);
        $time = date("h:i:s A", time());
        $sender->sendMessage(str_replace(["{TIME}", "{TIMEZONE}"], [$time, $tz], C::colorize(Main::getInstance()->getConfig()->get("timezone-message"))));
    }

    public function getPlugin(): Plugin
    {
        return Main::getInstance();
    }
}