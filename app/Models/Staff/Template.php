<?php

namespace App\Models\Staff;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = "staff_templates";
    protected $fillable = [
        'name',
        'fields',
    ];
    public $timestamps = false;

    public function addField(array $field)
    {
        $fields = json_decode($this->fields, true);
        $fields[] = $field;
        $this->update(['fields' => $fields]);
    }
}
