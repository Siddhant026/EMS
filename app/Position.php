<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name', 'dept_id'
    ];

    public function department()
    {
        return $this->belongsTo('App\department', 'dept_id');
    }

    public function create_position($name, $dept_id)
    {
        Position::create([
            'name' => $name,
            'dept_id' => $dept_id,
        ]);
    }

    public function update_position($id, $name, $dept_id)
    {
        Position::where('id', '=', $id)->update(array('name' => $name, 'dept_id' => $dept_id));
    }

    public function get_position($name, $dept_id)
    {
        if (empty($dept_id)) {
            $where = [['name', 'like', '%' . $name . '%']];
        } else {
            $where = [['name', 'like', '%' . $name . '%'], ['dept_id', '=', $dept_id]];
        }
        return Position::where($where)
            ->get();
    }
}
