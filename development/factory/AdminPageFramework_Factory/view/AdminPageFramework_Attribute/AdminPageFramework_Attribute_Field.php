<?php
/**
 * Admin Page Framework
 * 
 * http://en.michaeluno.jp/admin-page-framework/
 * Copyright (c) 2013-2015 Michael Uno; Licensed MIT
 * 
 */

/**
 * Provides methods to format field container HTML attributes.
 * 
 * @package     AdminPageFramework
 * @subpackage  Attribute
 * @since       3.6.0
 * @internal
 */
class AdminPageFramework_Attribute_Field extends AdminPageFramework_Attribute_FieldContainer_Base {

    /**
     * Indicates the context of the attribute.
     * 
     * e.g. fieldrow, fieldset, fields etc.
     * 
     * @since       3.6.0
     */
    public $sContext    = 'field'; 

    /**
     * Returns the field container attribute array.
     * 
     * @remark      Formatting each sub-field should be performed prior to callign this method.
     * @param       array       $aField     The (sub-)field definition array. This should have been formatted already.
     * @return      array       The generated field container attribute array.
     * @internal   
     * @since       3.5.3
     * @since       3.6.0       Moved from `AdminPageFramework_FormFieldset`.
     * @return      array
     */
    protected function _getAttributes() {

        return array(
            'id'            => $this->aFieldset[ '_field_container_id' ],
            'data-type'     => $this->aFieldset[ 'type' ],   // referred by the repeatable field JavaScript script.
            // @deprecated 3.6.0 
            // 'data-id_model' => $this->aFieldset[ '_fields_container_id_model' ], // 3.3.1+
            'class'         => "admin-page-framework-field admin-page-framework-field-" . $this->aFieldset[ 'type' ]
                . $this->getAOrB(
                    $this->aFieldset[ 'attributes' ][ 'disabled' ],
                    ' disabled',
                    ''
                )
                . $this->getAOrB(
                    $this->aFieldset[ '_is_sub_field' ],
                    ' admin-page-framework-subfield',
                    ''
                ) 
        );
        
    }
           
}