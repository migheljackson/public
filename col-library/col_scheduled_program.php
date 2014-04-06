<?php

class COL_Scheduled_Program {

  public static function getScheduledProgram( $scheduled_program_id ) {

    return COL::document_get( "ScheduledProgram_".strval($scheduled_program_id), "ScheduledProgram" );

  }
}
?>
