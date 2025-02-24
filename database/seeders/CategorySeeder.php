<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electrónica',
            'Ropa y accesorios',
            'Hogar y Jardín',
            'Coches y Motos',
            'Deportes y Ocio',
            'Juguetes y Juegos',
            'Libros y Música',
            'Servicios',
            'Mascotas',
            'Otros',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    
    }
}
