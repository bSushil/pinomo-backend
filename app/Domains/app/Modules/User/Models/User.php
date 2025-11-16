<?php
namespace Main\Modules\User\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Core\Models\AbstractModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\Session;
use Main\Modules\Acl\Models\Role;

class User extends AbstractModel implements 
    AuthorizableContract, 
    AuthenticatableContract, 
    CanResetPasswordContract
{
    use HasFactory, Notifiable, Authenticatable, Authorizable, CanResetPassword;
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    protected array $nullables = [];

    protected array $relationships = [];

        
    /**
     * password
     *
     * @return Attribute
     */
    public function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value),
        );
    }
    
    /**
     * createdAt
     *
     * @return Attribute
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('Y-m-d H:i:s')
        );
    }
    
    /**
     * role
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * can
     *
     * @param mixed $ability
     * @param mixed $entity
     */
    /** 
     * @return bool
     */
    public function can($ability, $entity = []): bool
    {
        $rolePermissions = Session::get('role_permissions');

        if (!in_array($entity, array_keys($rolePermissions))) {
            return false;
        }
        
        foreach ($rolePermissions as $roleEntity => $permissions) {
            if ($roleEntity == $entity && in_array($ability, $permissions)) {
                return true;
            }
        }
        return false;
    }
}