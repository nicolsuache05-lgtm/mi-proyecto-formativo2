<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Insertar Administrador
        $admin = DB::table('administrador')->where('usuario', 'admin')->first();
        if ($admin) {
            $adminId = $admin->id_administrador;
            $updateData = [];
            if (Schema::hasColumn('administrador', 'contrasena')) {
                $updateData['contrasena'] = Hash::make('admin123');
            }
            if (Schema::hasColumn('administrador', 'contraseña')) {
                $updateData['contraseña'] = Hash::make('admin123');
            }
            if (!empty($updateData)) {
                DB::table('administrador')->where('id_administrador', $adminId)->update($updateData);
            }
        } else {
            $insertData = [
                'nombre' => 'Alejandra Vanegas',
                'correo' => 'admin@alejaNails.com',
                'usuario' => 'admin',
            ];
            if (Schema::hasColumn('administrador', 'contrasena')) {
                $insertData['contrasena'] = Hash::make('admin123');
            }
            if (Schema::hasColumn('administrador', 'contraseña')) {
                $insertData['contraseña'] = Hash::make('admin123');
            }
            $adminId = DB::table('administrador')->insertGetId($insertData);
        }

        // 2. Insertar Cliente de prueba (Laura Martínez / laura@correo.com / cliente123)
        $clienteExiste = DB::table('cliente')->where('correo', 'laura@correo.com')->exists();
        if (!$clienteExiste) {
            DB::table('cliente')->insert([
                'nombre' => 'Laura Martínez',
                'telefono' => '3109876543',
                'correo' => 'laura@correo.com',
                'password' => Hash::make('cliente123'),
                'activo' => 1,
            ]);
        }

        // 3. Insertar Empleado de prueba
        $empleadoExiste = DB::table('empleados')->exists();
        if (!$empleadoExiste) {
            $empleadoId = DB::table('empleados')->insertGetId([
                'nombre' => 'Diana Perez',
                'telefono' => '3112345678',
                'id_administrador' => $adminId,
            ]);
        }

        // 4. Insertar/Actualizar Servicios
        $servicios = [
            [
                'nombre_servicio' => 'Manicure clásica',
                'descripcion' => 'Limpieza, corte y esmaltado tradicional',
                'precio' => 25000,
                'id_administrador' => $adminId,
                'categoria' => 'Manicure',
                'imagen' => 'img/manicure_clasica_new.jpg',
            ],
            [
                'nombre_servicio' => 'Pedicure spa',
                'descripcion' => 'Exfoliación, hidratación y esmaltado de pies',
                'precio' => 35000,
                'id_administrador' => $adminId,
                'categoria' => 'Pedicure',
                'imagen' => 'img/pedicure_spa_new.jpg',
            ],
            [
                'nombre_servicio' => 'Uñas acrílicas',
                'descripcion' => 'Extensión de uñas en acrílico con diseño incluido',
                'precio' => 60000,
                'id_administrador' => $adminId,
                'categoria' => 'Manicure',
                'imagen' => 'img/unas_acrilicas_new.jpg',
            ],
            [
                'nombre_servicio' => 'Semipermanente',
                'descripcion' => 'Esmaltado de larga duración con lámpara UV',
                'precio' => 40000,
                'id_administrador' => $adminId,
                'categoria' => 'Manicure',
                'imagen' => 'img/manicure_clasica_new.jpg',
            ],
            [
                'nombre_servicio' => 'Retiro acrílico',
                'descripcion' => 'Retiro seguro de uñas acrílicas o gel',
                'precio' => 20000,
                'id_administrador' => $adminId,
                'categoria' => 'Manicure',
                'imagen' => 'img/unas_acrilicas_new.jpg',
            ],
            [
                'nombre_servicio' => 'Pedicure tradicional',
                'descripcion' => 'Limpieza, corte y esmaltado tradicional de uñas de los pies',
                'precio' => 28000,
                'id_administrador' => $adminId,
                'categoria' => 'Pedicure',
                'imagen' => 'img/pedicure_spa_new.jpg',
            ],
            [
                'nombre_servicio' => 'Pedicure semipermanente',
                'descripcion' => 'Esmaltado de larga duración con lámpara UV en pies',
                'precio' => 45000,
                'id_administrador' => $adminId,
                'categoria' => 'Pedicure',
                'imagen' => 'img/pedicure_spa_new.jpg',
            ],
            [
                'nombre_servicio' => 'Retiro pedicure',
                'descripcion' => 'Retiro seguro de esmalte semipermanente de pies',
                'precio' => 15000,
                'id_administrador' => $adminId,
                'categoria' => 'Pedicure',
                'imagen' => 'img/pedicure_spa_new.jpg',
            ],
            [
                'nombre_servicio' => 'Uñas Press On',
                'descripcion' => 'Uñas personalizadas a presión listas para aplicar',
                'precio' => 50000,
                'id_administrador' => $adminId,
                'categoria' => 'Manicure',
                'imagen' => 'img/unas_acrilicas_new.jpg',
            ]
        ];

        foreach ($servicios as $servicio) {
            DB::table('servicio')->updateOrInsert(
                ['nombre_servicio' => $servicio['nombre_servicio']],
                [
                    'descripcion' => $servicio['descripcion'],
                    'precio' => $servicio['precio'],
                    'id_administrador' => $servicio['id_administrador'],
                    'categoria' => $servicio['categoria'],
                    'imagen' => $servicio['imagen'],
                ]
            );
        }
    }
}
