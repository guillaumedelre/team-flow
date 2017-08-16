<?php

namespace AppBundle\Event\Listener\AdminLte;

use AppBundle\Domain\MezzoInterface;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;

class MenuItemListListener
{
    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }

    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    protected function getMenu(Request $request)
    {
        $apps = MezzoInterface::APPS;

        // Build your menu here by constructing a MenuItemModel array
        $menuItems = [
            $overview = new MenuItemModel(
                'overview',
                'Overview',
                'homepage',
                [/* options */],
                'fa fa-tachometer'
            ),
            $metrics = new MenuItemModel(
                'metrics',
                'Metrics',
                'metrics',
                [
                    'metricName' => 'phpunit',
                ],
                'fa fa-bar-chart'
            ),
        ];

        $metrics->addChild(
            new MenuItemModel(
                "metrics_phpunit",
                'Phpunit',
                'metrics',
                ['metricName' => 'phpunit'],
                'fa fa-bar-chart'
            )
        );
        $metrics->addChild(
            new MenuItemModel(
                "metrics_behat",
                'Behat',
                'metrics',
                ['metricName' => 'behat'],
                'fa fa-bar-chart'
            )
        );

        // A child with default circle icon
//        $blog->addChild(new MenuItemModel('ChildTwoItemId', 'ChildTwoDisplayName', 'child_2_route'));

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param $route
     * @param $items
     *
     * @return mixed
     */
    protected function activateByRoute($route, $items)
    {

        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}
