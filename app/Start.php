<?php

//Control file
require_once "vendor/autoload.php";

use App\src\CommandModel;
use App\src\CommandController;
use App\src\Command;

function startCommand($command)
{
    //Função que recebe e roda os comandos
    if(isset($command[1]))
    {
        $cmd["action"] = explode(":", $command[1])[1];
        $cmd["request"] = explode(":", $command[1])[0];
        $cmd["name"] = $command[2];
        
        $command = new Command($cmd);
        $cmdModel = new CommandModel($cmd);
        $cmdController = new CommandController($cmd);
        
        switch ($cmd['request']) {
            case 'model':
                $cmdModel->start();
                break;

            case 'controller':
                $cmdController->start();
                break;

            default:
                $command->start("Comando não encontrado!");
                break;
            }
        }   
    else{
        $command = new Command($command);
        $command->presents();
    }
}
