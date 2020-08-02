<?php
declare(strict_types=1);

namespace App\EventSubscriber;

use KevinPapst\AdminLTEBundle\Event\BreadcrumbMenuEvent;
use KevinPapst\AdminLTEBundle\Event\SidebarMenuEvent;
use KevinPapst\AdminLTEBundle\Model\MenuItemModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilderSubscriber implements EventSubscriberInterface
{

    private AuthorizationCheckerInterface $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            SidebarMenuEvent::class    => ['onSetupNavbar', 100],
            BreadcrumbMenuEvent::class => ['onSetupNavbar', 100],
        ];
    }

    public function onSetupNavbar(SidebarMenuEvent $event)
    {
        $event->addItem(
            new MenuItemModel(
                'home', 'Dashboard', 'home', [], 'fas fa-tachometer-alt'
            )
        );

        $event->addItem(
            new MenuItemModel(
                'domains', 'Domains', 'domain_index', [], 'fas fa-sitemap'
            )
        );

        $event->addItem(
            new MenuItemModel(
                'queue', 'Queue', 'queue', [], 'fas fa-hourglass-start'
            )
        );

        $event->addItem(
            new MenuItemModel(
                'ssl', 'SSL Certificates', 'ssl_cert_index', [], 'fas fa-lock'
            )
        );

        $assetMenu = new MenuItemModel(
            'assets_main', 'Assets', 'asset', [], 'fas fa-cubes'
        );
        $assetMenu->addChild(
            new MenuItemModel(
                'registrar', 'Domain Registrars', 'registrar_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'registrar_account', 'Registrar Accounts',
                'registrar_account_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'dns', 'DNS Profiles',
                'dns_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'hosting', 'Web Hosting Providers',
                'hosting_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'ssl_provider', 'SSL Providers',
                'ssl_provider_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'ssl_account', 'SSL Provider Accounts',
                'ssl_account_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'ssl_type', 'SSL Certificate Types',
                'ssl_cert_type_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'owner', 'Account Owners',
                'owner_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'category', 'Categories',
                'category_index', [], ''
            )
        )->addChild(
            new MenuItemModel(
                'ip_address', 'IP Addresses',
                'ip_address_index', [], ''
            )
        );
        $event->addItem($assetMenu);

        $event->addItem(
            new MenuItemModel(
                'segment', 'Segments', 'segment_index', [], 'fas fa-filter'
            )
        );

        $event->addItem(
            new MenuItemModel(
                'reporting', 'Reporting', 'reporting_index', [],
                'fas fa-chart-bar'
            )
        );

        $settingsMenu = new MenuItemModel(
            'settings', 'Settings', 'settings_index', [], 'fas fa-cogs'
        );
        $settingsMenu->addChild(
            new MenuItemModel(
                'settings_display', 'Display Settings', 'settings_display', [],
                'fas fa-tv'
            )
        );
        $settingsMenu->addChild(
            new MenuItemModel(
                'settings_defaults', 'User Defaults', 'settings_defaults', [],
                'fas fa-sliders-h'
            )
        );
        $settingsMenu->addChild(
            new MenuItemModel(
                'settings_profile', 'User Profile', 'settings_profile', [],
                'fas fa-passport'
            )
        );
        $settingsMenu->addChild(
            new MenuItemModel(
                'settings_password', 'Change Password', 'settings_password', [],
                'fas fa-key'
            )
        );
        $event->addItem($settingsMenu);

        if ($this->security->isGranted('ROLE_ADMIN') === true) {
            $adminMenu = new MenuItemModel(
                'admin_index', 'Administration', 'admin_index', [], 'fas fa-cog'
            );
            $adminMenu->addChild(
                new MenuItemModel(
                    'admin_settings', 'System Settings', 'admin_settings', [],
                    'fas fa-cog'
                )
            );
            $adminMenu->addChild(
                new MenuItemModel(
                    'admin_defaults', 'System Defaults', 'admin_defaults', [],
                    'fas fa-tasks'
                )
            );
            $adminMenu->addChild(
                new MenuItemModel(
                    'user_index', 'Users', 'user_index', [], 'fas fa-users-cog'
                )
            );
            $adminMenu->addChild(
                new MenuItemModel(
                    'scheduler_index', 'Task Scheduler', 'scheduler_index', [],
                    'fas fa-calendar-alt'
                )
            );
            $adminMenu->addChild(
                new MenuItemModel(
                    'maintenance', 'Maintenance', 'segment_index', [],
                    'fas fa-tools'
                )
            );
            $event->addItem($adminMenu);
        }

        $this->activateByRoute(
            $event->getRequest()
                ->get('_route'), $event->getItems()
        );
    }

    protected function activateByRoute(string $route, array $items): void
    {
        foreach ($items as $item) {
            if ($item->hasChildren() === true) {
                $this->activateByRoute($route, $item->getChildren());
            } elseif ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }
    }

}
