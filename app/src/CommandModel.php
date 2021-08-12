<?php

namespace App\src;

require_once "vendor/autoload.php";
use App\src;

class CommandModel extends Command
{    
    protected $path = __DIR__."/../../project/";
    protected $nameClass= "Models";
    
    public function start()
    {
        switch ($this->line) {
            case 'create':
                print $this->createFile($this->nameFile);
                break;
        }
    }
}
