<?php

namespace Drupal\contract\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\NodeType;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\Core\File\FileSystemInterface;

/**
 * Provides a 'Hello' Block.
 */
/**
 * Provides a Custom Contract Block.
 *
 * @Block(
 *  id = "custom_contract_block",
 *  admin_label = @Translation("Contract Block"),
 * )
 */

class CustomContractBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $nids = \Drupal::entityQuery('node')
        ->accessCheck(FALSE)
        ->condition('type','contract')
        ->execute();
      $nodes = Node::loadMultiple($nids);
      $contract = [];
      foreach ($nodes as $key => $node_content) {
        $contract[$key]['title'] = $node_content->get('title')->value;
        $contract[$key]['body'] = $node_content->get('field_body')->value;
        $contract[$key]['document_title'] = $node_content->get('field_document_title')->value;
        $contract[$key]['recipient_name'] = $node_content->get('field_recipient_name')->value;
        $contract[$key]['sender_name'] = $node_content->get('field_sender_name')->value;
        $contract[$key]['contract_date'] = $node_content->get('field_contract_date')->value;
        $document_file = $node_content->get('field_document_file');
        $contract[$key]['file'] = \Drupal::service('file_url_generator')->generateAbsoluteString($document_file->entity->getFileUri());
      }

        return [
            '#contract_details' => $contract,
            '#theme' => 'contract_data',
            '#type' => 'markup',
            '#markup' => $this->t('You contract has been submitted successfully!'),
            '#attached' => [
                'library' => [
                  'contract/contract-libraries',
                ],
            ],
            '#cache' => ['max-age' => 0]
        ];
  }

}