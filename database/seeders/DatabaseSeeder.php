<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'name' => 'HRD',
                'username' => 'hrd',
                'password' => bcrypt('hrd'),
                'role' => 'HRD'
            ],
            [
                'name' => 'Direktur',
                'username' => 'direktur',
                'password' => bcrypt('direktur'),
                'role' => 'Direktur'
            ]
        ];


        $alternatif = [
            [
                'name' => 'Pegawai 1',
                'kode_alternatif' => 'A1',
                'tgl_masuk' => '2025-01-01',
                'role' => 'Pegawai',
                'username' => 'pegawai1',
                'password' => bcrypt('123'),
            ],
            [
                'name' => 'Pegawai 2',
                'kode_alternatif' => 'A2',
                'tgl_masuk' => '2025-01-01',
                'role' => 'Pegawai',
                'username' => 'pegawai2',
                'password' => bcrypt('123'),
            ]
        ];

        $kriteria = [
            [
                'kode_kriteria' => 'C1',
                'nama_kriteria' => 'Kualitas Kerja',
                'bobot' => 20.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C2',
                'nama_kriteria' => 'Kerjasama',
                'bobot' => 10.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C3',
                'nama_kriteria' => 'Tanggung Jawab',
                'bobot' => 15.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C4',
                'nama_kriteria' => 'Kehadiran',
                'bobot' => 10.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C5',
                'nama_kriteria' => 'Inisiatif dan Kreativitas',
                'bobot' => 15.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C6',
                'nama_kriteria' => 'Masa Kerja',
                'bobot' => 15.0,
                'jenis' => 'Benefit',
            ],
            [
                'kode_kriteria' => 'C7',
                'nama_kriteria' => 'Kejujuran',
                'bobot' => 15.0,
                'jenis' => 'Benefit',
            ],
        ];


        $subkriteria = [
            ['id_kriteria' => 1, 'nama_sub_kriteria' => 'KK>85', 'nilai' => 4],
            ['id_kriteria' => 1, 'nama_sub_kriteria' => '80≤KK<85', 'nilai' => 3],
            ['id_kriteria' => 1, 'nama_sub_kriteria' => '70≤KK<80', 'nilai' => 2],
            ['id_kriteria' => 1, 'nama_sub_kriteria' => 'KK<70', 'nilai' => 1],
            ['id_kriteria' => 2, 'nama_sub_kriteria' => 'K>85', 'nilai' => 4],
            ['id_kriteria' => 2, 'nama_sub_kriteria' => '80≤K<85', 'nilai' => 3],
            ['id_kriteria' => 2, 'nama_sub_kriteria' => '70≤K<80', 'nilai' => 2],
            ['id_kriteria' => 2, 'nama_sub_kriteria' => 'K<70', 'nilai' => 1],
            ['id_kriteria' => 3, 'nama_sub_kriteria' => 'TJ>85', 'nilai' => 4],
            ['id_kriteria' => 3, 'nama_sub_kriteria' => '80≤TJ<85', 'nilai' => 3],
            ['id_kriteria' => 3, 'nama_sub_kriteria' => '70≤TJ<80', 'nilai' => 2],
            ['id_kriteria' => 3, 'nama_sub_kriteria' => 'TJ<70', 'nilai' => 1],
            ['id_kriteria' => 4, 'nama_sub_kriteria' => 'A>95%', 'nilai' => 4],
            ['id_kriteria' => 4, 'nama_sub_kriteria' => '90%≤A<95%', 'nilai' => 3],
            ['id_kriteria' => 4, 'nama_sub_kriteria' => '80%≤A<90%', 'nilai' => 2],
            ['id_kriteria' => 4, 'nama_sub_kriteria' => 'A<80%', 'nilai' => 1],
            ['id_kriteria' => 5, 'nama_sub_kriteria' => 'IK>85', 'nilai' => 4],
            ['id_kriteria' => 5, 'nama_sub_kriteria' => '80≤IK<85', 'nilai' => 3],
            ['id_kriteria' => 5, 'nama_sub_kriteria' => '70≤IK<80', 'nilai' => 2],
            ['id_kriteria' => 5, 'nama_sub_kriteria' => 'IK<70', 'nilai' => 1],
            ['id_kriteria' => 6, 'nama_sub_kriteria' => 'MK>5 tahun', 'nilai' => 4],
            ['id_kriteria' => 6, 'nama_sub_kriteria' => '3<MK≤5', 'nilai' => 3],
            ['id_kriteria' => 6, 'nama_sub_kriteria' => '1<MK≤3', 'nilai' => 2],
            ['id_kriteria' => 6, 'nama_sub_kriteria' => 'MK≤1 tahun', 'nilai' => 1],
            ['id_kriteria' => 7, 'nama_sub_kriteria' => 'KJ>85', 'nilai' => 4],
            ['id_kriteria' => 7, 'nama_sub_kriteria' => '80≤KJ<85', 'nilai' => 3],
            ['id_kriteria' => 7, 'nama_sub_kriteria' => '70≤KJ<80', 'nilai' => 2],
            ['id_kriteria' => 7, 'nama_sub_kriteria' => 'KJ<70', 'nilai' => 1],
        ];

        $penilaianPerbulan = [
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 1, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 2, 'nilai' => 70],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 3, 'nilai' => 90],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 4, 'nilai' => 150],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 5, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 6, 'nilai' => 1],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 7, 'nilai' => 70],

            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 1, 'nilai' => 80],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 2, 'nilai' => 70],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 3, 'nilai' => 90],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 4, 'nilai' => 150],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 5, 'nilai' => 60],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 6, 'nilai' => 1],
            ['periode' => '2025-01', 'id_user' => 3, 'id_kriteria' => 7, 'nilai' => 50],

            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 1, 'nilai' => 60],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 2, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 3, 'nilai' => 90],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 4, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 5, 'nilai' => 70],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 6, 'nilai' => 1],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 7, 'nilai' => 80],

            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 1, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 2, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 3, 'nilai' => 100],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 4, 'nilai' => 175],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 5, 'nilai' => 50],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 6, 'nilai' => 1],
            ['periode' => '2025-01', 'id_user' => 4, 'id_kriteria' => 7, 'nilai' => 80],
        ];


        DB::table('users')->insert($users);
        DB::table('users')->insert($alternatif);
        DB::table('kriteria')->insert($kriteria);
        DB::table('sub_kriteria')->insert($subkriteria);
        DB::table('penilaian_perbulans')->insert($penilaianPerbulan);
    }
}
