<?php

namespace evelikto\di\storage\impl;

function session_status() {
	return \GlobalFlags::$SESSION_STATUS ?? \session_status();
}

function function_exists(string $function_name) {
	if ($function_name === 'apcu_fetch' && \GlobalFlags::$APCU === false)
		return false;

	return \function_exists($function_name);
}
