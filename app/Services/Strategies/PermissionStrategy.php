<?php

namespace App\Services\Strategies;

use Illuminate\Http\Request;

interface PermissionStrategy
{
    public function check(Request $request, array $authorizationIds, array $authorizations): bool;
}
