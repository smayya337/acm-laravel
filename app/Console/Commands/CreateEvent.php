<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\text;
use function Laravel\Prompts\password;

class CreateEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text('What is the name of the event?', required: true);
        $start = text('When does the event start?', required: true);
        $end = text('When does the event end?');
        $location = text('Where is the event taking place?', required: true);
        $description = text('Describe the event:');

        $data = compact('name', 'start', 'end', 'location', 'description');

        $validator = Validator::make($data, [
            'name' => ['required'],
            'start' => ['required', 'date'],
            'end' => ['date|after:start'],
            'location' => ['required'],
            'description' => [],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        Event::create([
            'name' => $name,
            'start' => $start,
            'end' => $end,
            'location' => $location,
            'description' => $description
        ]);

        $this->info("The event $name was successfully created!");
        return 0;
    }

}
