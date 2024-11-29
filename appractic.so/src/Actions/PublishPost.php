<?php

namespace Inovector\Appractic\Actions;

use Illuminate\Support\Facades\Bus;
use Inovector\Appractic\Jobs\AccountPublishPostJob;
use Inovector\Appractic\Models\Post;

class PublishPost
{
    public function __invoke(Post $post): void
    {
        if ($post->isScheduleProcessing()) {
            return;
        }

        $post->setScheduleProcessing();

        $jobs = $post->accounts->map(function ($account) use ($post) {
            return new AccountPublishPostJob($account, $post);
        });

        Bus::batch($jobs)
            ->allowFailures()
            ->finally(function () use ($post) {
                if ($post->hasErrors()) {
                    $post->setFailed();
                    return;
                }

                $post->setPublished();
            })
            ->onQueue('publish-post')
            ->dispatch();
    }
}
