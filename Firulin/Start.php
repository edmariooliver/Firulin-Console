<?php

require_once("CommandModel.php");
require_once("CommandController.php");

use Firulin\CommandModel;
use Firulin\CommandController;
use Firulin\Command;

function startCommand($command)
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
        
        case 'project':
            $command->createProject();
            break;

        default:
            $command->messageError("Comando não encontrado!");
            break;
    }
}
