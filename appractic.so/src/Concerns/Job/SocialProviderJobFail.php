<?php

namespace Inovector\Mixpost\Concerns\Job;

use Inovector\Mixpost\Support\Log;
use Inovector\Mixpost\Support\SocialProviderResponse;

trait SocialProviderJobFail
{
    public function makeFail(SocialProviderResponse $response): void
    {
        Log::error($this->job->payload()['displayName'], array_merge($response->context(), ['payload' => $this->job->payload()]));

        $this->fail();
    }
}
