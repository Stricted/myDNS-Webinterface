<?php
/* lib/page/logout.php - DNS-CP
 * Copyright (C) 2013  DNS-CP project
 * http://dns-cp-de/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */

if(user::isLoggedIn()) {
	$error = user::logout();
}else{
	$error = 'You are not logged in. <a href="?page=login">Click here</a>.';
}
tpl::show("logout", array(
		"name" => "Logout",
		"error" => $error,
		"title" => $title,
		"login" => $login,
		"menu" => $tmenu,
		"build" => $conf["build"],
		"version" => $conf["version"]
		));
?>
