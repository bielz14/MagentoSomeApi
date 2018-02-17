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

                        if( !$apiProcessResponse ) {
                            echo '<h1>Command not execute!</h1>';
                            return false;
                        }else{
                            header('Content-Type: text/json');
                            echo '<pre>';
                                var_dump( json_decode($apiProcessResponse) );
                            echo '</pre>';
                            return true;
                        }

                    }else{
                        echo '<h1>Not execute command!</h1>';
                        return false;
                    }

                }else{
                    echo '<h1>Not authentication!</h1>';
                    return false;
                }

            }else{
                echo '<h1>Not authentication!</h1>';
                return false;
            }

        }else{
            echo '<h1>Not authentication!</h1>';
            return false;
        }
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

                        if( !$apiProcessResponse ) {
                            echo '<h1>Command not execute!</h1>';
                            return false;
                        }else{
                            header('Content-Type: text/xml');
                            echo $apiProcessResponse;
                            return true;
                        }

                    }else{
                        echo '<h1>Not execute command!</h1>';
                        return false;
                    }

                }else{
                    echo '<h1>Not authentication!</h1>';
                    return false;
                }

            }else{
                echo '<h1>Not authentication!</h1>';
                return false;
            }

        }else{
            echo '<h1>Not authentication!</h1>';
            return false;
        }
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












/*Так бы мы отправлялы GET запрос на нужный адрес и получает ответ

            $requestURL  = Mage::getUrl('samapi/index/formatone', array('command' => 'getproducts', 'version'=>'1.0.0', 'input'=>'limit(1000)'));

            if( $curl = curl_init() ) {

                curl_setopt($curl, CURLOPT_HTTPHEADER, array('CoolVendor_SamApi-birrer: ZXCVBNM'));
                curl_setopt($curl, CURLOPT_URL, $requestURL);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $out = curl_exec($curl);
                curl_close($curl);
            }


            //альтернативный вариант с использованием HTTP клиента Guzzle, в таком случае нужно использовать api Magento для принятия клиентских запросов
            $client->request('GET', $requestURL, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept'     => 'application/json',
                    'X-Foo'      => ['Bar', 'Baz'],
                    'CoolVendor_SamApi-birrer' => 'ZXCVBNM'
                ]
            ]);
*/

/*Так бы мы отправлялы POST запрос на нужный адрес и получает ответ

        $requestURL  = Mage::getUrl('samapi/index/formatwo');

        $data = [
            'samapi-birrer' => 'ZXCVBNM',
            'command' => 'getproducts',
            'version'=>'1.0.0',
            'input'=> [
                'limit' => 1000
            ],
        ];

        $post_role_data = json_encode($data);

            if( $ch = curl_init($requestURL) ) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_role_data);

            $response = curl_exec($ch);
            curl_close($ch);

            var_dump($response);
        }
*/