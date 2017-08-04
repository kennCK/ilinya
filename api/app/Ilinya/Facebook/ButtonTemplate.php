<?php

namespace App\Ilinya\Facebook; 

class ButtonTemplate{

  public static function toArray($text, $buttons){
    
    $resultButtons = [];
    foreach ($buttons as $button) {
      $resultButtons[] = $button instanceof ButtonElement? $button->toArray(): $button;
    }

    $response =  [
      "attachment"  => [
        "type"      => 'template',
        "payload"   =>  [
          "template_type" => "button",
          "text"          => $text,
          "buttons"       => $resultButtons
        ]
      ]
    ];

    echo json_encode($response);
    return $response;
  }

}
