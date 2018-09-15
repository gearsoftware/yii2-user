<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

class m170731_073424_i18n_es_menu_user extends yii\db\Migration
{
	public function up()
	{
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user', 'label' => 'Usuarios', 'language' => 'es-ES']);
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user-groups', 'label' => 'Grupos de permisos', 'language' => 'es-ES']);
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user-log', 'label' => 'Log de visitas', 'language' => 'es-ES']);
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user-permission', 'label' => 'Permisos', 'language' => 'es-ES']);
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user-role', 'label' => 'Roles', 'language' => 'es-ES']);
		$this->insert('{{%menu_link_lang}}', ['link_id' => 'user-user', 'label' => 'Usuarios', 'language' => 'es-ES']);
	}
}
