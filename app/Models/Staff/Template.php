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

    public function deleteField($slug)
    {
        $fields = json_decode($this->fields, true);
        foreach ($fields as $key => $field) {
            if ($slug == $field['slug']) {
                unset($fields[$key]);
                $this->update(['fields' => json_encode($fields)]);
                break;
            }
        }
    }
}
