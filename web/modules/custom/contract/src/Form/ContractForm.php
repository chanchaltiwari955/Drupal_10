<?php

namespace Drupal\contract\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Url;

class ContractForm extends FormBase {
    public function getFormId() {
        return 'contract_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#required' => TRUE,
        ];

        $form['body'] = [    
            '#type' => 'textarea',
            '#title' => $this->t('Body'),
            '#required' => TRUE,
        ];
        $form['document_title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Document Title'),
            '#required' => TRUE,
        ];
        $form['recipient_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Reciepient Name'),
            '#required' => TRUE,
        ];
        $form['sender_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Sender Name'),
            '#required' => TRUE,
        ];
        $form['contract_date'] = [
            '#type' => 'date',
            '#title' => $this->t('Contract Date'),
            '#required' => TRUE,
        ];
        $form['document_file'] = [
            '#type' => 'managed_file',
            '#title' => $this->t('Document File'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];
        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        $node = Node::create([
            'type' => 'contract',
            'title' => $values['title'],
            'field_body' => $values['body'],
            'field_document_title' => $values['document_title'],
            'field_recipient_name' => $values['recipient_name'],
            'field_sender_name' => $values['sender_name'],
            'field_contract_date' => $values['contract_date'],
            'field_document_file' => $values['document_file'],
        ]);
        $node->save();

        $confirmation_url = Url::fromRoute('contract.confirmation');
        $form_state->setRedirectUrl($confirmation_url);
    }
}
