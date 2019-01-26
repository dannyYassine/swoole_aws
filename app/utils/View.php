<?php

class View
{
    public static function get($view)
    {
        return file_get_contents(APP_ROOT.'/views/'.$view.'.html');
    }

}