<?php

class ffStopWatch {
	private static $_namedTime = null;
	private static $_currentTime = null;
	
	private static $_currentMem = null;
	private static $_namedMem = null;
	
	public static function memoryStart( $name = null ) {
		if( $name !== null ) {
			self::$_namedMem[ $name ] = memory_get_usage();
		} else {
			self::$_currentMem = memory_get_usage();
		}
	}
	
	public static function memoryEnd( $name = null ) {
		$end = memory_get_usage();
		if( $name !== null ) {
			$diff = $end - self::$_namedMem[ $name ];
		} else {
			$diff = $end - self::$_currentMem;
		}
		
		return $diff / 950000;
	}
	
	public static function memoryEndDump( $name = null ) {
		var_dump( self::memoryEnd($name ));
	}
	
	public static function timeStart( $name = null ) {
		if( $name !== null ) {
			self::$_namedTime[ $name ] = ff_microtime_float(); 
		} else {
			self::$_currentTime = ff_microtime_float();
		}
	}
	
	public static function timeEnd( $name = null ) {
		$end = ff_microtime_float();
		
		if( $name !== null  ) {
			$diff = $end - self::$_namedTime[ $name ];
		} else {
			$diff = $end - self::$_currentTime;
		}
		
		return $diff;
	}
	
	public static function timeEndDump( $name = null ) {
		$diff = self::timeEnd( $name );
		var_dump( $diff );
	}
}

function ff_microtime_float()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}