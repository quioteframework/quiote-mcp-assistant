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
  'mcp.server_version' => '0.1.0',
);
