<?php

use CoolVendor\SomeApi\Factory\AuthenticationProcessFactory;
use CoolVendor\SomeApi\Factory\ApiProcess\ApiProcessFactory;
use CoolVendor\SomeApi\Factory\TicketFactory;

class CoolVendor_SomeApi_IndexController extends Mage_Core_Controller_Front_Action
{
    public function formatOneAction()
    {
        $apiProcessResponse = null;

        $incoming_headers = getallheaders();
        //isset() не возвращает TRUE для ключей массива, указывающих на NULL, а array_key_exists(), к примеру, возвращает
        if ( isset($incoming_headers['SomeApi-birrer']) ) {

            $authenticationProcess = (new AuthenticationProcessFactory)->createProcess();

            if( get_class($authenticationProcess) === 'CoolVendor\SomeApi\Classes\AuthenticationProcess' ) {
                //отправляем биррер для проверки аутентифифкации
                $birrer_toket_inspect = $authenticationProcess->start($incoming_headers['SomeApi-birrer']);
                //если биррер-токен валидный, тогда переходим к дальнейшему выполнению кода
                if($birrer_toket_inspect) {

                    $params = [
                        "version" => $_GET['version'],
                        "command" => $_GET['command'],
                        "limit" => $_GET['limit']
                    ];

                    //создаем фабрику для создания объекта выполенния API процесса
                    $apiProcessFactory = new ApiProcessFactory();

                    if( get_class($apiProcessFactory) === 'CoolVendor\SomeApi\Factory\ApiProcess\ApiProcessFactory' ) {

                        $apiProcessResponse = $apiProcessFactory->create('One', $params);

                        if( $apiProcessResponse ) {
                               header('Content-Type: text/json');
                            echo '<pre>';
                                var_dump( json_decode($apiProcessResponse) );
                            echo '</pre>';
                            return true;
                        }

                    }
                        echo '<h1>Command not execute!</h1>';
                        return false;
                }

            }

        }
            echo '<h1>Not authentication!</h1>';
            return false;     
    }

    public function formatTwoAction()
    {
        $apiProcessResponse = null;

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        if ( isset($obj['samapi-birrer']) ) {

            $authenticationProcess = (new AuthenticationProcessFactory)->createProcess();

            if( get_class($authenticationProcess) === 'CoolVendor\SomeApi\Classes\AuthenticationProcess' ) {
                //отправляем биррер для проверки аутентифифкации
                $birrer_toket_inspect = $authenticationProcess->start($obj['samapi-birrer']);
                //если биррер-токен валидный, тогда переходим к дальнейшему выполнению кода
                if($birrer_toket_inspect) {

                    $params = [
                        "version" => $obj['version'],
                        "command" => $obj['command'],
                        "input" => $obj['input']
                    ];

                    //создаем фабрику для создания объекта выполенния API процесса
                    $apiProcessFactory = new ApiProcessFactory();

                    if( get_class($apiProcessFactory) === 'CoolVendor\SomeApi\Factory\ApiProcess\ApiProcessFactory' ) {

                        $apiProcessResponse = $apiProcessFactory->create('Two', $params);

                        if( $apiProcessResponse ) {
                        	header('Content-Type: text/xml');
                            echo $apiProcessResponse;
                            return true;
                         
                        }

                    }
                      echo '<h1>Command not execute!</h1>';
                        return false;

                }

            }

        }
          echo '<h1>Not authentication!</h1>';
          return false;
    }

    public function sendTicketAction()
    {
        $ticketFactory = new TicketFactory();

        $ticket = $ticketFactory->create();

        if( get_class($ticket) === 'CoolVendor\SomeApi\Classes\Ticket' && $ticket->sendTicket() )
            echo "<h1>Sucsefull send ticket!</h1>";
        else{
            echo "<h1>Not send ticket!</h1>";
        }
    }
}