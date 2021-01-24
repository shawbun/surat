<?php
use App\Model\Category;

class Helper
{
    public static function getCategory()
    {

        $category = Category::get();

        return $category;
    }

}
