<?php

declare(strict_types=1);

namespace Heisenburger69\BurgerTimezones;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase
{

    /** @var Main */
    private static $instance;

    public function onEnable()
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("BurgerTimezones", new CurrentTimeCommand("currenttime", "See the current time with respect to different timezones", "Do /currenttime", ["servertime", "ct"]));
    }

    public static function getInstance(): Main
    {
        return self::$instance;
    }
}
