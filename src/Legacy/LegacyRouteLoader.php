<?php
namespace App\Legacy;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;

class LegacyRouteLoader extends Loader
{

    private $webDir = [
        'dashboard',
        'admin',
        'domains',
        'assets',
        'ssl',
        'segments',
        'bulk',
        'reporting',
        'settings',
        'maintenance',
    ];

    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Symfony\Component\Config\Loader\LoaderInterface::supports()
     */
    public function supports($resource, string $type = null)
    {
        return 'extra' === $type;
    }

    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();
        $finder = new Finder();
        $finder->files()->name('*.php');

        foreach ($finder->in($this->webDir) as $legacyScriptFile) {
            $pathname = $legacyScriptFile->getPath();
            $filename = basename($legacyScriptFile->getRelativePathname(), '.php');
            if ($filename !== 'index') {
                $routeUri = sprintf('%s/%s.php', $pathname, $filename);
            } else {
                $routeUri = $pathname;
            }
            $routePath = sprintf('%s/%s', $pathname, $filename);
            $routeName = sprintf('app.legacy.%s', str_replace('/', '__', $routePath));

            $collection->add($routeName, new Route($routeUri, [
                '_controller' => 'App\Controller\LegacyController::loadLegacyScript',
                'requestPath' => '/' . $legacyScriptFile->getPathname(),
                'legacyScript' => $this->projectDir . '/' . $legacyScriptFile->getPathname()
            ]));
        }

        return $collection;
    }
}