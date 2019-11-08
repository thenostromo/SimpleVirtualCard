<?php
namespace Reader;

class ParameterReader
{
    /**
     * @var array
     */
    public $parameters;

    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $parameters = $this->readEnvFile();
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    private function readEnvFile()
    {
        $parameters = [];
        $configFile = __DIR__."../../../config/.env";
        $content = file_get_contents($configFile);
        $rows = explode("\n", $content);
        foreach ($rows as $row) {
            $paramParts = explode("=", $row);
            $parameters[$paramParts[0]] = $paramParts[1];
        }
        return $parameters;
    }
}
