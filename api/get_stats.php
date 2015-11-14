<?php

echo TaskerMAN\API::response(TaskerMAN\DashboardStats::getStats(TaskerMAN\API::$uid));