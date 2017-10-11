<?php

namespace Drupal\htt\EventSubscriber;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HttSubscriber extends ControllerBase implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['CheckAlias', 10];
    return $events;
  }

  public function CheckAlias(GetResponseEvent $event) {
    //$current_path = \Drupal::service('path.current')->getPath();
    $current_path = $_SERVER['REQUEST_URI'];
    $alas = \Drupal::service('path.alias_manager')->getAliasByPath($current_path);
    if($current_path != $alas){
      $event->setResponse(new RedirectResponse($alas));      
    }
  }

}