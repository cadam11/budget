<?php

namespace Budget\Composers;

use App;

class CategoriesComposer
{

    public function compose($view)
    {
    	$categories = App::make('Budget\Services\CategoryService');
        $view->with('categories', $categories->getAll()->keys());
    }
    
}