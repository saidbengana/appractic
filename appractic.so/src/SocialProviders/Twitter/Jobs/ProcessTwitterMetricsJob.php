<?php

namespace Inovector\Appractic\SocialProviders\Twitter\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Inovector\Appractic\Models\Account;
use Inovector\Appractic\Models\ImportedPost;
use Inovector\Appractic\Models\Metric;

class ProcessTwitterMetricsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $deleteWhenMissingModels = true;

    public Account $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function handle()
    {
        $items = ImportedPost::select('created_at',
            DB::raw('SUM(JSON_EXTRACT(metrics, "$.likes")) as likes'),
            DB::raw('SUM(JSON_EXTRACT(metrics, "$.replies")) as replies'),
            DB::raw('SUM(JSON_EXTRACT(metrics, "$.retweets")) as retweets'),
            DB::raw('SUM(JSON_EXTRACT(metrics, "$.impressions")) as impressions'))
            ->where('account_id', $this->account->id)
            ->groupBy('created_at')
            ->cursor();

        $data = $items->map(function ($item) {
            return [
                'account_id' => $this->account->id,
                'date' => $item->created_at,
                'data' => json_encode([
                    'likes' => $item->likes,
                    'replies' => $item->replies,
                    'retweets' => $item->retweets,
                    'impressions' => $item->impressions,
                ])
            ];
        });

        Metric::upsert($data->toArray(), ['data'], ['account_id', 'date']);
    }
}
