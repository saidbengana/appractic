<?php

namespace Inovector\Appractic\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Inovector\Appractic\Facades\Settings;
use Inovector\Appractic\Http\Requests\SchedulePost;
use Inovector\Appractic\Util;

class SchedulePostController extends Controller
{
    public function __invoke(SchedulePost $schedulePost): JsonResponse
    {
        $schedulePost->handle();

        $scheduledAt = $schedulePost->getDateTime()->tz(Settings::get('timezone'))->format("D, M j, " . Util::timeFormat());

        return response()->json("The post has been scheduled.\n$scheduledAt");
    }
}
