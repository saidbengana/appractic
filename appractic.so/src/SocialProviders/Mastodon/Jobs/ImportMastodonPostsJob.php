<?php

namespace Inovector\Appractic\SocialProviders\Mastodon\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Inovector\Appractic\Concerns\Job\HasSocialProviderJobRateLimit;
use Inovector\Appractic\Concerns\Job\SocialProviderJobFail;
use Inovector\Appractic\Concerns\UsesSocialProviderManager;
use Inovector\Appractic\Models\Account;
use Inovector\Appractic\Models\ImportedPost;
use Inovector\Appractic\SocialProviders\Mastodon\MastodonProvider;
use Inovector\Appractic\Support\SocialProviderResponse;

class ImportMastodonPostsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use UsesSocialProviderManager;
    use HasSocialProviderJobRateLimit;
    use SocialProviderJobFail;

    public $deleteWhenMissingModels = true;

    public Account $account;
    public array $params;

    public function __construct(Account $account, array $params = [])
    {
        $this->account = $account;
        $this->params = $params;
    }

    public function handle(): void
    {
        if ($retryAfter = $this->rateLimitExpiration()) {
            $this->release($retryAfter);

            return;
        }

        /**
         * @see MastodonProvider
         * @var SocialProviderResponse $response
         */
        $response = $this->connectProvider($this->account)->getUserStatuses($this->account->provider_id, $this->params['max_id'] ?? '');

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

        $posts = $this->filterPosts($response->data);

        $this->import($posts);

        // If more than 40(limit of page items), there is a probability that there are others.
        if (count($posts) >= 40) {
            ImportMastodonPostsJob::dispatch($this->account, ['max_id' => Arr::last($posts)['id']])->delay(60 * 15);
        }
    }

    protected function filterPosts(array $data): array
    {
        return Arr::where($data, function ($item) {
            return Carbon::parse($item['created_at'], 'UTC')->greaterThan(Carbon::now('UTC')->subDays(90));
        });
    }

    protected function import(array $items): void
    {
        $data = Arr::map($items, function ($item) {
            return [
                'account_id' => $this->account->id,
                'provider_post_id' => $item['id'],
                'content' => json_encode(['text' => $item['content']]),
                'metrics' => json_encode([
                    'replies' => $item['replies_count'],
                    'reblogs' => $item['reblogs_count'],
                    'favourites' => $item['favourites_count'],
                ]),
                'created_at' => Carbon::parse($item['created_at'], 'UTC')->toDateString()
            ];
        });

        ImportedPost::upsert($data, ['account_id', 'provider_post_id'], ['content', 'metrics']);
    }
}
