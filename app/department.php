<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function update_dept($id, $name)
    {
        department::where('id', '=', $id)->update(array('name' => $name));
    }

    public function get_dept_by_id($id)
    {
        return department::where('id', '=', $id)->get();
    }

    public function create_dept($name)
    {
        department::create([
            'name' => $name,
        ]);
    }
}
