<?php
/*
 * All helpers function for get user device and ... information
 */

function helper_info_device_info():array
{
    $agent = new \Jenssegers\Agent\Agent();
    return [
        'ip' => request()->ip(),
        'device' => $agent->device(),
        'platform' => $agent->platform(),
        'platform_version' => $agent->version($agent->platform()),
        'browser' => $agent->browser(),
        'browser_version' => $agent->version($agent->browser()),
        'robot' => $agent->robot(),
    ];
}
