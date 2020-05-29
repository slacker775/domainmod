<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class LegacyController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function loadLegacyScript(string $requestPath, string $legacyScript)
    {
        $this->logger->debug(sprintf("Legacy loading - path: %s, script: %s", $requestPath, $legacyScript));
        return new StreamedResponse(function () use ($requestPath, $legacyScript) {
            $_SERVER['PHP_SELF'] = $requestPath;
            $_SERVER['SCRIPT_NAME'] = $requestPath;
            $_SERVER['SCRIPT_FILENAME'] = $legacyScript;

            chdir(dirname($legacyScript));

            require $legacyScript;
        });
    }
}