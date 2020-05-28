<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class LegacyController
{

    public function loadLegacyScript(string $requestPath, string $legacyScript)
    {
        return new StreamedResponse(function () use ($requestPath, $legacyScript) {
            $_SERVER['PHP_SELF'] = $requestPath;
            $_SERVER['SCRIPT_NAME'] = $requestPath;
            $_SERVER['SCRIPT_FILENAME'] = $legacyScript;

            chdir(dirname($legacyScript));

            require $legacyScript;
        });
    }
}