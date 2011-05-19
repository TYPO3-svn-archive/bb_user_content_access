<?php
class ux_t3lib_pageSelect extends t3lib_pageSelect
{
	/**
	 * Extending function for enableFields()
	 */
	function enableFields($table,$show_hidden=-1,$ignore_array=array())
	{
		global $TCA;
		// t3lib_div::loadTCA('tt_content');

		// Call parent function (the original!)
		$return_value = parent::enableFields($table,$show_hidden,$ignore_array);

		// Check for our custom enable-column, "tx_bbusercontentaccess_fe_user":
		if (is_array($TCA[$table]) && $TCA[$table]['ctrl']['enablecolumns']['tx_bbusercontentaccess_fe_user'])
		{
			$field = $table . '.' . $TCA[$table]['ctrl']['enablecolumns']['tx_bbusercontentaccess_fe_user'];

			$userid_column = $GLOBALS['TSFE']->fe_user->userid_column;
			$uid = $GLOBALS['TSFE']->fe_user->user[$userid_column];

			$return_value .= $this->getUserWhereClause($field, $table, $uid);
		}

		// t3lib_div::debug(array($return_value));

		// Return the value:
		return $return_value;
	}



	/**
	 * Creating where-clause for checking user access to elements in enableFields function
	 *
	 * @param	string		Field with group list
	 * @param	string		Table name
	 * @param	int				User Id
	 * @return	string		AND sql-clause
	 * @see enableFields()
	 */
	function getUserWhereClause($field, $table, $uid) {

		$orChecks = array();
		$orChecks[] = $field . '=\'\''; // If the field is empty, then OK
		$orChecks[] = $field . ' IS NULL'; // If the field is NULL, then OK
		$orChecks[] = $field . '=\'0\''; // If the field contsains zero, then OK
		$orChecks[] = $field . '=\'-1\''; // If the field contsains zero, then OK
		if ($uid && !empty($uid) && strlen($uid)) {
			$orChecks[] = ' FIND_IN_SET(\'' . $uid . '\', ' . $field . ')';
		}

		return ' AND (' . implode(' OR ', $orChecks) . ')';
	}
}

?>