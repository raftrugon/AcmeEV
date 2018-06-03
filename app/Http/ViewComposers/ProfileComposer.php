<?php

namespace App\Http\ViewComposers;

use App\Repositories\SystemConfigRepo;
use Illuminate\View\View;
use App\Repositories\UserRepository;

class ProfileComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $systemConfigRepo;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(SystemConfigRepo $systemConfigRepo)
    {
        // Dependencies automatically resolved by service container...
        $this->systemConfigRepo = $systemConfigRepo;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('actual_state',$this->systemConfigRepo->getActualState());
    }
}