<?php

class GAE_Core_Block_Db_Type_CloudSql extends Mage_Install_Block_Db_Type_Mysql4
{
    /**
     * Db title
     *
     * @var string
     */
    protected $_title = 'CloudSql';

    protected function _toHtml()
    {
        $html = parent::_toHtml();
        try {
            Mage::log('message', Zend_Log::WARN, 'system.log', true);
            Mage::logException(new Exception('hello'));
        } catch (Exception $e) {

            echo $e;
        }

        return $html . $this->_getAdminHtml();
    }


    protected function _getAdminHtml()
    {
        ob_start();
        ?>
        <div class="page-head">
            <h3><?php echo $this->__('Create Admin Account') ?></h3>
        </div>
        <fieldset class="group-select wide">
            <legend><?php echo $this->__('Personal Information') ?></legend>
            <h4 class="legend"><?php echo $this->__('Personal Information') ?></h4>
            <ul>
                <li>
                    <div class="input-box">
                        <label for="firstname"><?php echo $this->__('First Name') ?> <span
                                class="required">*</span></label><br/>
                        <input type="text" name="admin[firstname]" id="firstname"
                               value="<?php echo $this->getFormData()->getFirstname() ?>"
                               title="<?php echo $this->__('First Name') ?>" class="required-entry input-text"/>
                    </div>
                    <div class="input-box">
                        <label for="lastname"><?php echo $this->__('Last Name') ?> <span
                                class="required">*</span></label><br/>
                        <input type="text" name="admin[lastname]" id="lastname"
                               value="<?php echo $this->getFormData()->getLastname() ?>"
                               title="<?php echo $this->__('Last Name') ?>" class="required-entry input-text"/>
                    </div>
                </li>
                <li>
                    <label for="email_address"><?php echo $this->__('Email') ?> <span
                            class="required">*</span></label><br/>
                    <input type="text" name="admin[email]" id="email_address"
                           value="<?php echo $this->getFormData()->getEmail() ?>"
                           title="<?php echo $this->__('Email Address') ?>"
                           class="validate-email required-entry input-text"/>
                </li>
            </ul>
        </fieldset>
        <fieldset class="group-select wide">
            <legend><?php echo $this->__('Login Information') ?></legend>
            <h4 class="legend"><?php echo $this->__('Login Information') ?></h4>
            <ul>
                <li>
                    <label for="username"><?php echo $this->__('Username') ?> <span
                            class="required">*</span></label><br/>
                    <input type="text" name="admin[username]" id="username"
                           value="<?php echo $this->getFormData()->getUsername() ?>"
                           title="<?php echo $this->__('Username') ?>" class="required-entry input-text"/>
                </li>
                <li>
                    <div class="input-box">
                        <label for="password"><?php echo $this->__('Password') ?> <span
                                class="required">*</span></label><br/>
                        <input type="password" name="admin[new_password]" id="password"
                               title="<?php echo $this->__('Password') ?>"
                               class="required-entry validate-admin-password input-text"/>
                    </div>
                    <div class="input-box">
                        <label for="confirmation"><?php echo $this->__('Confirm Password') ?> <span
                                class="required">*</span></label><br/>
                        <input type="password" name="admin[password_confirmation]"
                               title="<?php echo $this->__('Password Confirmation') ?>" id="confirmation"
                               class="required-entry validate-cpassword input-text"/>
                    </div>
                </li>
            </ul>
        </fieldset>
        <fieldset class="group-select wide">
            <legend><?php echo $this->__('Encryption Key') ?></legend>
            <h4 class="legend"><?php echo $this->__('Encryption Key') ?></h4>
            <ul>
                <li>
                    <input type="text" name="encryption_key" id="encryption_key"
                           value="<?php echo $this->getFormData()->getEncryptionKey() ?>"
                           title="<?php echo $this->__('Encryption Key') ?>" class="input-text"/>

                    <p style="margin-top:4px; line-height:1.3em; color:#666;">
                        <small><?php echo $this->__('Magento uses this key to encrypt passwords, credit cards and more. If this field is left empty the system will create an encryption key for you and will display it on the next page.') ?></small>
                    </p>
                </li>
            </ul>
        </fieldset>
        <?php
        return ob_get_clean();
    }


}