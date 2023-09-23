<?php

class AdvancedFiniteStateMachine
{
   private $currentState;

   public function __construct()
   {
      $this->currentState = 'Awal';
   }

   public function processInput($input)
   {
      $inputLength = strlen($input);
      for ($i = 0; $i < $inputLength; $i++) {
         $this->transition($input[$i]);
      }
   }

   private function transition($inputChar)
   {
      switch ($this->currentState) {
         case 'Awal':
            if ($inputChar === 'a') {
               $this->currentState = 'A';
            }
            break;
         case 'A':
            if ($inputChar === 'b') {
               $this->currentState = 'AB';
            } elseif ($inputChar !== 'a') {
               $this->currentState = 'Awal';
            }
            break;
         case 'AB':
            if ($inputChar === 'c') {
               $this->currentState = 'Akhir';
               echo "Pola 'abc' ditemukan.\n";
            } elseif ($inputChar === 'a') {
               $this->currentState = 'A';
            } else {
               $this->currentState = 'Awal';
            }
            break;
         case 'Akhir':
            break;
         default:
            echo "Keadaan tidak valid\n";
      }
   }
}

$AFSM = new AdvancedFiniteStateMachine();
$AFSM->processInput('abcaabcabcbabc');

?>