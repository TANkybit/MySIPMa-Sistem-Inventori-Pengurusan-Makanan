// Prison Management System Data - Integrated from all files
const prisonData = {

    // States data from states.pdf
    states: [
        { id: 1, name: 'Johor' },
        { id: 2, name: 'Kedah' },
        { id: 3, name: 'Kelantan' },
        { id: 4, name: 'Melaka' },
        { id: 5, name: 'Negeri Sembilan' },
        { id: 6, name: 'Pahang' },
        { id: 7, name: 'Perak' },
        { id: 8, name: 'Perlis' },
        { id: 9, name: 'Pulau Pinang' },
        { id: 10, name: 'Sabah' },
        { id: 11, name: 'Sarawak' },
        { id: 12, name: 'Selangor' },
        { id: 13, name: 'Terengganu' },
        { id: 14, name: 'Wilayah Persekutuan' }
    ],

    // Complete list of 30 prison institutions from SENARAI INSTITUSI PENJARA
    institutions: [
        { id: 1, name: 'Pusat Koreksional Perlis', state: 'Perlis', capacity: 200, current: 185, type: 'Pusat Koreksional', status: 'active' },
        { id: 2, name: 'Penjara Sungai Petani, Kedah', state: 'Kedah', capacity: 350, current: 320, type: 'Penjara', status: 'active' },
        { id: 3, name: 'Penjara Alor Setar, Kedah', state: 'Kedah', capacity: 300, current: 280, type: 'Penjara', status: 'active' },
        { id: 4, name: 'Penjara Pokok Sena, Kedah', state: 'Kedah', capacity: 250, current: 235, type: 'Penjara', status: 'active' },
        { id: 5, name: 'Penjara Reman Pulau Pinang', state: 'Pulau Pinang', capacity: 180, current: 165, type: 'Penjara Reman', status: 'active' },
        { id: 6, name: 'Penjara Seberang Perai, Pulau Pinang', state: 'Pulau Pinang', capacity: 400, current: 380, type: 'Penjara', status: 'active' },
        { id: 7, name: 'Penjara Taiping, Perak', state: 'Perak', capacity: 500, current: 450, type: 'Penjara', status: 'active' },
        { id: 8, name: 'Pusat Koreksional Kamunting, Perak', state: 'Perak', capacity: 320, current: 290, type: 'Pusat Koreksional', status: 'active' },
        { id: 9, name: 'Pusat Koreksional Batu Gajah, Perak', state: 'Perak', capacity: 280, current: 250, type: 'Pusat Koreksional', status: 'active' },
        { id: 10, name: 'Penjara Tapah, Perak', state: 'Perak', capacity: 220, current: 200, type: 'Penjara', status: 'active' },
        { id: 11, name: 'Penjara Kajang, Selangor', state: 'Selangor', capacity: 450, current: 420, type: 'Penjara', status: 'active' },
        { id: 12, name: 'Penjara Wanita Kajang, Selangor', state: 'Selangor', capacity: 200, current: 185, type: 'Penjara', status: 'active' },
        { id: 13, name: 'Penjara Sungai Buloh, Selangor', state: 'Selangor', capacity: 600, current: 580, type: 'Penjara', status: 'active' },
        { id: 14, name: 'Pusat Koreksional Puncak Alam, Selangor', state: 'Selangor', capacity: 350, current: 300, type: 'Pusat Koreksional', status: 'active' },
        { id: 15, name: 'Penjara Seremban, Negeri Sembilan', state: 'Negeri Sembilan', capacity: 380, current: 350, type: 'Penjara', status: 'active' },
        { id: 16, name: 'Institusi Pemulihan Dadah Jelebu, Negeri Sembilan', state: 'Negeri Sembilan', capacity: 150, current: 130, type: 'Pusat Pemulihan', status: 'active' },
        { id: 17, name: 'Sekolah Henry Gurney Telek Mas, Melaka', state: 'Melaka', capacity: 120, current: 110, type: 'Sekolah Henry Gurney', status: 'active' },
        { id: 18, name: 'Penjara Dusun Dato Murad, Melaka', state: 'Melaka', capacity: 280, current: 260, type: 'Penjara', status: 'active' },
        { id: 19, name: 'Penjara Sungai Udang, Melaka', state: 'Melaka', capacity: 320, current: 290, type: 'Penjara', status: 'active' },
        { id: 20, name: 'Pusat Koreksional Jasin, Melaka', state: 'Melaka', capacity: 180, current: 165, type: 'Pusat Koreksional', status: 'active' },
        { id: 21, name: 'Pusat Koreksional Muar, Johor', state: 'Johor', capacity: 220, current: 200, type: 'Pusat Koreksional', status: 'active' },
        { id: 22, name: 'Penjara Simpang Renggam, Johor', state: 'Johor', capacity: 450, current: 420, type: 'Penjara', status: 'active' },
        { id: 23, name: 'Penjara Kluang, Johor', state: 'Johor', capacity: 300, current: 280, type: 'Penjara', status: 'active' },
        { id: 24, name: 'Pusat Koreksional Johor Bahru, Johor', state: 'Johor', capacity: 250, current: 230, type: 'Pusat Koreksional', status: 'active' },
        { id: 25, name: 'Penjara Penor, Pahang', state: 'Pahang', capacity: 280, current: 260, type: 'Penjara', status: 'active' },
        { id: 26, name: 'Penjara Bentong, Pahang', state: 'Pahang', capacity: 200, current: 185, type: 'Penjara', status: 'active' },
        { id: 27, name: 'Penjara Marang, Terengganu', state: 'Terengganu', capacity: 180, current: 165, type: 'Penjara', status: 'active' },
        { id: 28, name: 'Pusat Koreksional Dungun, Terengganu', state: 'Terengganu', capacity: 150, current: 130, type: 'Pusat Koreksional', status: 'active' },
        { id: 29, name: 'Penjara Pengkalan Chepa, Kelantan', state: 'Kelantan', capacity: 320, current: 290, type: 'Penjara', status: 'active' },
        { id: 30, name: 'Pusat Pemulihan Akhlak Machang, Kelantan', state: 'Kelantan', capacity: 120, current: 110, type: 'Pusat Pemulihan', status: 'active' }
    ],

    // Districts data from districts.pdf
    districts: [
        // Johor districts (state_id: 1)
        { id: 1, state_id: 1, name: 'Batu Pahat' },
        { id: 2, state_id: 1, name: 'Johor Bahru' },
        { id: 3, state_id: 1, name: 'Kluang' },
        { id: 4, state_id: 1, name: 'Kota Tinggi' },
        { id: 5, state_id: 1, name: 'Mersing' },
        { id: 6, state_id: 1, name: 'Muar' },
        { id: 7, state_id: 1, name: 'Pontian' },
        { id: 8, state_id: 1, name: 'Segamat' },
        { id: 9, state_id: 1, name: 'Tangkak' },
        { id: 10, state_id: 1, name: 'Kulai' },

        // Kedah districts (state_id: 2)
        { id: 11, state_id: 2, name: 'Baling' },
        { id: 12, state_id: 2, name: 'Bandar Baharu' },
        { id: 13, state_id: 2, name: 'Kota Setar' },
        { id: 14, state_id: 2, name: 'Kubang Pasu' },
        { id: 15, state_id: 2, name: 'Kulim' },
        { id: 16, state_id: 2, name: 'Langkawi' },
        { id: 17, state_id: 2, name: 'Pendang' },
        { id: 18, state_id: 2, name: 'Pokok Sena' },
        { id: 19, state_id: 2, name: 'Sik' },
        { id: 20, state_id: 2, name: 'Yan' },
        { id: 21, state_id: 2, name: 'Padang Terap' },

        // Continue with other states...
        // Kelantan (id: 3)
        { id: 22, state_id: 3, name: 'Bachok' },
        { id: 23, state_id: 3, name: 'Gua Musang' },
        { id: 24, state_id: 3, name: 'Jeli' },
        { id: 25, state_id: 3, name: 'Kota Bharu' },
        { id: 26, state_id: 3, name: 'Kuala Krai' },
        { id: 27, state_id: 3, name: 'Machang' },
        { id: 28, state_id: 3, name: 'Pasir Mas' },
        { id: 29, state_id: 3, name: 'Pasir Puteh' },
        { id: 30, state_id: 3, name: 'Tanah Merah' },
        { id: 31, state_id: 3, name: 'Tumpat' },

        // Melaka (id: 4)
        { id: 32, state_id: 4, name: 'Alor Gajah' },
        { id: 33, state_id: 4, name: 'Jasin' },
        { id: 34, state_id: 4, name: 'Melaka Tengah' },

        // Negeri Sembilan (id: 5)
        { id: 35, state_id: 5, name: 'Jelebu' },
        { id: 36, state_id: 5, name: 'Jempol' },
        { id: 37, state_id: 5, name: 'Kuala Pilah' },
        { id: 38, state_id: 5, name: 'Port Dickson' },
        { id: 39, state_id: 5, name: 'Rembau' },
        { id: 40, state_id: 5, name: 'Seremban' },
        { id: 41, state_id: 5, name: 'Tampin' },

        // Pahang (id: 6)
        { id: 42, state_id: 6, name: 'Bentong' },
        { id: 43, state_id: 6, name: 'Bera' },
        { id: 44, state_id: 6, name: 'Cameron Highlands' },
        { id: 45, state_id: 6, name: 'Jerantut' },
        { id: 46, state_id: 6, name: 'Kuantan' },
        { id: 47, state_id: 6, name: 'Lipis' },
        { id: 48, state_id: 6, name: 'Maran' },
        { id: 49, state_id: 6, name: 'Pekan' },
        { id: 50, state_id: 6, name: 'Raub' },
        { id: 51, state_id: 6, name: 'Rompin' },
        { id: 52, state_id: 6, name: 'Temerloh' },

        // Perak (id: 7)
        { id: 53, state_id: 7, name: 'Bagan Datuk' },
        { id: 54, state_id: 7, name: 'Batang Padang' },
        { id: 55, state_id: 7, name: 'Hilir Perak' },
        { id: 56, state_id: 7, name: 'Hulu Perak' },
        { id: 57, state_id: 7, name: 'Kampar' },
        { id: 58, state_id: 7, name: 'Kerian' },
        { id: 59, state_id: 7, name: 'Kinta' },
        { id: 60, state_id: 7, name: 'Larut, Matang dan Selama' },
        { id: 61, state_id: 7, name: 'Manjung' },
        { id: 62, state_id: 7, name: 'Muallim' },
        { id: 63, state_id: 7, name: 'Perak Tengah' },
        { id: 64, state_id: 7, name: 'Kuala Kangsar' },

        // Perlis (id: 8)
        { id: 65, state_id: 8, name: 'Kangar' },
        { id: 66, state_id: 8, name: 'Padang Besar' },
        { id: 67, state_id: 8, name: 'Arau' },

        // Pulau Pinang (id: 9)
        { id: 68, state_id: 9, name: 'Barat Daya' },
        { id: 69, state_id: 9, name: 'Timur Laut' },
        { id: 70, state_id: 9, name: 'Seberang Perai Utara' },
        { id: 71, state_id: 9, name: 'Seberang Perai Tengah' },
        { id: 72, state_id: 9, name: 'Seberang Perai Selatan' },

        // Selangor (id: 12)
        { id: 73, state_id: 12, name: 'Gombak' },
        { id: 74, state_id: 12, name: 'Hulu Langat' },
        { id: 75, state_id: 12, name: 'Hulu Selangor' },
        { id: 76, state_id: 12, name: 'Klang' },
        { id: 77, state_id: 12, name: 'Kuala Langat' },
        { id: 78, state_id: 12, name: 'Kuala Selangor' },
        { id: 79, state_id: 12, name: 'Petaling' },
        { id: 80, state_id: 12, name: 'Sabak Bernam' },
        { id: 81, state_id: 12, name: 'Sepang' },

        // Terengganu (id: 13)
        { id: 82, state_id: 13, name: 'Besut' },
        { id: 83, state_id: 13, name: 'Dungun' },
        { id: 84, state_id: 13, name: 'Hulu Terengganu' },
        { id: 85, state_id: 13, name: 'Kemaman' },
        { id: 86, state_id: 13, name: 'Kuala Terengganu' },
        { id: 87, state_id: 13, name: 'Marang' },
        { id: 88, state_id: 13, name: 'Setiu' },

        // Wilayah Persekutuan (id: 14)
        { id: 89, state_id: 14, name: 'Kuala Lumpur' },
        { id: 90, state_id: 14, name: 'Labuan' },
        { id: 91, state_id: 14, name: 'Putrajaya' }
    ],

    // Raw materials (Food)
    rawMaterials: [
        {
            "id": 1,
            "name": "DAGING LEMBU/KERBAU (BEKU)",
            "category": "DAGING LEMBU/KERBAU (BEKU)",
            "foodType": "pelbagai",
            "stock": 2640,
            "unit": "kg",
            "minStock": 528,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 2,
            "name": "2.1 Cencaru",
            "category": "IKAN SEGAR (LAUT)",
            "foodType": "pelbagai",
            "stock": 5656,
            "unit": "kg",
            "minStock": 1131,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 3,
            "name": "2.2 Kembung",
            "category": "IKAN SEGAR (LAUT)",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 4,
            "name": "2.3 Pelata",
            "category": "IKAN SEGAR (LAUT)",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 5,
            "name": "2.4 Sardin",
            "category": "IKAN SEGAR (LAUT)",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 6,
            "name": "2.5 Selar",
            "category": "IKAN SEGAR (LAUT)",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 7,
            "name": "TELUR AYAM (GRED B)",
            "category": "TELUR AYAM (GRED B)",
            "foodType": "pelbagai",
            "stock": 75401,
            "unit": "Biji",
            "minStock": 15080,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 8,
            "name": "a) Bayam Hijau",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 12065,
            "unit": "kg",
            "minStock": 2413,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 9,
            "name": "b) Kobis Bulat",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 6033,
            "unit": "kg",
            "minStock": 1206,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 10,
            "name": "c) Kobis Panjang",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 9049,
            "unit": "kg",
            "minStock": 1809,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 11,
            "name": "d) Sawi Hijau",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 6033,
            "unit": "kg",
            "minStock": 1206,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 12,
            "name": "e) Sawi Putih",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 6033,
            "unit": "kg",
            "minStock": 1206,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 13,
            "name": "a) Bendi",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 7541,
            "unit": "kg",
            "minStock": 1508,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 14,
            "name": "b) Kacang Buncis",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 15,
            "name": "c) Kacang Panjang",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 11311,
            "unit": "kg",
            "minStock": 2262,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 16,
            "name": "d) Ketola",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 1886,
            "unit": "kg",
            "minStock": 377,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 17,
            "name": "g) Kundur",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 1886,
            "unit": "kg",
            "minStock": 377,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 18,
            "name": "e) Labu Kuning",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 19,
            "name": "f) Lobak Merah",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 20,
            "name": "h) Terung",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 11311,
            "unit": "kg",
            "minStock": 2262,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 21,
            "name": "i) Timun",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 22,
            "name": "j) Tomato",
            "category": "SAYUR",
            "foodType": "pelbagai",
            "stock": 6223,
            "unit": "kg",
            "minStock": 1244,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 23,
            "name": "5.1 Betik",
            "category": "BUAH",
            "foodType": "pelbagai",
            "stock": 22621,
            "unit": "kg",
            "minStock": 4524,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 24,
            "name": "5.2 Nanas",
            "category": "BUAH",
            "foodType": "pelbagai",
            "stock": 22621,
            "unit": "kg",
            "minStock": 4524,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 25,
            "name": "5.3 Tembikai",
            "category": "BUAH",
            "foodType": "pelbagai",
            "stock": 16966,
            "unit": "kg",
            "minStock": 3393,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 26,
            "name": "5.4 Tembikai Susu",
            "category": "BUAH",
            "foodType": "pelbagai",
            "stock": 16966,
            "unit": "kg",
            "minStock": 3393,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 27,
            "name": "6.1 Fucuk",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 283,
            "unit": "kg",
            "minStock": 56,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 28,
            "name": "6.2 Gula",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 4525,
            "unit": "kg",
            "minStock": 905,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 29,
            "name": "6.3 Gula Merah",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 30,
            "name": "6.4 Ikan Bilis",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 1774,
            "unit": "kg",
            "minStock": 354,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 31,
            "name": "6.5 Jem",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 848,
            "unit": "kg",
            "minStock": 169,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 32,
            "name": "6.6 Kacang Hijau",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 943,
            "unit": "kg",
            "minStock": 188,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 33,
            "name": "6.7 Kacang Merah",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 943,
            "unit": "kg",
            "minStock": 188,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 34,
            "name": "6.8 Kaya",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 566,
            "unit": "kg",
            "minStock": 113,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 35,
            "name": "6.9 Kopi",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 1056,
            "unit": "kg",
            "minStock": 211,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 36,
            "name": "6.10 Marjerin",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 566,
            "unit": "kg",
            "minStock": 113,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 37,
            "name": "6.11 Tauhu",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 8485,
            "unit": "kg",
            "minStock": 1697,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 38,
            "name": "6.12 Teh",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 825,
            "unit": "kg",
            "minStock": 165,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 39,
            "name": "6.13 Ubi Kentang",
            "category": "PERLENGKAPAN",
            "foodType": "pelbagai",
            "stock": 3771,
            "unit": "kg",
            "minStock": 754,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 40,
            "name": "7.1 Asam Jawa",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 152,
            "unit": "kg",
            "minStock": 30,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 41,
            "name": "7.2 Asam Keping",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 42,
            "name": "7.3 Bawang Besar",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 585,
            "unit": "kg",
            "minStock": 117,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 43,
            "name": "7.4 Bawang Merah",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 679,
            "unit": "kg",
            "minStock": 135,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 44,
            "name": "7.5 Bawang Putih",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 1075,
            "unit": "kg",
            "minStock": 215,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 45,
            "name": "7.6 Belacan",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 76,
            "unit": "kg",
            "minStock": 15,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 46,
            "name": "7.7 Biji Lada Hitam",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 47,
            "name": "7.8 Buah Pelaga",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 104,
            "unit": "kg",
            "minStock": 20,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 48,
            "name": "7.9 Bunga Cengkih",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 104,
            "unit": "kg",
            "minStock": 20,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 49,
            "name": "7.10 Bunga Lawang",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 104,
            "unit": "kg",
            "minStock": 20,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 50,
            "name": "7.11 Cili",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 51,
            "name": "7.12 Cili Kering",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 302,
            "unit": "kg",
            "minStock": 60,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 52,
            "name": "7.13 Cili Padi",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 340,
            "unit": "kg",
            "minStock": 68,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 53,
            "name": "7.14 Cuka",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 54,
            "name": "7.15 Dal",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 55,
            "name": "7.16 Daun Bawang",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 57,
            "unit": "kg",
            "minStock": 11,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 56,
            "name": "7.17 Daun Kari",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 28,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 57,
            "name": "7.18 Daun Kesum",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 39,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 58,
            "name": "7.19 Daun Limau Purut",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 10,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 59,
            "name": "7.20 Daun Sup",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 57,
            "unit": "kg",
            "minStock": 11,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 60,
            "name": "7.21 Garam",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 3017,
            "unit": "kg",
            "minStock": 603,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 61,
            "name": "7.22 Halba",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 62,
            "name": "7.23 Halia",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 396,
            "unit": "kg",
            "minStock": 79,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 63,
            "name": "7.24 Kiub Tomyam",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 64,
            "name": "7.25 Kulit Kayu Manis",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 104,
            "unit": "kg",
            "minStock": 20,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 65,
            "name": "7.26 Limau Kasturi",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 66,
            "name": "7.27 Rempah Kari",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 114,
            "unit": "kg",
            "minStock": 22,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 67,
            "name": "7.28 Rempah Kurma",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 68,
            "name": "7.29 Rempah Sup",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 189,
            "unit": "kg",
            "minStock": 37,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 69,
            "name": "7.30 Serai",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 152,
            "unit": "kg",
            "minStock": 30,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 70,
            "name": "7.31 Serbuk Cili",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 71,
            "name": "7.32 Serbuk Kunyit",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 321,
            "unit": "kg",
            "minStock": 64,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 72,
            "name": "7.33 Serbuk Lada Sulah",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 73,
            "name": "7.34 Serbuk Santan",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 679,
            "unit": "kg",
            "minStock": 135,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 74,
            "name": "7.35 Suun",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 75,
            "name": "7.36 Taucu",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 19,
            "unit": "kg",
            "minStock": 10,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        },
        {
            "id": 76,
            "name": "7.37 Telur Asin",
            "category": "PERENCAH MENGIKUT MENU",
            "foodType": "pelbagai",
            "stock": 4713,
            "unit": "Biji",
            "minStock": 942,
            "price": 5.0,
            "status": "aktif",
            "description": "",
            "lastUpdated": "2026-02-15"
        }
    ],

    // Inmates data
    inmates: [
        { id: 1, name: 'Ahmad bin Hassan', institution: 'Penjara Kajang', status: 'active', admission: '2026-01-15', release: '2028-01-15', age: 35, offense: 'Kesalahan Dadah' },
        { id: 2, name: 'Siti binti Abdullah', institution: 'Penjara Wanita Kajang', status: 'active', admission: '2025-08-20', release: '2027-08-20', age: 28, offense: 'Kesalahan Jenayah Harta' },
        { id: 3, name: 'Rajesh a/l Kumar', institution: 'Penjara Sungai Buloh', status: 'active', admission: '2026-03-10', release: '2029-03-10', age: 42, offense: 'Kesalahan Rasuah' },
        { id: 4, name: 'Muthu a/l Palani', institution: 'Penjara Taiping', status: 'active', admission: '2025-11-05', release: '2028-11-05', age: 39, offense: 'Kesalahan Keganasan' },
        { id: 5, name: 'Lim Wei Sheng', institution: 'Penjara Sungai Petani', status: 'active', admission: '2026-05-22', release: '2027-05-22', age: 31, offense: 'Kesalahan Penipuan' },
        { id: 6, name: 'Ali bin Ismail', institution: 'Penjara Alor Setar', status: 'active', admission: '2026-02-14', release: '2028-02-14', age: 45, offense: 'Kesalahan Dadah' },
        { id: 7, name: 'Sara binti Mohd', institution: 'Penjara Wanita Kajang', status: 'active', admission: '2025-12-10', release: '2027-12-10', age: 29, offense: 'Kesalahan Jenayah' },
        { id: 8, name: 'Kumar a/l Raju', institution: 'Penjara Seremban', status: 'active', admission: '2026-04-18', release: '2029-04-18', age: 38, offense: 'Kesalahan Rasuah' },
        { id: 9, name: 'Tan Ah Kow', institution: 'Penjara Seberang Perai', status: 'active', admission: '2025-09-22', release: '2028-09-22', age: 52, offense: 'Kesalahan Penipuan' },
        { id: 10, name: 'Mohan a/l Singh', institution: 'Penjara Tapah', status: 'active', admission: '2026-07-30', release: '2027-07-30', age: 41, offense: 'Kesalahan Keganasan' }
    ],

    // Inden (Purchase Orders)
    inden: [
        { id: 1, number: 'IN-2026-0456', institution: 'Penjara Kajang', items: ['Beras - 1000kg', 'Minyak Masak - 200 liter'], amount: 12500, status: 'pending', date: '2026-02-15' },
        { id: 2, number: 'IN-2026-0455', institution: 'Penjara Sungai Buloh', items: ['Ayam - 500kg', 'Sayur Campur - 300kg'], amount: 8500, status: 'pending', date: '2026-02-14' },
        { id: 3, number: 'IN-2026-0454', institution: 'Penjara Taiping', items: ['Telur - 5000 unit', 'Susu - 200 liter'], amount: 3200, status: 'pending', date: '2026-02-13' },
        { id: 4, number: 'IN-2026-0453', institution: 'Penjara Alor Setar', items: ['Beras - 800kg', 'Gula - 200kg', 'Minyak - 150 liter'], amount: 18500, status: 'approved', date: '2026-02-12' },
        { id: 5, number: 'IN-2026-0452', institution: 'Penjara Seremban', items: ['Ayam - 300kg', 'Ikan Kembung - 200kg', 'Sayur - 250kg'], amount: 9500, status: 'approved', date: '2026-02-11' },
        { id: 6, number: 'IN-2026-0451', institution: 'Penjara Seberang Perai', items: ['Mee - 400kg', 'Biskut - 100 kotak'], amount: 4200, status: 'pending', date: '2026-02-10' },
        { id: 7, number: 'IN-2026-0450', institution: 'Pusat Koreksional Perlis', items: ['Daging Lembu - 150kg', 'Kentang - 200kg'], amount: 6800, status: 'approved', date: '2026-02-09' },
        { id: 8, number: 'IN-2026-0449', institution: 'Penjara Pokok Sena', items: ['Ikan Bilis - 80kg', 'Bawang - 100kg'], amount: 2400, status: 'rejected', date: '2026-02-08' }
    ],

    // Activities
    activities: [
        { id: 1, type: 'inden', title: 'Inden Baru Dibuat', description: 'Inden #IN-2026-0456 untuk Penjara A', time: '15 min lalu', icon: 'file-signature', color: 'primary' },
        { id: 2, type: 'material', title: 'Bahan Mentah Ditambah', description: 'Bahan mentah "Kain" ditambah ke inventori', time: '2 jam lalu', icon: 'box', color: 'warning' },
        { id: 3, type: 'inmate', title: 'Banduan Baru Didaftar', description: 'ID Banduan #INM-7823 didaftar di Penjara B', time: '5 jam lalu', icon: 'user-plus', color: 'info' },
        { id: 4, type: 'inden', title: 'Inden Disahkan', description: 'Inden #IN-2026-0450 disahkan oleh penyelia', time: '1 hari lalu', icon: 'check', color: 'success' },
        { id: 5, type: 'system', title: 'Sistem Dikemaskini', description: 'Versi sistem dikemaskini ke 2.1.0', time: '2 hari lalu', icon: 'sync', color: 'info' },
        { id: 6, type: 'institution', title: 'Institusi Baru Didaftar', description: 'Pusat Koreksional Muar berjaya didaftarkan', time: '3 hari lalu', icon: 'building', color: 'success' }
    ],

    // Charts data
    charts: {
        population: {
            months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogs', 'Sep', 'Okt', 'Nov', 'Dis'],
            data: [1240, 1250, 1235, 1248, 1260, 1245, 1255, 1265, 1270, 1245, 1250, 1260]
        },
        institutionTypes: {
            labels: ['Penjara', 'Pusat Koreksional', 'Penjara Reman', 'Pusat Pemulihan', 'Sekolah Henry Gurney'],
            data: [18, 8, 1, 2, 1],
            colors: ['#1a5632', '#2e7d57', '#0d3b1f', '#4c956c', '#6aab8c']
        },
        stateDistribution: {
            labels: ['Selangor', 'Johor', 'Perak', 'Kedah', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Terengganu', 'Kelantan', 'Pulau Pinang', 'Perlis'],
            data: [4, 4, 4, 3, 4, 2, 2, 2, 2, 2, 1],
            colors: ['#1a5632', '#2e7d57', '#0d3b1f', '#4c956c', '#6aab8c', '#8bc19c', '#a9d6b8', '#c6ebd4', '#e3fff0', '#f1fff8', '#ffffff']
        }
    },

    // System stats
    stats: {
        totalInmates: 1245,
        totalInstitutions: 30,
        totalMaterials: 15,
        pendingApprovals: 4,
        totalOrders: 8,
        inmateChange: 5.2,
        institutionChange: 2.0,
        materialChange: -3.2,
        approvalChange: 8.0
    },

    // Messages data
    messages: [
        {
            id: 1,
            sender: 'Supervisor A',
            senderId: 'sup_a',
            message: 'Hai Admin, ada mesyuarat esok pukul 10 pagi di Penjara Kajang.',
            time: '10:30 AM',
            date: '2026-02-15',
            read: true,
            avatar: 'SA'
        },
        {
            id: 2,
            sender: 'Admin',
            senderId: 'admin',
            message: 'Baik, terima kasih atas makluman. Saya akan hadir.',
            time: '10:32 AM',
            date: '2026-02-15',
            read: true,
            avatar: 'AP'
        },
        {
            id: 3,
            sender: 'Supervisor A',
            senderId: 'sup_a',
            message: 'Jangan lupa bawa laporan analitik bulanan.',
            time: '10:33 AM',
            date: '2026-02-15',
            read: true,
            avatar: 'SA'
        },
        {
            id: 4,
            sender: 'Operator B',
            senderId: 'op_b',
            message: 'Stok bahan hampir habis, perlu order baru.',
            time: '09:15 AM',
            date: '2026-02-15',
            read: false,
            avatar: 'OB'
        },
        {
            id: 5,
            sender: 'Manager C',
            senderId: 'mgr_c',
            message: 'Laporan bulanan perlu disiapkan sebelum Jumaat.',
            time: '04:20 PM',
            date: '2026-02-14',
            read: true,
            avatar: 'MC'
        }
    ],

    // Calendar events
    calendarEvents: [
        {
            id: 1,
            title: 'Mesyuarat Pengurusan',
            start: '2026-02-16T10:00:00',
            end: '2026-02-16T12:00:00',
            color: '#1a5632',
            location: 'Penjara Kajang',
            description: 'Mesyuarat bulanan pengurusan semua institusi'
        },
        {
            id: 2,
            title: 'Lawatan Pemeriksaan',
            start: '2026-02-18T14:00:00',
            end: '2026-02-18T16:00:00',
            color: '#198754',
            location: 'Penjara Sungai Buloh',
            description: 'Lawatan pemeriksaan oleh pihak berkuasa'
        },
        {
            id: 3,
            title: 'Latihan Kakitangan',
            start: '2026-02-20T09:00:00',
            end: '2026-02-20T17:00:00',
            color: '#ffc107',
            location: 'Pusat Latihan',
            description: 'Latihan peningkatan kemahiran untuk kakitangan'
        },
        {
            id: 4,
            title: 'Audit Dalaman',
            start: '2026-02-25T08:00:00',
            end: '2026-02-26T17:00:00',
            color: '#0dcaf0',
            location: 'Semua Institusi',
            description: 'Audit dalaman sistem dan operasi'
        }
    ],

    // Users data
    users: [
        {
            id: 1,
            name: 'Pengarah HQ',
            email: 'pengarah.hq@prison.gov.my',
            role: 'Admin',
            institution: 'Semua Institusi',
            position: 'Pengarah HQ',
            phone_number: '03-8888 1000',
            status: 'active',
            joinDate: '2026-01-01',
            lastLogin: '2026-02-15 10:30:00',
            avatar: 'PH'
        },
        {
            id: 2,
            name: 'Pengarah Negeri',
            email: 'pengarah.negeri@prison.gov.my',
            role: 'Admin',
            institution: 'Negeri Selangor',
            position: 'Pengarah Negeri',
            phone_number: '03-8733 2001',
            status: 'active',
            joinDate: '2026-02-15',
            lastLogin: '2026-02-15 09:15:00',
            avatar: 'PN'
        },
        {
            id: 3,
            name: 'Pengarah Institusi',
            email: 'pengarah.institusi@prison.gov.my',
            role: 'Admin',
            institution: 'Penjara Kajang',
            position: 'Pengarah Institusi',
            phone_number: '03-6142 3002',
            status: 'active',
            joinDate: '2026-03-10',
            lastLogin: '2026-02-15 08:45:00',
            avatar: 'PI'
        },
        {
            id: 4,
            name: 'Pegawai Penerima',
            email: 'pegawai.penerima@prison.gov.my',
            role: 'User',
            institution: 'Penjara Kajang',
            position: 'Pegawai Penerima',
            phone_number: '03-5544 4003',
            status: 'active',
            joinDate: '2026-04-05',
            lastLogin: '2026-02-14 16:20:00',
            avatar: 'PP'
        },
        {
            id: 5,
            name: 'Pegawai Pengesah',
            email: 'pegawai.pengesah@prison.gov.my',
            role: 'User',
            institution: 'Penjara Sungai Buloh',
            position: 'Pegawai Pengesah',
            phone_number: '03-6677 5004',
            status: 'active',
            joinDate: '2026-05-01',
            lastLogin: '2026-02-14 14:10:00',
            avatar: 'PP'
        },
        {
            id: 6,
            name: 'Pegawai Stor',
            email: 'pegawai.stor@prison.gov.my',
            role: 'User',
            institution: 'Pusat Koreksional',
            position: 'Pegawai Stor',
            phone_number: '03-7788 6005',
            status: 'active',
            joinDate: '2026-06-01',
            lastLogin: '2026-02-14 12:00:00',
            avatar: 'PS'
        }
    ],

    // Reports data
    reports: [
        {
            id: 1,
            name: 'Laporan Bulanan Februari 2026',
            type: 'pdf',
            size: '2.4 MB',
            date: '2026-02-01',
            downloads: 45
        },
        {
            id: 2,
            name: 'Analisis Statistik Q1 2026',
            type: 'excel',
            size: '3.1 MB',
            date: '2026-02-05',
            downloads: 32
        },
        {
            id: 3,
            name: 'Laporan Audit Dalaman',
            type: 'pdf',
            size: '4.2 MB',
            date: '2026-02-10',
            downloads: 28
        },
        {
            id: 4,
            name: 'Data Demografi Banduan 2026',
            type: 'excel',
            size: '5.6 MB',
            date: '2026-02-12',
            downloads: 21
        }
    ],

    // Positions (Jawatan)
    positions: [
        { id: 1, title: 'Pengarah Penjara', grade: 'KA52', department: 'Pengurusan Tertinggi', status: 'active' },
        { id: 2, title: 'Timbalan Pengarah', grade: 'KA48', department: 'Pengurusan', status: 'active' },
        { id: 3, title: 'Ketua Inspektor Penjara', grade: 'KA44', department: 'Operasi', status: 'active' },
        { id: 4, title: 'Inspektor Penjara', grade: 'KA41', department: 'Keselamatan', status: 'active' },
        { id: 5, title: 'Sarjan Mejar Penjara', grade: 'KA32', department: 'Keselamatan', status: 'active' },
        { id: 6, title: 'Sarjan Penjara', grade: 'KA29', department: 'Logistik', status: 'active' },
        { id: 7, title: 'Koperal Penjara', grade: 'KA24', department: 'Vokasional', status: 'active' },
        { id: 8, title: 'Warder Penjara', grade: 'KA19', department: 'Unit Kawalan', status: 'active' }
    ],

    // Suppliers (Pembekal)
    suppliers: [
        {
            id: 1,
            company_name: 'Syarikat Makanan Segar Sdn Bhd',
            contact_person: 'Ahmad Faizal bin Ramli',
            email: 'sales@makanansegar.com',
            phone_number: '03-8888 1234',
            address: 'No. 12, Jalan Industri 3, Taman Perindustrian Kajang',
            postcode: '43000',
            state: 'Selangor',
            district: 'Hulu Langat',
            status: 1,
            created_at: '2025-01-10'
        },
        {
            id: 2,
            company_name: 'Pembekal Tekstil Maju Sdn Bhd',
            contact_person: 'Lim Boon Keat',
            email: 'info@tekstilmaju.com',
            phone_number: '03-7777 5678',
            address: 'Lot 45, Kawasan Perindustrian Puchong',
            postcode: '47100',
            state: 'Selangor',
            district: 'Puchong',
            status: 1,
            created_at: '2025-02-14'
        },
        {
            id: 3,
            company_name: 'Peralatan Keselamatan Jitu Sdn Bhd',
            contact_person: 'Suresh a/l Rajan',
            email: 'support@jituhq.com',
            phone_number: '03-9999 9012',
            address: 'Unit B-3, Plaza Sentral, Kuala Lumpur',
            postcode: '50470',
            state: 'Wilayah Persekutuan',
            district: 'Kuala Lumpur',
            status: 1,
            created_at: '2025-03-05'
        },
        {
            id: 4,
            company_name: 'Hardware & Construction Supplies Bhd',
            contact_person: 'Tan Ah Seng',
            email: 'sales@hcs.com.my',
            phone_number: '04-8888 3456',
            address: 'No. 88, Jalan Perindustrian, Sungai Petani',
            postcode: '08000',
            state: 'Kedah',
            district: 'Sungai Petani',
            status: 0,
            created_at: '2025-04-20'
        },
        {
            id: 5,
            company_name: 'Pustaka Ilmu Enterprise',
            contact_person: 'Siti Norzahara binti Yusof',
            email: 'orders@pustakailmu.com',
            phone_number: '03-6666 7890',
            address: 'Wisma Ilmu, Jalan Tun Hussein Onn, Shah Alam',
            postcode: '40150',
            state: 'Selangor',
            district: 'Shah Alam',
            status: 1,
            created_at: '2025-05-18'
        }
    ],

    // Item Categories (Kategori Barang)
    categories: [
        { id: 1, code: 'CAT-001', name: 'DAGING LEMBU/KERBAU (BEKU)', description: 'Kategori bahan mentah daging beku', totalItems: 1, status: 'active' },
        { id: 2, code: 'CAT-002', name: 'IKAN SEGAR (LAUT)', description: 'Kategori ikan segar laut', totalItems: 5, status: 'active' },
        { id: 3, code: 'CAT-003', name: 'TELUR AYAM (GRED B)', description: 'Kategori telur ayam gred B', totalItems: 1, status: 'active' },
        { id: 4, code: 'CAT-004', name: 'SAYUR', description: 'Kategori sayur-sayuran', totalItems: 15, status: 'active' },
        { id: 5, code: 'CAT-005', name: 'BUAH', description: 'Kategori buah-buahan', totalItems: 4, status: 'active' },
        { id: 6, code: 'CAT-006', name: 'PERLENGKAPAN', description: 'Kategori bahan pelengkap makanan seperti gula, fucuk dan ikan bilis', totalItems: 13, status: 'active' },
        { id: 7, code: 'CAT-007', name: 'PERENCAH MENGIKUT MENU', description: 'Kategori perencah dan rempah mengikut menu', totalItems: 37, status: 'active' }
    ],

    // Items (Item List - Extended Raw Materials)
    items: [
        { id: 1, code: 'ITM-001', name: 'Beras Super Spesial 10kg', category: 'Bahan Mentah Kering', stock: 500, unit: 'Beg', status: 'active' },
        { id: 2, code: 'ITM-002', name: 'Minyak Masak 5kg', category: 'Bahan Mentah Kering', stock: 200, unit: 'Botol', status: 'active' },
        { id: 3, code: 'ITM-003', name: 'Gula Pasir 1kg', category: 'Bahan Mentah Kering', stock: 1000, unit: 'Paket', status: 'active' },
        { id: 4, code: 'ITM-004', name: 'Ikan Kembung', category: 'Bahan Mentah Basah', stock: 50, unit: 'kg', status: 'active' },
        { id: 5, code: 'ITM-005', name: 'Ayam Proses', category: 'Bahan Mentah Basah', stock: 100, unit: 'kg', status: 'active' },
        { id: 6, code: 'ITM-006', name: 'Baju Banduan (Merah)', category: 'Pakaian Banduan', stock: 500, unit: 'Helai', status: 'active' },
        { id: 7, code: 'ITM-007', name: 'Seluar Banduan (Putih)', category: 'Pakaian Banduan', stock: 450, unit: 'Helai', status: 'active' },
        { id: 8, code: 'ITM-008', name: 'Sabun Mandi', category: 'Kebersihan Diri', stock: 2000, unit: 'Ketul', status: 'active' }
    ]

    // NOTE: The helper functions you had here should be moved to DataHelpers below
};

// Helper functions
const DataHelpers = {
    // Get institutions by state
    getInstitutionsByState(state) {
        return prisonData.institutions.filter(inst => inst.state === state);
    },

    // Get institutions by type
    getInstitutionsByType(type) {
        return prisonData.institutions.filter(inst => inst.type === type);
    },

    // Get materials by status
    getMaterialsByStatus(status) {
        return prisonData.rawMaterials.filter(mat => mat.status === status);
    },

    // Get materials by food type
    getMaterialsByFoodType(foodType) {
        return prisonData.rawMaterials.filter(mat => mat.foodType === foodType);
    },

    // Get districts by state
    getDistrictsByState(stateId) {
        return prisonData.districts.filter(district => district.state_id === stateId);
    },

    // Get state by name
    getStateByName(stateName) {
        return prisonData.states.find(state => state.name === stateName);
    },

    // Get stock status
    getStockStatus(stock, minStock) {
        const percentage = (stock / minStock) * 100;
        if (percentage >= 150) {
            return { status: 'Cukup', class: 'success', percentage: Math.round(percentage) };
        } else if (percentage >= 100) {
            return { status: 'Sederhana', class: 'warning', percentage: Math.round(percentage) };
        } else {
            return { status: 'Kritikal', class: 'danger', percentage: Math.round(percentage) };
        }
    },

    getForecastRisk(monthsRemaining) {
        if (monthsRemaining === null || monthsRemaining === undefined || Number.isNaN(monthsRemaining)) {
            return { text: 'Tidak Cukup Data', class: 'secondary' };
        }

        if (monthsRemaining <= 1) {
            return { text: 'Habis Bulan Ini', class: 'danger' };
        }

        if (monthsRemaining <= 3) {
            return { text: 'Habis 3 Bulan', class: 'warning' };
        }

        if (monthsRemaining <= 6) {
            return { text: 'Akan Habis 6 Bulan', class: 'warning' };
        }

        return { text: 'Cukup >6 Bulan', class: 'success' };
    },

    // Get food type label
    getFoodTypeLabel(foodType) {
        const labels = {
            'bijirin': 'Bijirin & Cereal',
            'protein': 'Protein (Daging/Ikan)',
            'sayur': 'Sayur-sayuran',
            'buah': 'Buah-buahan',
            'tenusu': 'Tenusu',
            'minuman': 'Minuman',
            'perasa': 'Perasa & Rempah',
            'lain': 'Lain-lain'
        };
        return labels[foodType] || foodType;
    },

    // Get status label
    getStatusLabel(status) {
        const labels = {
            'aktif': 'Aktif',
            'tidak_aktif': 'Tidak Aktif',
            'pending': 'Menunggu',
            'approved': 'Disahkan',
            'rejected': 'Ditolak',
            'active': 'Aktif',
            'inactive': 'Tidak Aktif',
            'maintenance': 'Penyelenggaraan'
        };
        return labels[status] || status;
    },

    // Get status badge class
    getStatusBadgeClass(status) {
        const classes = {
            'aktif': 'success',
            'active': 'success',
            'pending': 'warning',
            'approved': 'success',
            'rejected': 'danger',
            'inactive': 'secondary',
            'maintenance': 'info'
        };
        return classes[status] || 'secondary';
    },

    // Calculate total inventory value
    calculateInventoryValue() {
        return prisonData.rawMaterials.reduce((total, material) => {
            if (material.status === 'aktif') {
                return total + (material.stock * (material.price || 0));
            }
            return total;
        }, 0);
    },

    // Format currency
    formatCurrency(amount) {
        return new Intl.NumberFormat('ms-MY', {
            style: 'currency',
            currency: 'MYR',
            minimumFractionDigits: 2
        }).format(amount);
    },

    // Format date
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('ms-MY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    },

    // Calculate institution usage percentage
    getInstitutionUsage(institution) {
        return Math.round((institution.current / institution.capacity) * 100);
    },

    // Get institution status
    getInstitutionStatus(institution) {
        // Respect explicit status field first
        if (institution.status === 'inactive') return { text: 'Tidak Aktif', class: 'secondary' };
        if (institution.status === 'maintenance') return { text: 'Penyelenggaraan', class: 'info' };
        // Fall back to usage-based status
        const usage = this.getInstitutionUsage(institution);
        if (usage >= 95) return { text: 'Penuh', class: 'danger' };
        if (usage >= 85) return { text: 'Hampir Penuh', class: 'warning' };
        return { text: 'Aktif', class: 'success' };
    },

    // Get institution type label
    getInstitutionTypeLabel(type) {
        const labels = {
            'Penjara': 'Penjara',
            'Pusat Koreksional': 'Pusat Koreksional',
            'Penjara Reman': 'Penjara Reman',
            'Pusat Pemulihan': 'Pusat Pemulihan',
            'Sekolah Henry Gurney': 'Sekolah Henry Gurney'
        };
        return labels[type] || type;
    },

    // Generate random data for demo
    generateRandomData(count, min, max) {
        const data = [];
        for (let i = 0; i < count; i++) {
            data.push(Math.floor(Math.random() * (max - min + 1)) + min);
        }
        return data;
    },

    // Update stats
    updateStats() {
        const stats = {
            totalInmates: prisonData.inmates.length * 124, // Approximation
            totalInstitutions: prisonData.institutions.length,
            totalMaterials: prisonData.rawMaterials.length,
            pendingApprovals: prisonData.inden.filter(order => order.status === 'pending').length,
            totalOrders: prisonData.inden.length
        };

        prisonData.stats = { ...prisonData.stats, ...stats };
        return prisonData.stats;
    },

    // Add new institution
    addInstitution(data) {
        const newId = Math.max(...prisonData.institutions.map(i => i.id)) + 1;
        const newInstitution = {
            id: newId,
            name: data.name,
            state: data.state,
            state_id: data.state_id || null,
            district_id: data.district_id || null,
            type: data.type,                               // Jenis institusi
            capacity: parseInt(data.capacity) || 0,        // Kapasiti
            current: Math.floor((parseInt(data.capacity) || 0) * 0.8), // Default 80% filled
            status: data.status || 'active',               // Status: active/inactive/maintenance
            address: data.address || '',                   // Alamat
            postcode: data.postcode || '',                 // Poskod
            phone: data.phone || '',                       // No telefon
            created_at: new Date().toISOString().split('T')[0]
        };
        prisonData.institutions.push(newInstitution);
        return newInstitution;
    },

    // Add new material
    addMaterial(data) {
        const newId = Math.max(...prisonData.rawMaterials.map(m => m.id)) + 1;
        const newMaterial = {
            id: newId,
            name: data.name,
            category: data.category || 'makanan',
            foodType: data.foodType || 'lain',
            stock: parseInt(data.stock),
            unit: data.unit,
            minStock: parseInt(data.minStock),
            price: parseFloat(data.price),
            status: 'aktif',
            description: data.description || '',
            lastUpdated: new Date().toISOString().split('T')[0]
        };
        prisonData.rawMaterials.push(newMaterial);
        return newMaterial;
    },

    // Add new inmate
    addInmate(data) {
        const newId = Math.max(...prisonData.inmates.map(i => i.id)) + 1;
        const newInmate = {
            id: newId,
            name: data.name,
            institution: data.institution,
            status: 'active',
            admission: data.admission,
            release: data.release,
            age: parseInt(data.age),
            offense: data.offense
        };
        prisonData.inmates.push(newInmate);
        return newInmate;
    },

    // Add new order
    addOrder(data) {
        const newId = prisonData.inden.length + 1;
        const newOrder = {
            id: newId,
            number: `IN-2026-${String(1000 + newId).substring(1)}`,
            institution: data.institution,
            items: data.items,
            amount: parseFloat(data.amount),
            status: 'pending',
            date: new Date().toISOString().split('T')[0]
        };
        prisonData.inden.unshift(newOrder);
        return newOrder;
    },

    // Message and calendar helper functions (moved from inside prisonData)
    getMessagesBySender(senderId) {
        return prisonData.messages.filter(msg => msg.senderId === senderId);
    },

    getUnreadMessagesCount() {
        return prisonData.messages.filter(msg => !msg.read).length;
    },

    addMessage(data) {
        const newId = Math.max(...prisonData.messages.map(m => m.id)) + 1;
        const newMessage = {
            id: newId,
            sender: data.sender,
            senderId: data.senderId,
            message: data.message,
            time: new Date().toLocaleTimeString('ms-MY', {
                hour: '2-digit',
                minute: '2-digit'
            }),
            date: new Date().toISOString().split('T')[0],
            read: false,
            avatar: data.avatar || 'U'
        };
        prisonData.messages.unshift(newMessage);
        return newMessage;
    },

    addCalendarEvent(data) {
        const newId = Math.max(...prisonData.calendarEvents.map(e => e.id)) + 1;
        const newEvent = {
            id: newId,
            title: data.title,
            start: data.start,
            end: data.end,
            color: data.color || '#1a5632',
            location: data.location || '',
            description: data.description || ''
        };
        prisonData.calendarEvents.push(newEvent);
        return newEvent;
    },

    getEventsForDate(dateString) {
        return prisonData.calendarEvents.filter(event =>
            event.start.startsWith(dateString)
        );
    },

    getUpcomingEvents(count = 5) {
        const today = new Date().toISOString().split('T')[0];
        return prisonData.calendarEvents
            .filter(event => event.start >= today)
            .sort((a, b) => a.start.localeCompare(b.start))
            .slice(0, count);
    }
};

// Export data and helpers
window.prisonData = prisonData;
window.DataHelpers = DataHelpers;

console.log('Prison Management System data loaded successfully');
