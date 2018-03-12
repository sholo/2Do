<?php
namespace App\Repositories;

use App\Task;

class TaskRepository
{
    /**
     * @var $model
     */
    private $model;
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
    public function update($basemap_id, $new_map)
    {
        return DB::table('base_maps')
            ->where('id', $basemap_id)
            ->update(['map' => $new_map]);
    }
    public function delete($basemap_id)
    {
        return DB::table('base_maps')
            ->where('id', $basemap_id)
            ->delete();
    }
}