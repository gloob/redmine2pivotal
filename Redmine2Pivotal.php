<?php
/**
 * Redmine2Pivotal
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
 * along with this program. If not, see <http://www.gnu.org/licenses/agpl-3.0.txt>.
 *
 * @author Alejandro Leiva <gloob@litio.org>
 *
 * $Id$
 */

require_once(realpath(dirname(__FILE__)) . '/lib/PivotalTracker.class.php');
require_once(realpath(dirname(__FILE__)) . '/lib/Redmine.class.php');

$issues = Redmine::parse_redmine_csv('export.csv');  

foreach ($issues as $issue) {
	$ret = PivotalTracker::add_story(81094,$issue['Tema'], $issue['Descripción'], $issue['Autor']);
	print_r($ret);
}

?>
