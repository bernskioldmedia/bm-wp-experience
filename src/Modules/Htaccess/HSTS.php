<?php

namespace BernskioldMedia\WP\Experience\Modules\Htaccess;

class HSTS extends HtaccessRuleset {

	protected array $rules = [
		'enabled'  => '/\#\s+BM HSTS Header/si',
		'disabled' => '/\#\s+BM\s+HSTS\s+Headers(.+?)\#\s+BM\s+HSTS\s+Headers\s+END(\n)?/ims',
	];

	protected string $template = 'hsts.tpl';

}
