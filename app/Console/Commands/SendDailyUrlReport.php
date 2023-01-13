<?php

namespace App\Console\Commands;

use App\Notifications\DailyUrlNotification;
use App\Repositories\RedirectLogRepository;
use App\Repositories\UrlRepository;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class SendDailyUrlReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every day, at 10:00 am according to the local time of the user,
    an e-mail is sent to the users with the information of how many visits they have made to their links.';

    /**
     * @param UserRepository $userRepository
     * @param UrlRepository $urlRepository
     * @param RedirectLogRepository $redirectLogRepository
     */
    public function __construct(
        private UserRepository        $userRepository,
        private UrlRepository         $urlRepository,
        private RedirectLogRepository $redirectLogRepository
    )
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $users = $this->userRepository->getUsersTimezone();
        foreach ($users as $key => $user)
            if (now($key)->hour == 10) {
                foreach ($user as $person) {
                    $slug = $this->urlRepository->getAllSlugs($person->id);
                    $countedData = $this->redirectLogRepository->countLink($slug);
                    $person->notify(new DailyUrlNotification($countedData));

                }
            }
    }
}
