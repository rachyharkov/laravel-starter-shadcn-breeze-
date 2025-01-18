<?php

/**
 * Fungsi untuk mengetahui apakah admin memiliki jumlah lebih dari 1, untuk mencegah kekosongan data dan terhentinya proses bisnis didalam app
 *
 * @return response()
 */

use App\Models\User;

if (! function_exists('isAdminMoreThanOne')) {
    function isAdminMoreThanOne()
    {
        $users = User::with('user_roles:id')->count();
        return $users > 1;
    }
}
