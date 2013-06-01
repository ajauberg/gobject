<?php
//
// The following class updates all logs
//

class CLogs {

	var $tables;
	var $samplerates;
	var $periods;

	function CLogs() {
		$this->tables=array('gLogDays','gLogWeeks','gLogMonths','gLogYears','gLogYears');
		$this->samplerates=array('-5 minutes','-30 minutes','-2 hours','-1 day','-1 day');
		$this->periods=array('-36 hours','-10 days','-6 weeks','-18 months','-18 months');
	}

	function add_new($table,$refOid,$t,$MAC,$SIG,$NOISE,$QUAL) {
		$q="INSERT $table (refOid,Timestamp,MAC,SIG,NOISE,QUAL) VALUES ($refOid,'$t','$MAC',$SIG,$NOISE,'$QUAL')";
		echo "q: $q<br>";
		$r=mysql_query($q) or die(mysql_error());
		return $r;
	}

	function delete_oldest($table,$t) {
		$q="DELETE FROM $table WHERE Timestamp < '$t'";
		echo "q: $q<br>";
		$r=mysql_query($q) or die(mysql_error());
		return $r;
	}

	function select_newest($table,$t) {
		$q="SELECT refOid,MAC,AVG(SIG) AS SIG,AVG(NOISE) AS NOISE FROM $table WHERE Timestamp >= '$t' GROUP BY refOid,MAC";
		echo "q: $q<br>";
		$r=mysql_query($q) or die(mysql_error());
		return $r;
	}

	function update($t) {	// $t : Current timestamp (integer)

		for ($i=0;$i+1<(count($this->tables));$i++)
		{
			// Calculate the period the current log table shall span
			$period=date('Y-m-d H:i:s',strtotime($this->periods[$i],$t));
			// Delete all entries older than period in current log table
			$this->delete_oldest($this->tables[$i],$period);

			// Calculate the sample rate for the next log table
			$samplerate=date('Y-m-d H:i:s',strtotime($this->samplerates[$i+1],$t));
			// Seek for new entries within sample rate in next log table
			$r=$this->select_newest($this->tables[$i+1],$samplerate);

			// If result set is empty, the next log table is ready for a new sample
			if (!mysql_num_rows($r))
			{
				// Return average from first log table within sample rate
				$r=$this->select_newest($this->tables[0],$samplerate);

				while ($row=mysql_fetch_array($r, MYSQL_ASSOC))
				{
					$refOid=$row['refOid'];
					$MAC=$row['MAC'];
					$SIG=$row['SIG'];
					$NOISE=$row['NOISE'];
					$QUAL=$SIG-$NOISE;

					// Add average to next log table
					$this->add_new($this->tables[$i+1],$refOid,date('Y-m-d H:i:s',$t),$MAC,$SIG,$NOISE,$QUAL);
				}
			}
			else
				return; // Not ready for new sample
		}
	}
}


