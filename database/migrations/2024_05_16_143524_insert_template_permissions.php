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
                'name' => 'Раздел "Шаблоны"',
                'permission' => 'templates',
            ],
            [
                'name' => 'Просмотр шаблонов',
                'permission' => 'templates.view',
            ],
            [
                'name' => 'Редактирование шаблонов',
                'permission' => 'templates.edit',
            ],
            [
                'name' => 'Создание шаблонов',
                'permission' => 'templates.create',
            ],
            [
                'name' => 'Удаление шаблонов',
                'permission' => 'templates.delete',
            ],
        ];
        \DB::table('permissions')->insert($permissions);

        $staff_template = [
            "name" => "Основной шаблон",
            "fields" => json_encode([
                [
                    "name" => "Фамилия",
                    "slug" => "lastname",
                    "type" => "string",
                    "hidden" => false,
                    "multiple" => false
                ],
                [
                    "name" => "Имя",
                    "slug" => "firstname",
                    "type" => "string",
                    "hidden" => false,
                    "multiple" => false
                ],
                [
                    "name" => "Отчество",
                    "slug" => "middlename",
                    "type" => "string",
                    "hidden" => false,
                    "multiple" => false
                ]
            ])
        ];

        \DB::table('templates')->insert($staff_template);
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
        \DB::table('templates')->where('name', "Основные данные")->delete();
    }
};
