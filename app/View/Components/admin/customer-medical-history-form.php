<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use function view;

class customer-medical-history-form extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.customer-medical-history-form');
    }
}
