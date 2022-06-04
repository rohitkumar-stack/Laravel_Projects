<?php 

namespace App\Observers;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;
use Orchestra\Tenanti\Observer;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OrganisationObserver extends Observer
{
    public function getDriverName()
    {
        return 'organisation';
    }
    /**
     * Handle the company "created" event.
     *
     * @param  App\Models\Organisation  $organisation
     * @return void
     */
    public function created(Model $entity)
    {
        if(Auth::User()->role_id == 1 && Auth::User()->role_id == $entity->parent_id){
            $connection = $entity->getConnection();
            $this->createTenantDatabase($entity);
            parent::created($entity);
        }
    }

    protected function createTenantDatabase(Model $entity) {     
            $connection = $entity->getConnection();
            $driver     = $connection->getDriverName();
            $id         = $entity->getKey();
            switch ($driver) {
                case 'mysql':
                    $query = "CREATE DATABASE `enthucate_{$id}`";
                    break;
                case 'pgsql':
                    $query = "CREATE DATABASE enthucate_{$id}";
                    break;
                default:
                    throw new InvalidArgumentException("Database Driver [{$driver}] not supported");
            }
    		return  $connection->unprepared($query);
    }
}