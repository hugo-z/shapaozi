<?php

namespace App\Modules\Superuser\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('SUPERUSER');

            $event->menu->add([
                'text' => __('common.html.navi.contestant'),
                'icon' => 'user-md',
                'url'  => route('contestantsList')
                // 'submenu' => [
                //     [
                //         'text' => '选手'
                //     ]
                // ]
            ]);
            $event->menu->add([
                'text' => __('common.html.navi.fans'),
                'icon' => 'users',
                'url' => route('followersList'),
            ]);
            $event->menu->add([
                'text'    => __('common.html.navi.global'),
                'icon'    => 'cogs',
                'submenu' => [
                    [
                        'text' => __('common.html.navi.role'),
                        'url'  => route('rolesList'),
                        'icon' => 'cog'
                    ],
                    [
                        'text' => __('common.html.navi.user'),
                        'url'  => route('usersList'),
                        'icon' => 'users'
                    ],
                    [
                        'text' => __('common.html.navi.contest'),
                        'url' => route('contestList'),
                        'icon' => 'soccer-ball-o'
                    ],
                    [
                        'text' => __('common.html.navi.zone'),
                        'icon' => 'map-marker',
                        'url'  => route('zonesList')
                    ],
                    [
                        'text' => __('common.html.navi.template'),
                        'icon' => 'picture-o',
                        'url' => route('templList')
                    ]
                ],
            ]);
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}