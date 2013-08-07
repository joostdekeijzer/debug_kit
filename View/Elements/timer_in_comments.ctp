<?php
/**
 * Debug Toolbar Element
 *
 * Renders all of the other panel elements.
 *
 * PHP versions 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org
 * @package       debug_kit
 * @subpackage    debug_kit.views.elements
 * @since         DebugKit 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 **/

$this->Number = $this->Helpers->load('Number');

if (!isset($debugKitInHistoryMode)):
	$currentMemory = DebugKitDebugger::getMemoryUse();
	$peakMemory = DebugKitDebugger::getPeakMemoryUse();
	$requestTime = DebugTimer::requestTime();
else:
	$content = $this->Toolbar->readCache('timer', $this->request->params['pass'][0]);
	if (is_array($content)):
		extract($content);
	endif;
endif;
?>
<!--
  -- MEMORY
  -- ======
<?php
echo '  -- ' . __d('debug_kit', 'Peak Memory Use') . ' ' . $this->Number->toReadableSize($peakMemory) . "\n";
echo "  --\n";
$memoryPoints = DebugKitDebugger::getMemoryPoints();
foreach($memoryPoints as $key => $value) {
	echo '  -- ' . $key . ': ' . $this->Number->toReadableSize($value) . "\n";
}
?>
  --
  -- TIMERS
  -- ======
<?php
echo '  -- ' . __d('debug_kit', 'Total Request Time:') . ' ' . __d('debug_kit', '%s (ms)', $this->Number->precision($requestTime * 1000, 0)) . "\n";
echo "  --\n";

$end = end($timers);
$maxTime = $end['end'];
$i = 0;
$values = array_values($timers);

foreach ($timers as $timerName => $timeInfo) {
	$indent = 0;
	for ($j = 0; $j < $i; $j++) {
		if (($values[$j]['end'] > $timeInfo['start']) && ($values[$j]['end']) > ($timeInfo['end'])) {
			$indent++;
		}
	}
	$indent = str_repeat(' . ', $indent);
	echo '  -- ' . $indent . $timeInfo['message'] . ' ' . $this->Number->precision($timeInfo['time'] * 1000, 2) . "\n";
	$i++;
}
?>
  -->
