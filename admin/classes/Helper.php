<?php

namespace BGP\Classes;

class Helper
{
    public static function plugin_is_active($plugin_path): bool
    {
        return in_array($plugin_path, apply_filters('active_plugins', get_option('active_plugins')), true);
    }
}