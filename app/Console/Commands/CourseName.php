<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CourseName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CourseName';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change course name to slug';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $i =1;
        \App\Models\Course::chunk(10,function($abc) use(&$i){
            $i =1;
            foreach($abc as $row)
            {
                $slug = str_replace(' ', '-', $row->name);
                \App\models\Course::where('id',$row->id)->update(['course_name_slug'=>$slug,'short_code'=>md5(uniqid())]);
                $i++;
            }
        });
    }
}
