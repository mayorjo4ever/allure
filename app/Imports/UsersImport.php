<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

// class UsersImport implements ToCollection, WithHeadingRow
class UsersImport implements OnEachRow, WithHeadingRow, WithChunkReading
{
    public int $inserted = 0;
    public int $updated = 0;
    /**
    * @param Collection $collection
    */
    
    /** 
     * 
     * @param Collection $rows
     */
    
    public function onRow(Row $row){
        $r = $row->toArray();
       # dd($r);
       ## if (!isset($r['regno'])) return;

        /*$existing = User::where('regno', $r['regno'])
           ->where('year', $year)
           ->first(); */

        /** if ($existing) {
            $existing->update([
                'raw_name' => $r['name'] ?? '',
                'raw_programme' => $r['programme'] ?? '',
                'approve_date_id' => $current_approval->id
            ]);
            $this->updated++;
        } else { **/
            User::create([
                'regno'       => $r['regno'],
                'firstname'   => $r['firstname'],
                'othername'   => $r['othername'],
                'surname'     => $r['surname'],
                'sex'         => $r['sex'] ?? '',
                'phone'       => $r['phone'] ?? '',
                'hmo'        => $r['hmo'] ?? $r['HMO'] ?? '',
                'enrole_no'  => $r['enrole_no'] ?? $r['enrole no'] ?? '',
                'password'    => Hash::make(strtolower($r['surname']))
            ]);

            $this->inserted++;
    #    }
    }

    public function chunkSize(): int
    {
        return 500; 
    }
    

    
    
    /**
     public function collection(Collection $rows){             
       foreach($rows as $row){ 
        if(!User::where('regno',$row['regno'])->exists()){
            User::create([ 
                'regno'=> $row['regno'],
                'surname' => $row['surname'],
                'firstname' => $row['firstname'],
                'othername' => $row['othername'],                
                #'email' => $row['email'],
                #'phone'=>$row['phone'],
                #'dob'=>$row['dob'],
                #'sex'=>$row['sex'],
                'password' => Hash::make(strtolower($row['surname']))
            ]);
           } ## end if
        } ## end foreach
     }
     
     **/
            /**
            *   other method to create 
                $student = new User();           
                $student->surname = $row[0];
                $student->firstname =  $row[1];
                $student->othername =  $row[2];
                $student->email =  $row[3];
                $student->password = Hash::make($row[4]);
                $student->save();               
               * 
               */ 
        
   }
 
