<?php

namespace CoolVendor\SomeApi\Classes;

use CoolVendor\SomeApi\Interfaces\ValidatorInterface;

class Validator implements ValidatorInterface
{
    public $data_input = array();
    public $data_property = array();
    public $command_handler = null;

    public $dataCommand = array();

    public function getValidationData($formatProcess, $params)
    {
        $inspectFormat = 1;
        $inspectVersion = 1;
        $inspectCommand = 1;
        $inspectInput = 1;

        $apiconfigFile = \Mage::getConfig()->getModuleDir('etc', 'CoolVendor_SomeApi').DS.'apiconfig.xml';
        $stringXML = file_get_contents($apiconfigFile);
        $xmlDoc = simplexml_load_string($stringXML, 'Varien_Simplexml_Element');

        if($xmlDoc === false){
            return false;
        }

        foreach($xmlDoc as $formats){
            foreach($formats as $format) {
                $inspectFormat = strcasecmp ( $format->getName(), 'format'.$formatProcess);
                if($inspectFormat == 0) {
                    //используем оператор кастования (array),
                    // потому что $format->version_list ещё не был переведен в array,
                    // поскольку был получем не с помощью оператора foreach, внутри которого мы работаем
                    foreach ((array)$format->version_list as $version) {

                        $inspectVersion = strcasecmp ( $version->value, $params['version']);
                        if ($inspectVersion == 0) {

                            foreach ((array)$version->command_list as $command) {

                                $inspectCommand = strcasecmp ( $command->name, $params['command']);
                                if ($inspectCommand == 0) {

                                    foreach ((array)$command->validator_options as $parameter) {

                                        $parameter_name = (string)$parameter->name;
                                        if( array_key_exists($parameter_name, $params['input']) ){

                                            $inspectInput = (int) $parameter->value >= (int) $params['input'][$parameter_name] ? 0 : 1;
                                            if($inspectInput == 0){
                                                $this->data_input[$parameter_name] = $params['input'][$parameter_name];
                                            }
                                        }

                                    }
                                    if($inspectInput==1){
                                        //return '<h1>Not validation input!</h1>';
                                        return false;
                                    }
                                    //если входные данные прошли успешную проверку на валидность,
                                    // тогда проверяем наличие значения(value) в разделе property конфигов команды
                                    $property_name = null;
                                    $property_value = null;
                                    foreach ((array)$command->properties as $property) {

                                        $property_name = (string)$property->name;
                                        $property_value = (string)$property->value;
                                        if( ( $property_name === '') || ($property_value === '') ){
                                            //TOD: в идеале вместо простой проверки,
                                            //лучше выполнить ещё проверку касательно существования такого оператора в SQL, который указан в $property->name,
                                            // и проверку коректности синтаксиса его значения в $property->value
                                            //return '<h1>Not validation property!</h1>';
                                            return false;
                                        }
                                        if($property_name!=null && $property_value!=null) {
                                            $this->data_property[$property_name] = $property_value;
                                        }
                                        if($command->handler===''){
                                            //return '<h1>Not found command handler!</h1>';
                                            return false;
                                        }
                                        $this->command_handler = $command->handler;
                                    }
                                }
                            }
                            if($inspectCommand==1){
                                //return '<h1>Not validation command!</h1>';
                                return false;
                            }
                        }
                    }
                    if($inspectVersion==1){
                        //return '<h1>Not validation version!</h1>';
                        return false;
                    }
                }
            }
            if($inspectFormat==1){
                //return '<h1>Not validation format!</h1>';
                return false;
            }

        }
        //если все валидации прошли успешно, то добавляем входные данные и свойства команды
        $this->dataCommand['input'] = $this->data_input;
        if( count($this->data_property)>0 )$this->dataCommand['property'] = $this->data_property;
        $this->dataCommand['handler'] = $this->command_handler;

        return $this->dataCommand;
    }
}

