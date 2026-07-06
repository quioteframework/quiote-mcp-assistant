<?php
namespace QuioteMcpAssistant\Modules\Default\Actions;

use Quiote\Action\Action;
use Quiote\Request\WebRequest;

class AboutAction extends Action
{
	public function executeRead(WebRequest $rd): string
	{
		return 'Success';
	}

	public function getDefaultViewName()
	{
		return 'Success';
	}

	// No validators configured for this scaffolded action -- skip the
	// validation pipeline's XML-config lookup entirely.
	public function isSimple()
	{
		return true;
	}
}
