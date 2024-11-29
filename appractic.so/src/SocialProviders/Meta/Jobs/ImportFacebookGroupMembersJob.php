<?php

namespace Inovector\Appractic\SocialProviders\Meta\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Inovector\Appractic\Concerns\Job\HasSocialProviderJobRateLimit;
use Inovector\Appractic\Concerns\Job\SocialProviderJobFail;
use Inovector\Appractic\Concerns\UsesSocialProviderManager;
use Inovector\Appractic\Models\Account;
use Inovector\Appractic\Models\Audience;
use Inovector\Appractic\SocialProviders\Meta\FacebookGroupProvider;
use Inovector\Appractic\Support\SocialProviderResponse;

// @deprecated
// We will remove this feature soon
class ImportFacebookGroupMembersJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use UsesSocialProviderManager;
    use HasSocialProviderJobRateLimit;
    use SocialProviderJobFail;

    public $deleteWhenMissingModels = true;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function handle(): void
    {
        if ($retryAfter = $this->rateLimitExpiration()) {
            $this->release($retryAfter);

            return;
        }

        /**
         * @see FacebookGroupProvider
         * @var SocialProviderResponse $response
         */
        $response = $this->connectProvider($this->account)->getGroupMetrics();

        if ($response->hasExceededRateLimit()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
            $this->release($response->retryAfter());

            return;
        }

        if ($response->rateLimitAboutToBeExceeded()) {
            $this->storeRateLimitExceeded($response->retryAfter(), $response->isAppLevel());
        }

        if ($response->hasError()) {
            $this->makeFail($response);

            return;
        }

        Audience::updateOrCreate([
            'account_id' => $this->account->id,
            'date' => Carbon::today('UTC')->toDateString()
        ], [
            'total' => $response->member_count ?? 0
        ]);
    }
}
