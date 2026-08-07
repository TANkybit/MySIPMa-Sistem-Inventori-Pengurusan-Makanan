<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\State;
use App\Models\District;
use App\Models\Institution;

class SeedInstitutionsFromReference extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seed/update institution + district data from the authoritative
     * reference list of correctional/prison institutions.
     */
    public function run(): void
    {
        $states = State::pluck('id', 'name');
        $districtNameToId = $this->cacheDistricts($states);

        $getDistrict = function (string $districtName, string $stateName) use (&$districtNameToId, $states) {
            $key = $stateName . '|' . $districtName;
            if (!isset($districtNameToId[$key])) {
                $d = District::firstOrCreate(
                    ['state_id' => $states[$stateName], 'name' => $districtName]
                );
                $districtNameToId[$key] = $d->id;
            }
            return $districtNameToId[$key];
        };

        $data = [
            1  => ['Pusat Koreksional Perlis', 'Kampung Guar Nangka', '02500', 'Kangar', 'Perlis'],
            2  => ['Penjara Alor Setar', 'Jalan Sultanah, Alor Setar', '05350', 'Kota Setar', 'Kedah'],
            3  => ['Penjara Sungai Petani', 'Kampung Sungai Tongka, Sungai Petani', '08000', 'Sik', 'Kedah'],
            4  => ['Penjara Pokok Sena', 'KM 24, Jalan Naka, Pokok Sena', '06400', 'Pokok Sena', 'Kedah'],
            5  => ['Penjara Reman Pulau Pinang', 'Jalan Penjara, George Town', '10450', 'Timur Laut', 'Pulau Pinang'],
            6  => ['Penjara Seberang Perai', 'Jawi, Seberang Perai', '14200', 'Seberang Perai Tengah', 'Pulau Pinang'],
            7  => ['Penjara Taiping', 'Jalan Taming Sari, Taiping', '34000', 'Larut, Matang dan Selama', 'Perak'],
            8  => ['Penjara Tapah', 'KM 12, Jalan Tapah, Tapah', '35400', 'Batang Padang', 'Perak'],
            9  => ['Pusat Koreksional Batu Gajah', 'Jalan Brewster, Batu Gajah', '31000', 'Kinta', 'Perak'],
            10 => ['Pusat Koreksional Kamunting', 'Kamunting', '34600', 'Larut, Matang dan Selama', 'Perak'],
            11 => ['Penjara Kajang', 'Kompleks Penjara, Kajang', '43000', 'Hulu Langat', 'Selangor'],
            12 => ['Penjara Wanita Kajang', 'Jalan Sungai Jelok, Kajang', '43000', 'Hulu Langat', 'Selangor'],
            13 => ['Penjara Sungai Buloh', 'Jalan Harapan, Sungai Buloh', '48020', 'Petaling', 'Selangor'],
            14 => ['Pusat Koreksional Puncak Alam', 'Jalan Meru Tambahan, Puncak Alam', '42300', 'Kuala Selangor', 'Selangor'],
            15 => ['Penjara Seremban', 'Jalan Muthu Cumaru, Seremban', '70200', 'Seremban', 'Negeri Sembilan'],
            16 => ['Institut Pemulihan Dadah Jelebu', 'Titi, Jelebu', '71650', 'Jelebu', 'Negeri Sembilan'],
            17 => ['Penjara Sungai Udang', 'Sungai Udang', '76300', 'Melaka Tengah', 'Melaka'],
            18 => ['Penjara Pra Bebas Dusun Dato\' Murad', 'Air Keroh', '75400', 'Melaka Tengah', 'Melaka'],
            19 => ['Sekolah Henry Gurney Telok Mas', '215, Jalan Telok Emas/Umbai, Kampung Jawa', '75460', 'Melaka Tengah', 'Melaka'],
            20 => ['Pusat Reintegrasi Penghuni Jasin', 'Jalan Merlimau/Jasin, Kampung Lipat Kajang, Jasin', '77000', 'Jasin', 'Melaka'],
            21 => ['Penjara Simpang Renggam', 'Simpang Renggam', '86200', 'Kluang', 'Johor'],
            22 => ['Penjara Kluang', 'Kg. Gajah, Jalan Mersing, Kluang', '86000', 'Kluang', 'Johor'],
            23 => ['Pusat Koreksional Johor Bahru', 'Batu 19, Jalan Ulu Choh, Pontian-Skudai Hwy, Johor Bahru', '81300', 'Johor Bahru', 'Johor'],
            24 => ['Pusat Koreksional Muar', 'Jalan Salleh, Muar', '84000', 'Muar', 'Johor'],
            25 => ['Penjara Bentong', 'Karak, Bentong', '28700', 'Bentong', 'Pahang'],
            26 => ['Penjara Penor', 'Kampung Seri Melati, Kuantan', '26060', 'Kuantan', 'Pahang'],
            27 => ['Penjara Marang', 'Marang', '21600', 'Marang', 'Terengganu'],
            28 => ['Pusat Koreksional Dungun', 'Bukit Besi, Dungun', '23200', 'Dungun', 'Terengganu'],
            29 => ['Penjara Pengkalan Chepa', 'Jalan Maktab, Pengkalan Chepa', '16109', 'Kota Bharu', 'Kelantan'],
            30 => ['Pusat Koreksional Machang', 'Machang', '18500', 'Machang', 'Kelantan'],
            31 => ['Penjara Miri', 'Miri', '98000', 'Miri', 'Sarawak'],
            32 => ['Penjara Limbang', 'MX8J+97 Kampung Bakol, Limbang', '98700', 'Limbang', 'Sarawak'],
            33 => ['Penjara Sibu', 'Jalan Awang Ramli Amit, Pekan Sibu', '96000', 'Sibu', 'Sarawak'],
            34 => ['Penjara Sri Aman', 'Bandar Sri Aman', '95008', 'Sri Aman', 'Sarawak'],
            35 => ['Penjara Puncak Borneo', 'Jalan Puncak Borneo, Kuching', '93250', 'Kuching', 'Sarawak'],
            36 => ['Pusat Koreksional Bintulu', 'Bintulu', '97000', 'Bintulu', 'Sarawak'],
            37 => ['Pusat Kota Kinabalu', 'Peti Surat 11020', '88811', 'Kota Kinabalu', 'Sabah'],
            38 => ['Penjara Wanita Kota Kinabalu', 'Kota Kinabalu', '88811', 'Kota Kinabalu', 'Sabah'],
            39 => ['Sekolah Henry Gurney Keningau', 'Keningau', '89007', 'Keningau', 'Sabah'],
            40 => ['Penjara Tawau', 'Tawau', '91008', 'Tawau', 'Sabah'],
            41 => ['Penjara Sandakan', 'Sandakan', '90716', 'Sandakan', 'Sabah'],
            42 => ['Penjara Lahad Datu', 'Lahad Datu', '91100', 'Tambunan', 'Sabah'],
            43 => ['Pusat Koreksional Labuan', 'Peti Surat 82275', '87000', 'Labuan', 'Labuan'],
            44 => ['Pusat Koreksional Chenderiang', 'Chenderiang', '35750', 'Hilir Perak', 'Perak'],
        ];

        // Map existing institution id (current DB order 1..30) to reference row number.
        $map = [
            1 => 1, 2 => 3, 3 => 2, 4 => 4, 5 => 5,
            6 => 6, 7 => 7, 8 => 10, 9 => 9, 10 => 8,
            11 => 11, 12 => 12, 13 => 13, 14 => 14, 15 => 15,
            16 => 16, 17 => 19, 18 => 18, 19 => 17, 20 => 20,
            21 => 24, 22 => 21, 23 => 22, 24 => 23, 25 => 26,
            26 => 25, 27 => 27, 28 => 28, 29 => 29, 30 => 30,
        ];

        $update = function ($institution, array $row) use ($getDistrict, $states) {
            [$name, $address, $postcode, $district, $state] = $row;
            $institution->update([
                'name' => $name,
                'address' => $address,
                'postcode' => $postcode,
                'state_id' => $states[$state],
                'district_id' => $getDistrict($district, $state),
                'updated_by' => 1,
            ]);
        };

        foreach ($data as $listNum => $row) {
            $id = array_search($listNum, $map);
            if ($id !== false) {
                $update(Institution::findOrFail($id), $row);
            } else {
                Institution::create([
                    'name' => $row[0],
                    'address' => $row[1],
                    'postcode' => $row[2],
                    'state_id' => $states[$row[4]],
                    'district_id' => $getDistrict($row[3], $row[4]),
                    'type' => 'Institusi',
                    'status' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }

    protected function cacheDistricts($states): array
    {
        $keyed = [];
        foreach (District::all() as $d) {
            $stateName = array_search($d->state_id, $states->toArray());
            $keyed[$stateName . '|' . $d->name] = $d->id;
        }
        return $keyed;
    }
}