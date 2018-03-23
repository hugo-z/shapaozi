<?php

namespace App\Modules\Superuser\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Modules\Superuser\Repositories\ZonesRepository;
use App\Modules\Superuser\Models\Zones;
use App\Modules\Superuser\Validators\ZonesValidator;

/**
 * Class ZonesRepositoryEloquent.
 *
 * @package namespace App\Modules\Superuser\Repositories;
 */
class ZonesRepositoryEloquent extends BaseRepository implements ZonesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Zones::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
