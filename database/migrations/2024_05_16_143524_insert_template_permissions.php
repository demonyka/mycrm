<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permissions = [
            [
                'name' => 'Просмотр скрытых полей сотрудника',
                'permission' => 'staff.field.hidden',
            ],
            [
                'name' => 'Просмотр шаблонов сотрудников',
                'permission' => 'staff.template.view',
            ],
            [
                'name' => 'Редактирование шаблонов сотрудников',
                'permission' => 'staff.template.edit',
            ],
            [
                'name' => 'Создание шаблонов сотрудников',
                'permission' => 'staff.template.create',
            ],
            [
                'name' => 'Удаление шаблонов сотрудников',
                'permission' => 'staff.template.delete',
            ],
        ];
        \DB::table('permissions')->insert($permissions);

        $staff_template = [
            "name" => "Основные данные",
            "fields" => json_encode([
                [
                    "name" => "Фамилия",
                    "slug" => "lastname",
                    "type" => "text",
                    "hidden" => false,
                    "required" => true
                ],
                [
                    "name" => "Имя",
                    "slug" => "firstname",
                    "type" => "text",
                    "hidden" => false,
                    "required" => true
                ],
                [
                    "name" => "Отчество",
                    "slug" => "middlename",
                    "type" => "text",
                    "hidden" => false,
                    "required" => false
                ]
            ])
        ];

        \DB::table('staff_templates')->insert($staff_template);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('permissions')->whereIn('permission', [
            'staff.field.hidden',
            'templates',
            'templates.view',
            'templates.edit',
            'templates.create',
            'templates.delete'
        ])->delete();
        \DB::table('staff_templates')->where('name', "Основные данные")->delete();
    }
};
