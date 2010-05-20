<?php
/**
 * Redmine utility class.
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

class Redmine {


	public static function parse_redmine_csv($filename) {

		$content = file_get_contents($filename);

		$first_line = preg_match('/#.*/', $content, $matches);
		$keys = explode(';', utf8_encode($matches[0]));

		# First pass
		$lines = explode("\"\n", $content);

		# Second pass
		$issues_array = array();
		foreach ($lines as $line) {
			$extra_line = explode("\n", $line);
			$match = preg_grep('/^\d+;/', $extra_line);
			$issues_array = array_merge($issues_array, $match);
		}

		foreach($issues_array as $issue) {
			$issue_array = explode(';', $issue);
			$issues[] = array_combine($keys, $issue_array);
		}

		return $issues;
	}

}

?>
