<?php

namespace hcf\translation;

use pocketmine\utils\Config;

use hcf\Loader;

use hcf\translation\TranslationException;

class Translation 

{

    /*

    * TODO: Only for version 2.0.0

    private $language;

    

    public function __construct(string $language)

    {

    $this->language = $language;

    }

    

    private $config = new Config(Loader::getInstance()->getDataFolder() . $this->language . DIRECTORY_SEPARATOR . "messages.yml", Config::YAML);

   */ 

    private $config = new Config(Loader::getInstance()->getDataFolder() . "messages.yml", Config::YAML);

    

    /*

    public static function addMessage(string $character, array $args = []): string

    {

      $config = $this->getConfigMessage();

      if (!$config->exists($character)) {

      throw new TranslationException("The message entered does not exist");

      }

      if (empty($args)) {

      $message = $config->get($character);

      } else {

      foreach($args as $arg => $value) {

      $message = str_replace("%$argument%", $value, $config->get($character)); 

        }

      }

    return $message;

    }

    

    public function setMessage(string $character, string $text): void

    {

    $config = $this->getConfigMessage();

    if ($config->exists($character)) {

      throw new TranslationException("The entered message already exists");

    }

    $config->set($character, $text);

    $config->save();

    }

    

    public function deleteMessage(string $character): void

    {

    $config = $this->getConfigMessage();

      if (!$config->exists($character)) {

      throw new TranslationException("The message entered does not exist");

      }

    $config->removeNested($character);

    $config->save();

    }

    */

    public static function addMessage(string $character, array $args): string

    {

    $config = $this->config;

    if (!$config->exists($character)) {

      throw new TranslationException("The message entered does not exist");

    }

    foreach ($args as $argument => $value) {

      $message = str_replace("%$argument%", $value, $config->get($character));

      }

    return (isset($args)) ? $message : $config->get($character);

    }

    

    /**

    * @return Config

    * TODO: Only for 2.0.0 version

    **/

    public function getConfigMessage(): Config

    {

    return $this->config;

    }

}
