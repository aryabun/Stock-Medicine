<?php

use App\Models\Enumeration\ModelEnum;
use Carbon\Carbon;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     * @return Carbon
     *
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.index';
    }
    if (! function_exists('generate_code_number')) {
        function generate_code_number($model, $parent_code = null): string
        {
            $model_prop = ModelEnum::MODEL_PROP[strtolower($model)];
            if ($parent_code) {
                $latest_code = DB::table($model_prop['table'])
//                ->where('active', true)
                    ->where('code', 'like', $parent_code.'%')
                    ->orderBy('code','DESC')->first(); // get latest vendor
            } else {
                $latest_code = DB::table($model_prop['table'])
                    ->orderBy('code','DESC')->first(); // get latest vendor
            }
            if ($latest_code) {
                $current_code = (int)str_replace(($parent_code)? $parent_code.'-': $model_prop['prefix'],"", $latest_code->code);
                $new_code = (($parent_code) ? $parent_code.'-': $model_prop['prefix']).str_pad($current_code + 1, (($parent_code) ? $model_prop['child_length']: $model_prop['length']), "0", STR_PAD_LEFT);
            } else {
                $new_code = (($parent_code) ? $parent_code.'-': $model_prop['prefix']).str_pad(1, $model_prop['length'], "0", STR_PAD_LEFT);
            }
            // it means that if the code exit we need to generate the new one
            if (verify_code($model_prop['table'], $new_code)) {
                generate_code_number($model);
            }
            return $new_code;
        }
        function verify_code($table, $code) {
            return DB::table($table)->where('code', $code)->first() ?? false;
        }
        function translateNumber($number): string
        {
            $new_number = '';
            $chars = str_split((string)$number);
            foreach ($chars as $char) {
                $new_number .= \App\Models\Enumeration\SettingEnum::NUMBER_EN_KH[$char];
            }
            return $new_number;
        }
    }
}
