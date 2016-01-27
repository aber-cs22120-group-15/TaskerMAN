<?php

// Return dashboard stats 
echo TaskerMAN\Application\API::response(TaskerMAN\Application\DashboardStats::getStats(TaskerMAN\Application\API::$uid));