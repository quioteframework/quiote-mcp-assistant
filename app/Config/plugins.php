<?php

// The canonical, auto-discovered plugin activation file (Quiote::bootstrap()
// looks for %core.config_dir%/plugins.{php,yaml,yml,xml}, PHP taking priority).
// Each entry is {class, enabled?} (enabled defaults to true) and plugins load
// in order. McpPlugin publishes the mcp.* settings family and registers
// `mcp:serve`; ReplayPlugin binds the cassette store the introspection
// probe's cassette capabilities read from (see Config/settings.php's
// replay.store.path); AssistantPlugin (this app) registers the knowledge
// resources/tools/prompts and `mcp:docs:sync`.
return array(
  array('class' => \Quiote\Mcp\McpPlugin::class, 'enabled' => true),
  array('class' => \Quiote\Replay\ReplayPlugin::class, 'enabled' => true),
  array('class' => \QuioteMcpAssistant\Mcp\AssistantPlugin::class, 'enabled' => true),
);
