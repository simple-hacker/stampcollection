<?php
namespace App\Http\View\Composers;
use Illuminate\View\View;

class YearComposer
{
    private $years;
    /**
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!$this->years) {
            $this->years = \DB::table('years')->orderBy('year', 'desc')->get()->pluck('year');
        }
        $view->with('years', $this->years);
    }
}