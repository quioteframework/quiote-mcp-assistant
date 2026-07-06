<?php

declare(strict_types=1);

/**
 * PHPUnit bootstrap: mirrors bin/quiote-assistant's own bootstrap sequence
 * (this app's own PSR-4-ish autoloader, then Quiote::bootstrap() against
 * this app's own app/) so tests exercise the exact same live, bootstrapped
 * app the smoke-test scripts do when self-targeting -- not a mock Context.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

$appDir = dirname(__DIR__) . '/app';

spl_autoload_register(static function (string $class) use ($appDir): void {
    $prefix = 'QuioteMcpAssistant\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $file = $appDir . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

\Quiote\Config\Config::set('core.app_dir', $appDir, true, true);
\Quiote\Quiote::bootstrap(getenv('QUIOTE_ENV') ?: 'development');
