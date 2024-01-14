<?php

use Illuminate\Database\Seeder;

class UvcTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data from the table
        DB::table('u_v_c_codes')->truncate();

        // Add new data
        $uvc_codes = [
            ['uvcCodeName' => 'HH64FWPE'],
            ['uvcCodeName' => 'BBMNS9ZJ'],
            ['uvcCodeName' => 'KYMK9PUH'],
            ['uvcCodeName' => 'WL3K3YPT'],
            ['uvcCodeName' => 'JA9WCMAS'],
            ['uvcCodeName' => 'Z93G7PN9'],
            ['uvcCodeName' => 'WPC5GEHA'],
            ['uvcCodeName' => 'RXLNLTA6'],
            ['uvcCodeName' => '7XUFD78Y'],
            ['uvcCodeName' => 'DBP4GQBQ'],
            ['uvcCodeName' => 'ZSRBTK9S'],
            ['uvcCodeName' => 'B7DMPWCQ'],
            ['uvcCodeName' => 'YADA47RL'],
            ['uvcCodeName' => '9GTZQNKB'],
            ['uvcCodeName' => 'KSM9NB5L'],
            ['uvcCodeName' => 'BQCRWTSG'],
            ['uvcCodeName' => 'ML5NSKKG'],
            ['uvcCodeName' => 'D5BG6FDH'],
            ['uvcCodeName' => '2LJFM6PM'],
            ['uvcCodeName' => '38NWLPY3'],
            ['uvcCodeName' => '2TEHRTHJ'],
            ['uvcCodeName' => 'G994LD9T'],
            ['uvcCodeName' => 'Q452KVQE'],
            ['uvcCodeName' => '75NKUXAH'],
            ['uvcCodeName' => 'DHKVCU8T'],
            ['uvcCodeName' => 'TH9A6HUB'],
            ['uvcCodeName' => '2E5BHT5R'],
            ['uvcCodeName' => '556JTA32'],
            ['uvcCodeName' => 'LUFKZAHW'],
            ['uvcCodeName' => 'DBAD57ZR'],
            ['uvcCodeName' => 'K96JNSXY'],
            ['uvcCodeName' => 'PFXB8QXM'],
            ['uvcCodeName' => '8TEXF2HD'],
            ['uvcCodeName' => 'N6HBFD2X'],
            ['uvcCodeName' => 'K3EVS3NM'],
            ['uvcCodeName' => '5492AC6V'],
            ['uvcCodeName' => 'U5LGC65X'],
            ['uvcCodeName' => 'BKMKJN5S'],
            ['uvcCodeName' => 'JF2QD3UF'],
            ['uvcCodeName' => 'NW9ETHS7'],
            ['uvcCodeName' => 'VFBH8W6W'],
            ['uvcCodeName' => '7983XU4M'],
            ['uvcCodeName' => '2GYDT5D3'],
            ['uvcCodeName' => 'LVTFN8G5'],
            ['uvcCodeName' => 'UNP4A5T7'],
            ['uvcCodeName' => 'UMT3RLVS'],
            ['uvcCodeName' => 'TZZZCJV8'],
            ['uvcCodeName' => 'UVE5M7FR'],
            ['uvcCodeName' => 'W44QP7XJ'],
            ['uvcCodeName' => '9FCV9RMT'],
            // Add more UVCCodes as needed
        ];

        // Insert data into the 'UVCCode' table
        DB::table('u_v_c_codes')->insert($uvc_codes);
    }
}
