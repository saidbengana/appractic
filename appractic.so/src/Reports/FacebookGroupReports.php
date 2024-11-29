<?php

namespace Inovector\Appractic\Reports;

use Inovector\Appractic\Abstracts\Report;
use Inovector\Appractic\Models\Account;

class FacebookGroupReports extends Report
{
    public function __invoke(Account $account, string $period): array
    {
        return [
            'metrics' => [],
            'audience' => $this->audience($account, $period)
        ];
    }

    protected function metrics(Account $account, string $period): array
    {
        return [];
    }
}
