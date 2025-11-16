<?php
namespace Main\Modules\Acl\Models;

use Core\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * FfdcFile
 */
class Permission extends AbstractModel
{
    protected $fillable = [
        'name',
        'permission_key',
        'entity'
    ];
    protected array $nullables = [];
    protected array $relationships = [
        'roles'
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}