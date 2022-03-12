<?php

namespace App\Services;

/**
 * @url https://kubernetes.io/ru/docs/tasks/configure-pod-container/configure-liveness-readiness-startup-probes/
 */
class ReadinessChecker
{
    public function isReady(): bool
    {
        return true;
        // how do we check what "wkhtmltopdf" is installed?
    }
}
