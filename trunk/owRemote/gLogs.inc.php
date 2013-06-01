<?php
//
// The following class compress all logs
//

class CLogs {

	var $tables;		//  Name of the log tables that shall be compressed
	var $samplerates;	//  Samplerates for the log tables
	var $periods;		//  Time period each log table shall span

	function CLogs() {
		$this->tables=array('gLogDays','gLogWeeks','gLogMonths','gLogYears','gLogYears');
		$this->samplerates=array('-5 minutes','-30 minutes','-2 hours','-1 day','-1 day');
		$this->periods=array('-36 hours','-10 days','-6 weeks','-18 months','-18 months');
	}

	function add_new($table,$t,$row) {

		// Collect average from current log table
		$refOid=$row['refOid'];
		$MAC=	$row['MAC'];
		$SIG=	$row['SIG'];
		$NOISE=	$row['NOISE'];
		$QUAL=	$SIG-$NOISE;

		// Add average to next log table
		$q="INSERT $table(refOid,Timestamp,MAC,SIG,NOISE,QUAL) VALUES($refOid,'$t','$MAC',$SIG,$NOISE,'$QUAL')";
		return $this->process_query($q);
	}

	function delete_oldest($table,$t) {
		$q="DELETE FROM $table WHERE Timestamp<'$t'";
		return $this->process_query($q);
	}

	function select_newest($table,$t) {
		$q="SELECT refOid,MAC,AVG(SIG) AS SIG,AVG(NOISE) AS NOISE FROM $table WHERE Timestamp>='$t' GROUP BY refOid,MAC";
		return $this->process_query($q);
	}

	function process_query($q) {
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
			$r=$this->delete_oldest($this->tables[$i],$period);

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
					// Add average to next log table
					$this->add_new($this->tables[$i+1],date('Y-m-d H:i:s',$t),$row);
				}
			}
			else
				return; // Not ready for new sample
		}
	}
}

class CSNRLogs extends CLogs {

	function CSNRLogs() {
		$this->CLogs();
		$this->tables=array('gLogSNRDays','gLogSNRWeeks','gLogSNRMonths','gLogSNRYears','gLogSNRYears');
	}

	function select_newest($table,$t) {
		$q="SELECT refOid,MAC,AVG(SIG) AS SIG,AVG(NOISE) AS NOISE FROM $table WHERE Timestamp>='$t' GROUP BY refOid,MAC";
		return $this->process_query($q);
	}

	function add_new($table,$t,$row) {
		$refOid=$row['refOid'];
		$MAC=$row['MAC'];
		$SIG=$row['SIG'];
		$NOISE=$row['NOISE'];
		$QUAL=$SIG-$NOISE;

		// Add average to next log table
		$q="INSERT $table(refOid,Timestamp,MAC,SIG,NOISE,QUAL) VALUES($refOid,'$t','$MAC',$SIG,$NOISE,'$QUAL')";
		return $this->process_query($q);
	}
}

class CTRXLogs extends CLogs  {

	function CTRXLogs() {
		$this->CLogs();
		$this->tables=array('gLogTRXDays','gLogTRXWeeks','gLogTRXMonths','gLogTRXYears','gLogTRXYears');
	}

	function select_newest($table,$t) {
		$q="SELECT refOid,AVG(RATE) AS RATE,MAX(UPTIME) AS UPTIME,AVG(CLI) AS CLI,".
		"MAX(RXP) AS RXP,MAX(RXe) AS RXe,MAX(RXd) AS RXd,MAX(RXo) AS RXo,MAX(RXf) AS RXf,MAX(RXb) AS RXb,".
		"MAX(TXP) AS TXP,MAX(TXe) AS TXe,MAX(TXd) AS TXd,MAX(TXo) AS TXo,MAX(TXc) AS TXc,MAX(TXco) AS TXco,MAX(TXq) AS TXq,MAX(TXb) AS TXb ".
		"FROM $table WHERE Timestamp>='$t' GROUP BY refOid";
		return $this->process_query($q);
	}

	function add_new($table,$t,$row) {
		$refOid=$row['refOid'];
		$RATE=	$row['RATE'];
		$UPTIME=$row['UPTIME'];
		$CLI=	$row['CLI'];

		$RXP=	$row['RXP'];	// RX packets
		$RXe=	$row['RXe'];	// RX errors
		$RXd=	$row['RXd'];	// RX dropped
		$RXo=	$row['RXo'];	// RX overruns
		$RXf=	$row['RXf'];	// RX frames
		$RXb=	$row['RXb'];	// RX bytes

		$TXP=	$row['TXP'];	// TX packets
		$TXe=	$row['TXe'];	// TX errors
		$TXd=	$row['TXd'];	// TX dropped
		$TXo=	$row['TXo'];	// TX overruns
		$TXc=	$row['TXc'];	// TX carriers
		$TXco=	$row['TXco'];	// TX collisions
		$TXq=	$row['TXq'];	// TX queue length
		$TXb=	$row['TXb'];	// TX bytes

		// Add average to next log table
		$q="INSERT $table(refOid,Timestamp,RATE,UPTIME,CLI,RXP,RXe,RXd,RXo,RXf,RXb,TXP,TXe,TXd,TXo,TXc,TXco,TXq,TXb) ".
		"VALUES($refOid,'$t',$RATE,$UPTIME,$CLI,$RXP,$RXe,$RXd,$RXo,$RXf,$RXb,$TXP,$TXe,$TXd,$TXo,$TXc,$TXco,$TXq,$TXb)";
		return $this->process_query($q);
	}
}


