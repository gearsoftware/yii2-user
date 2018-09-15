<?php

/**
 * @package   Yii2-User
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\db\TranslatedMessagesMigration;

class m170731_072017_i18n_es_core_user extends TranslatedMessagesMigration
{
	public function getLanguage()
	{
		return 'es-ES';
	}

	public function getCategory()
	{
		return 'core/user';
	}

	public function getTranslations()
	{
		return [
			'Child permissions' => 'Permisos heredados',
			'Child roles' => 'Roles heredados',
			'Create Permission Group' => 'Crear grupo de permisos',
			'Create Permission' => 'Crear permiso',
			'Create Role' => 'Crear rol',
			'Create User' => 'Crear usuario',
			'Log №{id}' => 'Log №{id}',
			'No users found.' => 'No se encontraron usuarios.',
			'Password' => 'Contraseña',
			'Permission Groups' => 'Grupos de permisos',
			'Permission' => 'Permiso',
			'Permissions for "{role}" role' => 'Permisos para el rol "{role}"',
			'Permissions' => 'Permisos',
			'Refresh routes' => 'Actualizar rutas',
			'Registration date' => 'Fecha de registro',
			'Role' => 'Rol',
			'Roles and Permissions for "{user}"' => 'Roles y permisos para "{user}"',
			'Roles' => 'Roles',
			'Routes' => 'Rutas',
			'Search route' => 'Buscar ruta',
			'Show all' => 'Mostrar todo',
			'Show all elements' => 'Mostrar todos los elementos',
			'Show only selected' => 'Mostrar sólo los seleccionados',
			'Update Permission Group' => 'Actualizar grupo de permisos',
			'Update Permission' => 'Actualizar',
			'Update Role' => 'Actualizar rol',
			'Update User Password' => 'Actualizar contraseña',
			'Update User' => 'Actualizar usuario',
			'User not found' => 'Usuario no encontrado',
			'User' => 'Usuario',
			'Users' => 'Usuarios',
			'Visit Log' => 'Log de visitas',
			'You can not change own permissions' => 'No puedes cambiar tus propios permisos',
			"You can't update own permissions!" => '¡No puedes actualizar tus propios permisos!',
			'{permission} Permission Settings' => 'Configuración del permiso {permission}',
			'{permission} Role Settings' => 'Configuración del rol {permission}',
			'Refresh routes (and delete unused)' => 'Actualizar rutas (y eliminar no usadas)',
		];
	}
}
