<?php
namespace App\Http\View\Composers;
use Illuminate\View\View;

class ThemeComposer
{
    /**
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (request()->segment(1) === "settings" || request()->segment(1) === "admin") {
            $theme = 'theme-teal';
        } elseif(request()->segment(1) !== "collection") {
            $theme = 'theme-green';
        } else {
            $theme = 'theme-blue';
        }

        $view->with('theme', $theme);
    }
}