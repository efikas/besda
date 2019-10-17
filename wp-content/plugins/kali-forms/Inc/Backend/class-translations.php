<?php

namespace KaliForms\Inc\Backend;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Translations is used to translate stuff
 *
 * @package App\Libraries
 */
class Translations
{
    /**
     * Translations array
     *
     * @var array
     */
    public $translations = [];

    /**
     * Basic constructor
     *
     * Translations constructor
     */
    public function __construct()
    {
        $this->set_general_translations();
        $this->frontend();
        $this->backend();
    }

    /**
     * Set general translations
     *
     * @return array
     */
    public function set_general_translations()
    {
        $this->translations['general'] = [
            'yes' => esc_html__('Yes', 'kaliforms'),
            'no' => esc_html__('No', 'kaliforms'),
            'on' => esc_html__('On', 'kaliforms'),
            'off' => esc_html__('Off', 'kaliforms'),
            'back' => esc_html__('Back', 'kaliforms'),
            'save' => esc_html__('Save', 'kaliforms'),
            'edit' => esc_html__('Edit', 'kaliforms'),
            'delete' => esc_html__('Delete', 'kaliforms'),
            'addChoice' => esc_html__('Add choice', 'kaliforms'),
            'value' => esc_html__('Value', 'kaliforms'),
            'label' => esc_html__('Label', 'kaliforms'),
            'import' => esc_html__('Import', 'kaliforms'),
            'price' => esc_html__('Price', 'kaliforms'),
            'addProduct' => esc_html__('Add product', 'kaliforms'),
            'name' => esc_html__('Name', 'kaliforms'),
            'description' => esc_html__('Description', 'kaliforms'),
            'actions' => esc_html__('Actions', 'kaliforms'),
            'loadTemplate' => esc_html__('Load template', 'kaliforms'),
            'upgradeToPro' => esc_html__('Upgrade to Pro', 'kaliforms'),
        ];
    }

    public function frontend()
    {
        $this->translations['frontend'] = [
            'general' => [
                'loading' => esc_html__('LOADING', 'kaliforms'),
            ],
            'filePond' => [
                'labelIdle' => sprintf(
                    '%s <span class="filepond--label-action"> %s </span>',
                    esc_html__('Drag & Drop your files or', 'kaliforms'),
                    esc_html__('Browse', 'kaliforms')
                ),
                'labelInvalidField' => esc_html__('Field contains invalid files', 'kaliforms'),
                'labelFileWaitingForSize' => esc_html__('Waiting for size', 'kaliforms'),
                'labelFileSizeNotAvailable' => esc_html__('Size not available', 'kaliforms'),
                'labelFileLoading' => esc_html__('Loading', 'kaliforms'),
                'labelFileLoadError' => esc_html__('Error during load', 'kaliforms'),
                'labelFileProcessing' => esc_html__('Uploading', 'kaliforms'),
                'labelFileProcessingComplete' => esc_html__('Upload complete', 'kaliforms'),
                'labelFileProcessingAborted' => esc_html__('Upload cancelled', 'kaliforms'),
                'labelFileProcessingError' => esc_html__('Error during upload', 'kaliforms'),
                'labelFileProcessingRevertError' => esc_html__('Error during revert', 'kaliforms'),
                'labelFileRemoveError' => esc_html__('Error during remove', 'kaliforms'),
                'labelTapToCancel' => esc_html__('tap to cancel', 'kaliforms'),
                'labelTapToRetry' => esc_html__('tap to retry', 'kaliforms'),
                'labelTapToUndo' => esc_html__('tap to undo', 'kaliforms'),
                'labelButtonRemoveItem' => esc_html__('Remove', 'kaliforms'),
                'labelButtonAbortItemLoad' => esc_html__('Abort', 'kaliforms'),
                'labelButtonRetryItemLoad' => esc_html__('Retry', 'kaliforms'),
                'labelButtonAbortItemProcessing' => esc_html__('Cancel', 'kaliforms'),
                'labelButtonUndoItemProcessing' => esc_html__('Undo', 'kaliforms'),
                'labelButtonRetryItemProcessing' => esc_html__('Retry', 'kaliforms'),
                'labelButtonProcessItem' => esc_html__('Upload', 'kaliforms'),
            ],
        ];
    }

    public function backend()
    {
        $this->translations['appBar'] = [
            'backToWp' => esc_html__('Back to dashboard', 'kaliforms'),
            'formName' => esc_html__('Form name', 'kaliforms'),
            'formBuilder' => esc_html__('Builder', 'kaliforms'),
            'formSettings' => esc_html__('Settings', 'kaliforms'),
        ];

        $this->translations['sidebar'] = [
            'addYourFirstField' => esc_html__('Add your first form field!', 'kaliforms'),
            'formFields' => esc_html__('Form fields', 'kaliforms'),
            'fieldProperties' => esc_html__('Field properties', 'kaliforms'),
            'general' => esc_html__('General', 'kaliforms'),
            'integrations' => esc_html__('Integrations', 'kaliforms'),
            'emailSettings' => esc_html__('Email settings', 'kaliforms'),
        ];

        $this->translations['builder'] = [
            'placeholderTitle' => esc_html__('Click the + icon in the sidebar to add new fields to the builder', 'kaliforms'),
            'placeholderButton' => esc_html__('Or select a pre-defined template', 'kaliforms'),
        ];

        $this->translations['templateSelector'] = [
            'placeholderTitle' => esc_html__('Select a pre-defined form', 'kaliforms'),
            'placeholderButton' => esc_html__('Or build one from scratch', 'kaliforms'),
        ];

        $this->translations['formEmails'] = [
            'addEmail' => esc_html__('Add email', 'kaliforms'),
            'removeEmail' => esc_html__('Remove email', 'kaliforms'),
            'fromName' => esc_html__('From name', 'kaliforms'),
            'fromEmail' => esc_html__('From email', 'kaliforms'),
            'toEmail' => esc_html__('To email', 'kaliforms'),
            'replyTo' => esc_html__('Reply to', 'kaliforms'),
            'ccEmail' => esc_html__('CC Email', 'kaliforms'),
            'bccEmail' => esc_html__('BCC Email', 'kaliforms'),
            'subject' => esc_html__('Email subject', 'kaliforms'),
            'subjectPlaceholder' => esc_html__('Hello World!', 'kaliforms'),
        ];

        $this->translations['formInfo'] = [
            // First Section
            'generalSettings' => esc_html__('General settings', 'kaliforms'),
            'requiredFieldMark' => esc_html__('Required field mark', 'kaliforms'),
            'multipleSelectionSeparator' => esc_html__('Multiple selection separator', 'kaliforms'),
            'removeCaptcha' => esc_html__('Remove captcha for logged user', 'kaliforms'),
            'showThankYou' => esc_html__('Show thank you message', 'kaliforms'),
            'globalErrorMessage' => esc_html__('Global error message', 'kaliforms'),
            'hideFormName' => esc_html__('Hide form name', 'kaliforms'),

            // Second section
            'afterFormSubmit' => esc_html__('After form submit', 'kaliforms'),
            'thankYouMessage' => esc_html__('Thank you message', 'kaliforms'),
            'redirectUrl' => esc_html__('Redirect URL', 'kaliforms'),

            // Form class and id
            'formClassAndId' => esc_html__('Form class and id', 'kaliforms'),
            'cssId' => esc_html__('CSS Id', 'kaliforms'),
            'cssClass' => esc_html__('CSS Class', 'kaliforms'),
        ];

        $this->translations['integrations'] = [
            'recaptchaSiteKey' => esc_html__('reCAPTCHA site key', 'kaliforms'),
            'recaptchaSecretKey' => esc_html__('reCAPTCHA secret key', 'kaliforms'),
            'paymentsGeneral' => esc_html__('Payments', 'kaliforms'),
            'currency' => esc_html__('Currency', 'kaliforms'),
            'paymentsLive' => esc_html__('Live transactions', 'kaliforms'),
            'payPalClientId' => esc_html__('PayPal client id', 'kaliforms'),
            'payPalClientIdSandBox' => esc_html__('PayPal sandbox client id', 'kaliforms'),
        ];

        $this->translations['conditionalLogic'] = [
			'placeholder' => sprintf(
				'%s <a href="https://kaliforms.com/docs/faq/how-to-hide-show-fields/" target="_blank"> %s </a>',
				esc_html__('You do not have any conditional statements configured at the moment.', 'kaliforms'),
				esc_html__('Learn how to create your first statement in our documentation.', 'kaliforms')
			),
            'add' => esc_html__('Add', 'kaliforms'),
            'currentField' => esc_html__('Current field', 'kaliforms'),
            'state' => esc_html__('State', 'kaliforms'),
            'ifThisField' => esc_html__('If this field', 'kaliforms'),
            'operator' => esc_html__('Operator', 'kaliforms'),
            'value' => esc_html__('Value', 'kaliforms'),
			'conditionalLogic' => esc_html__('Conditional logic', 'kaliforms'),
			'conditionalLogicSettings' => esc_html__('Conditional logic settings', 'kaliforms'),
            'show' => esc_html__('Show', 'kaliforms'),
            'hide' => esc_html__('Hide', 'kaliforms'),
            'equalTo' => esc_html__('Equal to', 'kaliforms'),
            'differentThan' => esc_html__('Different than', 'kaliforms'),
            'canBe' => esc_html__('Can be', 'kaliforms'),
            'field' => esc_html__('Field', 'kaliforms'),
            'state' => esc_html__('State', 'kaliforms'),
            'conditionedBy' => esc_html__('Conditioned by', 'kaliforms'),
            'if' => esc_html__('If', 'kaliforms'),
            'value' => esc_html__('Value', 'kaliforms'),
            'action' => esc_html__('Action', 'kaliforms'),
        ];

        $this->translations['customScripting'] = [
            'customCss' => esc_html__('Custom CSS', 'kaliforms'),
            'customJs' => esc_html__('Custom JavaScript', 'kaliforms'),
            'customPhp' => esc_html__('Custom PHP', 'kaliforms'),
            'phpBefore' => esc_html__('Before form process PHP script', 'kaliforms'),
            'phpAfter' => esc_html__('After form process PHP script', 'kaliforms'),
        ];
    }
}
