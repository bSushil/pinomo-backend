<?php
namespace Main\Modules\Acl\Models;

use Core\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * FfdcFile
 */
class Role extends AbstractModel
{
    protected $fillable = [
        'name',
    ];
    protected array $nullables = [];
    protected array $relationships = [
        'permissions'
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
}