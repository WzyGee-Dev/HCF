<?php

namespace hcf\discord;

use libs\discord\{
  Message, Webhook, Embed
};

class Logger 
{
  
  public $webhook;
  
  public function __construct(string $url)
  {
    $this->webhook = new Webhook($url);
  }
  
  public function sendEmbed(string $title, string $description, string $type = "normal", array $options = []): void
  {
    $message = new Message();
    $embed = new Embed();
    switch (strtolower($type)) {
      case "normal":
        $embed->setTitle($title);
        $embed->setDescription($description);
        if (!empty(($color = $options["color"]))) {
          $embed->setColor($color);
        }
        if (!empty(($author = $options["author"]))) {
          $embed->setAuthor($author["name"], $author["url"], $author["icon"] ?? null);
        }
        if (!empty(($image = $options["image"]))) {
          $embed->setImage($image);
        }
      break;
      case "field":
        $embed->setTitle($title);
        $embed->setDescription($description);
        if (!empty(($thumbnail = $options["thumbnail"]))) {
          $embed->setThumbnail($thumbnail);
        }
        if (!empty(($author = $options["author"]))) {
          $embed->setAuthor($author["name"], $author["url"], $author["icon"] ?? null);
        }
        if (!empty(($image = $options["image"]))) {
          $embed->setImage($image);
        }
        if (!empty(($footer = $options["footer"]))) {
          $embed->setFooter($footer["text"], $footer["icon"] ?? null);
        }
      $fields = $options["fields"];
      foreach($fields as $field) { 
      $embed->addField($field["name"], $field["value"], $field["inline"] ?? false);
      }
      break;
    }
    $message->addEmbed($embed);
    $this->webhook->send($message);
  }
  
  public function sendMessage(string $username, string $avtarUrl = null, string $description): void
  {
    if ($this->webhook->isValid()) {
    $message = new Message();
    $message->setUsername($username);
    if (isset($avatarUrl)) {
      $message->setAvatarURL($avatarUrl);
    }
    $message->setContent($description);
    }
    $this->webhook->send($message);
  }
  
}
