<?php

namespace App\Service;

class QuotesService {
     
   public  $quotes = [
    ['text' => 'Too weird to live. Too rare to die.', 'author' => 'Las Vegas Parano (1972)'],
    ['text' => 'Don\'t take life seriously; anyway, you won\'t get out alive.','author' => 'Bernard Le Bouyer de Fontenelle'],
    ['text' => 'Where are the missiles? Nearby ... where? ...', 'author' => 'Anonymous poet'],
    ['text' => 'Success is falling seven times, rising eight.', 'author' => 'Japanese proverb']
];

     public function __construct()
     {
        shuffle($this->quotes);
     }
   
}