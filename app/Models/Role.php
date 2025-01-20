<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole
{
    use HasFactory;

    // Define the tenant-specific scope
    // public function scopeForTenant($query, $tenantId)
    // {
    //     return $query->where('tenant_id', $tenantId);
    // }
}
