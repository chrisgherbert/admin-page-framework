<?php
abstract class AdminPageFramework_TaxonomyField_View extends AdminPageFramework_TaxonomyField_Model {
    public function _replyToGetInputNameAttribute() {
        $_aParams = func_get_args() + array(null, null, null);
        $_aField = $_aParams[1];
        $_sKey = ( string )$_aParams[2];
        $_sKey = $this->oUtil->getAOrB('0' !== $_sKey && empty($_sKey), '', "[{$_sKey}]");
        return $_aField['field_id'] . $_sKey;
    }
    public function _replyToGetFlatInputName() {
        $_aParams = func_get_args() + array(null, null, null);
        $_aField = $_aParams[1];
        $_sKey = ( string )$_aParams[2];
        $_sKey = $this->oUtil->getAOrB('0' !== $_sKey && empty($_sKey), '', "|{$_sKey}");
        return "{$_aField['field_id']}{$_sKey}";
    }
    public function _replyToPrintFieldsWOTableRows($oTerm) {
        echo $this->_getFieldsOutput(isset($oTerm->term_id) ? $oTerm->term_id : null, false);
    }
    public function _replyToPrintFieldsWithTableRows($oTerm) {
        echo $this->_getFieldsOutput(isset($oTerm->term_id) ? $oTerm->term_id : null, true);
    }
    private function _getFieldsOutput($iTermID, $bRenderTableRow) {
        $_aOutput = array();
        $_aOutput[] = wp_nonce_field($this->oProp->sClassHash, $this->oProp->sClassHash, true, false);
        $this->_setOptionArray($iTermID, $this->oProp->sOptionKey);
        $_oFieldsTable = new AdminPageFramework_FormPart_Table($this->oProp->aFieldTypeDefinitions, $this->_getFieldErrors(), $this->oMsg);
        $_aOutput[] = $bRenderTableRow ? $_oFieldsTable->getFieldsetRows($this->oForm->aConditionedFields['_default'], array($this, '_replyToGetFieldOutput')) : $_oFieldsTable->getFieldsets($this->oForm->aConditionedFields['_default'], array($this, '_replyToGetFieldOutput'));
        $_sOutput = $this->oUtil->addAndApplyFilters($this, 'content_' . $this->oProp->sClassName, implode(PHP_EOL, $_aOutput));
        $this->oUtil->addAndDoActions($this, 'do_' . $this->oProp->sClassName, $this);
        return $_sOutput;
    }
    public function _replyToPrintColumnCell($vValue, $sColumnSlug, $sTermID) {
        $_sCellHTML = '';
        if (isset($_GET['taxonomy']) && $_GET['taxonomy']) {
            $_sCellHTML = $this->oUtil->addAndApplyFilter($this, "cell_{$_GET['taxonomy']}", $vValue, $sColumnSlug, $sTermID);
        }
        $_sCellHTML = $this->oUtil->addAndApplyFilter($this, "cell_{$this->oProp->sClassName}", $_sCellHTML, $sColumnSlug, $sTermID);
        $_sCellHTML = $this->oUtil->addAndApplyFilter($this, "cell_{$this->oProp->sClassName}_{$sColumnSlug}", $_sCellHTML, $sTermID);
        echo $_sCellHTML;
    }
}