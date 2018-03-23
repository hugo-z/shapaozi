<?php

namespace App\Modules\Superuser\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class UserRoles extends Model implements Transformable
{
    use TransformableTrait;
    
    /**
     * Role user table
     *
     * @var string
     */
    protected $table = 'huge__role_user';

    /**
     * Accept these
     *
     * @var array
     */
    protected $fillable = ['user_id', 'role_id'];

    /**
     * No incrementing id
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * Primary Key
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Set timestamps false
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var int
     */
    public $userId = null;

    /**
     * User has Roles
     *
     * @return void
     */
    public function userHasRoles()
    {
        
        return self::all();
    }

    /**
     * Update the associated roles
     *
     * @param array $roleIds
     * @return void
     */
    public function storeRoles(array $roleIds)
    {
        if (self::where('user_id', $this->userId)->exists()) {
            $existedRoles = self::where('user_id', $this->userId)->get();

            foreach ($existedRoles as $existedRole) {
                if (!in_array($existedRole->role_id, $roleIds)) {
                    self::where([
                        'role_id' => $existedRole->role_id,
                        'user_id' => $this->userId
                    ])->delete();
                } 
            }
            # 更新roles
            array_map(function ($roleId) {
                // self::where(
                //     [
                //         'user_id' => $this->userId,
                //         'role_id' => $roleId
                //     ]
                // )->update(['role_id' => $roleId]);
                self::updateOrCreate(
                    [
                        'user_id' => $this->userId,
                        'role_id' => $roleId
                    ],
                    [
                        'role_id' => $roleId
                    ]
                );
            }, $roleIds);
        } else {
            array_map(function ($roleId) {
                self::create(
                    [
                        'user_id' => $this->userId,
                        'role_id' => $roleId
                    ]
                );
            }, $roleIds);
        }
    }

    /**
     * Set User Id
     *
     * @param int $userId
     * @return void
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get User Id
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
