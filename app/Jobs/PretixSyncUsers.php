<?php

namespace App\Jobs;

use App\Mail\MyLogin;
use App\Mail\PretixDuplicate;
use App\Models\Event;
use App\Models\Pretix;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PretixSyncUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $clienthandler;

    private $authtoken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle(Pretix $pretix): void
    {
        $events = Event::all();
        $emails = [];
        foreach ($events as $event) {
            $json = $pretix->orders($event);

            $pagination = false;
            do {
                if ($pagination) {
                    $json = $pretix->next($json['next']);
                }
                foreach ($json['results'] as $order) {
                    foreach ($order['positions'] as $position) {
                        $email = '';
                        $name = $position['attendee_name_parts']['calling_name'] ?? $position['attendee_name'];

                        foreach ($position['answers'] as $answer) {
                            /*
                            if ($answer['question_identifier'] == 'BUG3A3RH') {
                                $email = $answer['answer'];
                            }
                             */
                            if ($answer['question_identifier'] == 'QSJHBNZS') {
                                $sendegate = $answer['answer'];
                            }
                            if ($answer['question_identifier'] == 'FF3CKR9T') {
                                $mastodon = $answer['answer'];
                            }
                        }

                        $validator = Validator::make(['email' => $email], [
                            'email' => 'required|email',
                        ]);

                        if ($validator->fails()) {
                            continue;
                        }

                        if (in_array($email, $emails)) {
                            //Mail::to($order['email'])->queue(new PretixDuplicate($order, $email));

                            continue;
                        }

                        $pretixid = $order['code'].'-'.$position['positionid'];
                        $user = User::where(['pretixid' => $pretixid])->first();
                        if (!$user) {
                            $user = new User;
                            $user->token = strtolower(Str::random(16));
                            $user->password = Hash::make(Str::random(32));
                            $user->name = $name;
                            $user->pretixid = $pretixid;
                            $user->email = $email;
                            $user->sendegate = $sendegate;
                            $user->mastodon = $mastodon;
                            $user->save();
                            //Mail::to($email)->queue(new MyLogin($user));
                        }

                        $user->email = $email;
                        $user->save();
                        array_push($emails, $email);
                    }
                }
                $pagination = true;
            } while ($json['next']);
        }
    }
}
