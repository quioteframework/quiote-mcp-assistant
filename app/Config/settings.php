<?php

return array (
  'core.app_name' => 'QuioteMcpAssistant',
  'core.namespace_prefix' => 'QuioteMcpAssistant',
  'core.available' => true,
  'core.debug' => false,
  'core.use_database' => false,
  'core.use_logging' => true,
  'core.use_security' => false,
  'core.use_translation' => false,
  'core.default_context' => 'web',

  // Plugins are activated in the canonical, auto-discovered Config/plugins.php
  // (not a `plugins` key here -- that only works as an unsupported side effect).

  // stdio (the common case -- bin/quiote-assistant, per-client subprocess) +
  // an opt-in Streamable HTTP transport for a shared/team deployment via the
  // normal PSR-7 front controller (app/pub/index.php), POST /mcp. Bearer
  // auth is on by default and safe
  // when unconfigured: an unset/empty mcp.auth_token always rejects (see
  // Quiote\Mcp\Auth\StaticTokenAuthenticator) -- there is no "auth silently
  // disabled by an empty token" footgun. Set QUIOTE_ASSISTANT_MCP_TOKEN to
  // actually enable HTTP access, or mcp.auth = 'none' for a trusted
  // network/reverse-proxy-authenticated deployment.
  'mcp.enabled' => true,
  'mcp.transports' => array('stdio', 'http'),
  'mcp.auth_token' => getenv('QUIOTE_ASSISTANT_MCP_TOKEN') ?: null,
  'mcp.server_name' => 'quiote-assistant',
  'mcp.server_version' => '1.1.0',

  // This app's own cassette store, dogfooded by the cassette-related
  // introspection capabilities' own integration tests (replay.enabled stays
  // at its false default -- there is no real user traffic to record here).
  // Kept out of app/cache/ (the gitignored build-artifact directory) on
  // purpose: a cassette is recorded application data, not a regenerable
  // cache entry, even though this app's own cassettes are just test
  // fixtures. replay.local_path is a genuinely separate directory (not the
  // same as replay.store.path) so CassetteResolution's "local cache, then
  // the configured store, then the index chain" order is exercised for
  // real by the integration tests, the same way a target app with a remote
  // store would experience it.
  'replay.store.path' => dirname(__DIR__) . '/var/cassettes',
  'replay.local_path' => dirname(__DIR__) . '/var/cassette-cache',
);
