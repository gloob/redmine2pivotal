<?php
/**
 * Pivotal Tracker utility class.
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


class PivotalTracker {

	const PT_BASEURL = 'https://www.pivotaltracker.com/services/v3/';
	const PT_TOKEN = '916260661a8cb86ad3278b17f4ff91c4';

	public static function query_PT($urlComplement, $xml = NULL, $method = 'GET') {

		$ch = curl_init();
		$url = PivotalTracker::PT_BASEURL.$urlComplement;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = array("X-TrackerToken: ".PivotalTracker::PT_TOKEN,"Content-type: text/xml","Connection: close");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		if($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		} elseif($method == 'PUT') {
			$putString = "";
			$putData = tmpfile();
			fwrite($putData, $putString);
			fseek($putData, 0);
			curl_setopt($ch, CURLOPT_PUT, TRUE);
			curl_setopt($ch, CURLOPT_INFILE, $putData);
			curl_setopt($ch, CURLOPT_INFILESIZE, strlen($putString));
		}

		$ret = curl_exec($ch);

		if($ret == false) {
			echo'Warning : ' . curl_error($ch);
			curl_close($ch);
			return NULL;
		} else {
			curl_close($ch);
			return $ret;
		}

	}

	public static function add_story($project_id, $name, $description, $author) {

		$xml = "<?xml version='1.0' encoding='UTF-8'?>
			<story>
			<project_id type='integer'>$project_id</project_id>
			<story_type>feature</story_type>
			<estimate type='integer'>-1</estimate>
			<current_state>unscheduled</current_state>
			<description>$description</description>
			<name>$name</name>
			<requested_by>$author</requested_by>
			</story>
		";

		$xml = utf8_encode($xml);

		self::query_PT("projects/$project_id/stories", $xml, 'POST');
	}

}

?>
