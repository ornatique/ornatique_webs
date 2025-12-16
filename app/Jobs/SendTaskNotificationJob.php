<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\User;
use App\Helpers\FCMManualHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTaskNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        $imageUrl = $this->task->image
            ? asset('public/assets/images/notification/' . $this->task->image)
            : null;

        $users = User::whereNotNull('token')
            ->where('token', '!=', '')
            ->get();

        foreach ($users as $user) {
            FCMManualHelper::sendPushWithImage(
                $user->token,
                $this->task->title,
                $this->task->description,
                $imageUrl
            );
        }
    }
}
