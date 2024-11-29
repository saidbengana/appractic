<?php

namespace Inovector\Appractic\SocialProviders\Meta\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inovector\Appractic\Concerns\Job\HasSocialProviderJobRateLimit;
use Inovector\Appractic\Concerns\Job\SocialProviderJobFail;
use Inovector\Appractic\Concerns\UsesSocialProviderManager;
use Inovector\Appractic\Enums\FacebookInsightType;
use Inovector\Appractic\Models\Account;
use Inovector\Appractic\Models\FacebookInsight;
use Inovector\Appractic\SocialProviders\Meta\FacebookPageProvider;
use Inovector\Appractic\Support\SocialProviderResponse;

class ImportFacebookInsightsJob implements ShouldQueue
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
         * @see FacebookPageProvider
         * @var SocialProviderResponse $response
         */
        $response = $this->connectProvider($this->account)->getPageInsights();

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

        $insights = $response->context()['data'];

        foreach ($insights as $insight) {
            $this->importInsights(FacebookInsightType::fromName(Str::upper($insight['name'])), $insight['values']);
        }
    }

    protected function importInsights(FacebookInsightType $type, array $items): void
    {
        $data = Arr::map($items, function ($item) use ($type) {
            return [
                'account_id' => $this->account->id,
                'type' => $type,
                'date' => Carbon::parse($item['end_time'], 'UTC')->toDateString(),
                'value' => $item['value'],
            ];
        });

        FacebookInsight::upsert($data, ['account_id', 'type', 'date'], ['value']);
    }
}
