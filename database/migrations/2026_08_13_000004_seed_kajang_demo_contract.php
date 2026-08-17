<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $institutionId = 11; // Penjara Kajang (existing institution)
        $supplier = DB::table('suppliers')->where('company_name', 'Pembekal Demo Kajang 2026')->first();
        $supplierId = $supplier?->id ?? DB::table('suppliers')->insertGetId([
            'state_id' => 14,
            'company_name' => 'Pembekal Demo Kajang 2026',
            'contact_person' => 'Pentadbir Demo Kajang',
            'email' => 'pembekal.kajang.demo@mysipma.test',
            'phone_number' => '0000000000',
            'address' => 'Rekod demonstrasi sahaja',
            'postcode' => '43000',
            'status' => 1,
            'created_at' => $now,
            'created_by' => 1,
        ]);

        $contract = DB::table('contracts')->where('contract_no', 'DEMO/KAJANG/CATUAN/2026')->first();
        $contractId = $contract?->id ?? DB::table('contracts')->insertGetId([
            'contract_no' => 'DEMO/KAJANG/CATUAN/2026',
            'institution_id' => $institutionId,
            'supplier_id' => $supplierId,
            'start_date' => '2026-01-01',
            'end_date' => '2028-12-31',
            'total_value' => 36339128.80,
            'status' => 'Active',
            'created_at' => $now,
            'created_by' => 1,
        ]);

        $lines = [
            ['DAGING LEMBU/KERBAU (BEKU)', 'kg', 52806, 27], ['Cencaru', 'kg', 113126, 11], ['Kembung', 'kg', 75426, 16], ['Pelata', 'kg', 75426, 13], ['Sardin', 'kg', 75426, 11], ['Selar', 'kg', 75426, 16], ['Telur Ayam (Gred B)', 'Biji', 1508026, .60],
            ['Bayam Hijau','kg',241306,6],['Kobis Bulat','kg',120666,4.5],['Kobis Panjang','kg',180986,5],['Sawi Hijau','kg',120666,7],['Sawi Putih','kg',120666,6.5],['Bendi','kg',150826,10],['Kacang Buncis','kg',75426,12],['Kacang Panjang','kg',226226,9],['Ketola','kg',37726,7.5],['Kundur','kg',37726,3.5],['Labu Kuning','kg',75426,4],['Lobak Merah','kg',75426,5],['Terung','kg',226226,8],['Timun','kg',75426,4],['Tomato','kg',124462,7.5],['Betik','kg',452426,4.5],['Nanas','kg',452426,5],['Tembikai','kg',339326,4],['Tembikai Susu','kg',339326,6],
            ['Fucuk','kg',5668,22.5],['Gula','kg',90506,4],['Gula Merah','kg',3796,7],['Ikan Bilis','kg',35490,35],['Jem','kg',16978,13.5],['Kacang Hijau','kg',18876,9],['Kacang Merah','kg',18876,11],['Kaya','kg',11336,13.5],['Kopi','kg',21138,22.5],['Marjerin','kg',11336,12],['Tauhu','kg',169702,7.5],['Teh','kg',16510,24],['Ubi Kentang','kg',75426,4.5],
            ['Asam Jawa','kg',3042,11.5],['Asam Keping','kg',390,28],['Bawang Besar','kg',11700,4.2],['Bawang Merah','kg',13598,9.5],['Bawang Putih','kg',21502,9],['Belacan','kg',1534,22],['Biji Lada Hitam','kg',390,45],['Buah Pelaga','kg',2080,130],['Bunga Cengkih','kg',2080,60],['Bunga Lawang','kg',2080,50],['Cili','kg',3796,13],['Cili Kering','kg',6058,26],['Cili Padi','kg',6812,15],['Cuka','kg',390,3],['Dal','kg',3796,7],['Daun Bawang','kg',1144,16],['Daun Kari','kg',572,12],['Daun Kesum','kg',780,12],['Daun Limau Purut','kg',208,18],['Daun Sup','kg',1144,18],['Garam','kg',60346,1.4],['Halba','kg',390,14],['Halia','kg',7930,7],['Kiub Tomyam','kg',390,36],['Kulit Kayu Manis','kg',2080,42],['Limau Kasturi','kg',3796,7.5],['Rempah Kari','kg',2288,19],['Rempah Kurma','kg',3796,19],['Rempah Sup','kg',3796,19],['Serai','kg',3042,4.5],['Serbuk Cili','kg',390,24],['Serbuk Kunyit','kg',6422,22],['Serbuk Lada Sulah','kg',390,50],['Serbuk Santan','kg',13598,30],['Suun','kg',390,16],['Taucu','kg',390,8.5],['Telur Asin','Biji',94276,1.8],
        ];
        $uoms = DB::table('uom')->pluck('id', 'code');
        $items = DB::table('items')->pluck('id', 'name');
        foreach ($lines as [$name, $unit, $quantity, $price]) {
            if (!$items->has($name) || DB::table('contract_items')->where('contract_id', $contractId)->where('item_id', $items[$name])->exists()) continue;
            DB::table('contract_items')->insert(['contract_id'=>$contractId,'item_id'=>$items[$name],'uom_id'=>$uoms[$unit],'estimated_quantity'=>$quantity,'unit_price'=>$price,'is_internally_supplied'=>0,'notes'=>'Jadual B Kajang 2026 — data demo','created_at'=>$now,'created_by'=>1]);
        }

        if (!DB::table('ceiling_limits')->where('contract_id', $contractId)->exists()) {
            DB::table('ceiling_limits')->insert(['institution_id'=>$institutionId,'contract_id'=>$contractId,'contract_limit'=>36339128.80,'yearly_limit'=>12113042.93,'monthly_limit'=>1009420.24,'used_quantity'=>0,'status'=>1,'created_at'=>$now,'created_by'=>1]);
        }

        $roles = DB::table('roles')->pluck('id', 'role_name');
        $positions = DB::table('positions')->pluck('id', 'code');
        foreach ([
            ['Stor Demo Kajang','stor.kajang.demo@mysipma.test','pegawai stor','PS'],
            ['Penerima Demo Kajang','penerima.kajang.demo@mysipma.test','pegawai penerima','PR'],
            ['Pengesah Demo Kajang','pengesah.kajang.demo@mysipma.test','pegawai pengesah','PP'],
        ] as [$name,$email,$role,$position]) {
            if (DB::table('users')->where('email', $email)->exists()) continue;
            DB::table('users')->insert(['institution_id'=>$institutionId,'role_id'=>$roles[$role],'position_id'=>$positions[$position],'name'=>$name,'email'=>$email,'password'=>Hash::make('DemoKajang2026!'),'status'=>1,'created_at'=>$now,'created_by'=>1]);
        }
    }

    public function down(): void
    {
        $contractId = DB::table('contracts')->where('contract_no', 'DEMO/KAJANG/CATUAN/2026')->value('id');
        if ($contractId) { DB::table('ceiling_limits')->where('contract_id',$contractId)->delete(); DB::table('contract_items')->where('contract_id',$contractId)->delete(); DB::table('contracts')->where('id',$contractId)->delete(); }
        DB::table('users')->whereIn('email',['stor.kajang.demo@mysipma.test','penerima.kajang.demo@mysipma.test','pengesah.kajang.demo@mysipma.test'])->delete();
        DB::table('suppliers')->where('company_name','Pembekal Demo Kajang 2026')->delete();
    }
};
