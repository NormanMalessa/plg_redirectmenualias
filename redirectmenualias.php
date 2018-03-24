<?php
/**
 * @author Norman Malessa <mail@norman-malessa.de>
 * @copyright 2018 Norman Malessa <mail@norman-malessa.de>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License, see LICENSE
 */

class plgSystemRedirectMenuAlias extends JPlugin {

	/**
	 *	Perform menu-check after routing
	 */
	public function onAfterRoute() {
		$app = JFactory::getApplication();

		if($app->isSite()) {
			$activeMenu = $app->getMenu()->getActive();

			if($activeMenu->type == 'alias') {
				$params = $activeMenu->params;

				// ..do not cache this redirect like mentioned in the github thread..
				$app->setHeader('Expires', 'Wed, 17 Aug 2005 00:00:00 GMT', true);
				$app->setHeader('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT', true);
				$app->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0', false);
				$app->setHeader('Pragma', 'no-cache');
				$app->sendHeaders();

				// ..get the target menu-id and redirect user
				$target = $params->get('aliasoptions');
				$route = JRoute::_('index.php?Itemid='.$target);
				$app->redirect($route);
			}
		}
	}
}
