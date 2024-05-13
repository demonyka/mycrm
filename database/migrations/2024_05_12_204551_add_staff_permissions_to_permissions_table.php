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
                'name' => 'Раздел "Сотрудники"',
                'permission' => 'staff',
            ],
            [
                'name' => 'Просмотр списка сотрудников',
                'permission' => 'staff.view.list',
            ],
            [
                'name' => 'Просмотр уволенных сотрудников',
                'permission' => 'staff.view.dismiss',
            ],
            [
                'name' => 'Добавление сотрудников',
                'permission' => 'staff.create',
            ],
            [
                'name' => 'Увольнение сотрудников',
                'permission' => 'staff.delete',
            ],
            [
                'name' => 'Восстановление сотрудников',
                'permission' => 'staff.restore',
            ],
            [
                'name' => 'Редактирование сотрудников',
                'permission' => 'staff.edit',
            ],
        ];

        \DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('permissions')->whereIn('permission', [
            'staff.view.list',
            'staff.view.dismiss',
            'staff.create',
            'staff.delete',
            'staff.edit',
        ])->delete();    }
};
