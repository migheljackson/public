<?php
  class COL_Org {
    public static function getOrgById( $id ) {
      return COL::document_get( "Org_".strval($id), "Org" );
    }
  }
?>
