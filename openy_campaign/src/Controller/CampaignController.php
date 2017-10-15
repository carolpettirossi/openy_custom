<?php

namespace Drupal\openy_campaign\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\openy_campaign\CampaignMenuServiceInterface;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\node\Entity\Node;
use Drupal\openy_campaign\Entity\MemberCampaign;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;


/**
 * Class CampaignController.
 */
class CampaignController extends ControllerBase {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilder
   */
  protected $formBuilder;

  /**
   * The Campaign menu service.
   *
   * @var \Drupal\openy_campaign\CampaignMenuServiceInterface
   */
  protected $campaignMenuService;

  /**
   * The CampaignController constructor.
   *
   * @param \Drupal\Core\Form\FormBuilder $formBuilder
   *   The form builder.
   * @param CampaignMenuServiceInterface $campaign_menu_service
   *   The Campaign menu service.
   */
  public function __construct(FormBuilder $formBuilder, CampaignMenuServiceInterface $campaign_menu_service) {
    $this->formBuilder = $formBuilder;
    $this->campaignMenuService = $campaign_menu_service;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('openy_campaign.campaign_menu_handler')
    );
  }

  /**
   * @param \Drupal\node\NodeInterface $node
   *
   * @return array Render array
   */
  public function showMembers(NodeInterface $node) {
    $build = [
      'view' => views_embed_view('campaign_members', 'campaign_members_page', $node->id()),
    ];

    return $build;
  }

  /**
   * @param \Drupal\node\NodeInterface $node
   *
   * @return array Render array
   */
  public function showWinners(NodeInterface $node) {
    $winnersList = views_embed_view('campaign_winners', 'campaign_winners_page', $node->id());
    $winnersCalculateForm = \Drupal::formBuilder()->getForm(\Drupal\openy_campaign\Form\WinnersCalculateForm::class, $node->id());

    $build = [
      'view' => $winnersList,
      'form' => $winnersCalculateForm,
    ];

    return $build;
  }

  /**
   * Checks access for a specific request.
   *
   * @param \Drupal\node\NodeInterface $node
   *   Node.
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResult
   */
  public function campaignPagesAccess(NodeInterface $node, AccountInterface $account) {
    return AccessResult::allowedIf($account->hasPermission('administer retention campaign') && $node->getType() == 'campaign');
  }

}